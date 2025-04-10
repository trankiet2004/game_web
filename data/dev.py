import mysql.connector
import requests
import time
from urllib.parse import urlparse
import os
import random
# === CONFIGURATION ===
DB_HOST = 'localhost'
DB_USER = 'root'
DB_PASS = ''
DB_NAME = 'game_website'

API_KEY = '6e3005eb99cb49928ee1297f87a5f72d'
BASE_LIST_URL = f'https://api.rawg.io/api/games?key={API_KEY}&page_size=110'
DETAIL_URL = 'https://api.rawg.io/api/games/{}?key=' + API_KEY
ENTITY_DETAIL_URL = 'https://api.rawg.io/api/{}/{}?key=' + API_KEY
IMG_ROOT = os.path.join ('img')


# === UTILS ===
def download_image(url, folder, entity_id, suffix=None):
    if not url:
        return None

    parsed_url = urlparse(url)
    ext = os.path.splitext(parsed_url.path)[-1] or ".jpg"

    # Generate filename
    if suffix:
        filename = f"{entity_id}_{suffix}{ext}"
    else:
        filename = f"{entity_id}{ext}"

    path = os.path.join(IMG_ROOT, folder)
    os.makedirs(path, exist_ok=True)
    filepath = os.path.join(path, filename)

    try:
        response = requests.get(url)
        response.raise_for_status()
        with open(filepath, 'wb') as f:
            f.write(response.content)

        # Return relative path for DB: 'data/img/screenshots/...'
        return os.path.relpath(filepath, start='game_web').replace("\\", "/")

    except Exception as e:
        print(f"Failed to download image {url}: {e}")
        return None


def save_game_screenshots(cursor, game_id):
    url = f"https://api.rawg.io/api/games/{game_id}/screenshots?key={API_KEY}"
    response = requests.get(url)
    if response.status_code == 200:
        data = response.json()
        screenshots = data.get('results', [])
        for shot in screenshots:
            image_url = shot.get('image')
            shot_id = shot.get('id')  # RAWG screenshot ID
            if image_url and shot_id:
                filename = f"{game_id}_screenshot_{shot_id}.jpg"
                path = download_image(image_url, "screenshots", filename)
                if path:
                    # Check for duplicates first
                    cursor.execute("SELECT 1 FROM Game_Screenshots WHERE game_id = %s AND img_path = %s", (game_id, path))
                    if cursor.fetchone() is None:
                        cursor.execute("INSERT INTO Game_Screenshots (game_id, img_path) VALUES (%s, %s)", (game_id, path))

                    
# === MYSQL SETUP ===
def setup_database():
    conn = mysql.connector.connect(host=DB_HOST, user=DB_USER, password=DB_PASS)
    cursor = conn.cursor()
    # cursor.execute(f"DROP DATABASE {DB_NAME}")

    cursor.execute(f"CREATE DATABASE IF NOT EXISTS {DB_NAME}")
    conn.database = DB_NAME

    cursor.execute("""CREATE TABLE IF NOT EXISTS Games (
        id INT PRIMARY KEY,
        name VARCHAR(255),
        slug VARCHAR(255),
        released DATE,
        rating FLOAT,
        description TEXT,
        background_image TEXT,
        website TEXT,
        updated DATE,
        rating_sum INT,
        price FLOAT,
        metacritic INT
    )""")

    cursor.execute("""
    CREATE TABLE IF NOT EXISTS GameRatings (
        game_id INT PRIMARY KEY,
        exceptional INT DEFAULT 0,
        recommended INT DEFAULT 0,
        meh INT DEFAULT 0,
        skip INT DEFAULT 0,
        FOREIGN KEY (game_id) REFERENCES Games(id) ON DELETE CASCADE
    )
""")
    cursor.execute("""CREATE TABLE IF NOT EXISTS Developers (
        id INT PRIMARY KEY,
        name VARCHAR(100),
        slug VARCHAR(255),
        game_count INT DEFAULT 0,
        background_image TEXT,
        description TEXT
    )""")

    cursor.execute("""CREATE TABLE IF NOT EXISTS Genres (
        id INT PRIMARY KEY,
        name VARCHAR(100),
        slug VARCHAR(255),
        game_count INT DEFAULT 0,
        background_image TEXT,
        description TEXT
    )""")

    cursor.execute("""CREATE TABLE IF NOT EXISTS Platforms (
        id INT PRIMARY KEY,
        name VARCHAR(100),
        slug VARCHAR(255),
        game_count INT DEFAULT 0,
        background_image TEXT,
        description TEXT
    )""")

    cursor.execute("""CREATE TABLE IF NOT EXISTS Tags (
        id INT PRIMARY KEY,
        name VARCHAR(100),
        slug VARCHAR(255),
        game_count INT DEFAULT 0,
        background_image TEXT
    )""")

    cursor.execute("""CREATE TABLE IF NOT EXISTS Game_Developer (
        game_id INT,
        developer_id INT,
        PRIMARY KEY (game_id, developer_id),
        FOREIGN KEY (game_id) REFERENCES Games(id),
        FOREIGN KEY (developer_id) REFERENCES Developers(id)
    )""")

    cursor.execute("""CREATE TABLE IF NOT EXISTS Game_Genre (
        game_id INT,
        genre_id INT,
        PRIMARY KEY (game_id, genre_id),
        FOREIGN KEY (game_id) REFERENCES Games(id),
        FOREIGN KEY (genre_id) REFERENCES Genres(id)
    )""")

    cursor.execute("""CREATE TABLE IF NOT EXISTS Game_Platform (
        game_id INT,
        platform_id INT,
        PRIMARY KEY (game_id, platform_id),
        FOREIGN KEY (game_id) REFERENCES Games(id),
        FOREIGN KEY (platform_id) REFERENCES Platforms(id)
    )""")

    cursor.execute("""CREATE TABLE IF NOT EXISTS Game_Tag (
        game_id INT,
        tag_id INT,
        PRIMARY KEY (game_id, tag_id),
        FOREIGN KEY (game_id) REFERENCES Games(id),
        FOREIGN KEY (tag_id) REFERENCES Tags(id)
    )""")
    
    # cursor.execute("DROP TABLE Game_Screenshots")
    
    cursor.execute("""CREATE TABLE IF NOT EXISTS Game_Screenshots (
        game_id INT,
        img_path VARCHAR(500),
        PRIMARY KEY (game_id, img_path),
        FOREIGN KEY (game_id) REFERENCES Games(id)  ON DELETE CASCADE
    )""")

    conn.commit()
    return conn, cursor


def fetch_entity_details(entity, entity_id):
    url = ENTITY_DETAIL_URL.format(entity, entity_id)
    try:
        return requests.get(url).json()
    except Exception as e:
        print(f"Failed to fetch {entity} {entity_id}: {e}")
        return {}

# === SAVE METHODS ===
def insert_ignore(cursor, query, values):
    try:
        cursor.execute(query, values)
    except mysql.connector.IntegrityError:
        pass


def save_game_details(cursor, game):
    print("Insert game " + str(game['id']))

    # === Download Game Background Image ===
    game_img_path = download_image(game.get('background_image'), 'games', f"game{game['id']}")
    print(f"Game {game['id']} background image URL: {game.get('background_image')}")
    print(game_img_path)
    # === Insert Game ===
    cursor.execute("""
        INSERT INTO Games (id, name, slug, released, rating, description, background_image, website, updated, rating_sum, price, metacritic)
        VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)
        ON DUPLICATE KEY UPDATE name=VALUES(name), background_image=VALUES(background_image)
    """, (
        game['id'], game['name'], game['slug'], game.get('released'),
        game.get('rating'), game.get('description_raw'), game_img_path,
        game.get('website'), game.get('updated'), game.get('ratings_count'), round(random.uniform(0, 10), 2), game.get('metacritic')
    ))

    # === Insert Game Ratings ===
    rating_map = {r['title'].lower(): r['count'] for r in game.get('ratings', [])}
    cursor.execute("""
        INSERT INTO GameRatings (game_id, exceptional, recommended, meh, skip)
        VALUES (%s, %s, %s, %s, %s)
        ON DUPLICATE KEY UPDATE exceptional=VALUES(exceptional), recommended=VALUES(recommended),
        meh=VALUES(meh), skip=VALUES(skip)
    """, (
        game['id'], rating_map.get('exceptional', 0), rating_map.get('recommended', 0),
        rating_map.get('meh', 0), rating_map.get('skip', 0)
    ))

    # === Collect Unique IDs from game detail ===
    dev_ids = {dev['id'] for dev in game.get('developers', [])}
    genre_ids = {genre['id'] for genre in game.get('genres', [])}
    platform_ids = {p['platform']['id'] for p in game.get('platforms', [])}
    tag_ids = {tag['id'] for tag in game.get('tags', [])}


    # === Insert Developers ===
    print("Insert game dev" + str(game['id']))
    for dev_id in dev_ids:
        full_dev = fetch_entity_details("developers", dev_id)
        if full_dev:
            img_path = download_image(full_dev.get('image_background'), 'developers', f"developer{dev_id}")
            insert_ignore(cursor, """
                INSERT INTO Developers (id, name, slug, game_count, background_image, description)
                VALUES (%s, %s, %s, %s, %s, %s)
            """, (
                full_dev['id'], full_dev['name'], full_dev['slug'], full_dev.get('games_count', 0),
                img_path, full_dev.get('description')
            ))

    # === Insert Genres ===
    print("Insert game genres " + str(game['id']))
    for genre_id in genre_ids:
        full_genre = fetch_entity_details("genres", genre_id)
        if full_genre:
            img_path = download_image(full_genre.get('image_background'), 'genres', f"genre{genre_id}")
            insert_ignore(cursor, """
                INSERT INTO Genres (id, name, slug, game_count, background_image, description)
                VALUES (%s, %s, %s, %s, %s, %s)
            """, (
                full_genre['id'], full_genre['name'], full_genre['slug'], full_genre.get('games_count', 0),
                img_path, full_genre.get('description')
            ))

    # === Insert Platforms ===
    print("Insert game pf " + str(game['id']))
    
    for platform_id in platform_ids:
        full_platform = fetch_entity_details("platforms", platform_id)
        if full_platform:
            img_path = download_image(full_platform.get('image_background'), 'platforms', f"platform{platform_id}")
            insert_ignore(cursor, """
                INSERT INTO Platforms (id, name, slug, game_count, background_image, description)
                VALUES (%s, %s, %s, %s, %s, %s)
            """, (
                full_platform['id'], full_platform['name'], full_platform['slug'],
                full_platform.get('games_count', 0), img_path, full_platform.get('description')
            ))

    # === Insert Tags ===
    print("Insert game tag " + str(game['id']))
    
    for tag_id in tag_ids:
        full_tag = fetch_entity_details("tags", tag_id)
        if full_tag:
            img_path = download_image(full_tag.get('image_background'), 'tags', f"tag{tag_id}")
            insert_ignore(cursor, """
                INSERT INTO Tags (id, name, slug, game_count, background_image)
                VALUES (%s, %s, %s, %s, %s)
            """, (
                full_tag['id'], full_tag['name'], full_tag['slug'],
                full_tag.get('games_count', 0), img_path
            ))

    # === Game Screenshots ===
    print("Insert game screenshot " + str(game['id']))
    
    save_game_screenshots(cursor, game['id'])
    
    
    #first commit
    conn.commit()
    
    # === Insert Junction Tables first ===
    print("Insert game junction table " + str(game['id']))
    for dev_id in dev_ids:
        insert_ignore(cursor, "INSERT INTO Game_Developer (game_id, developer_id) VALUES (%s, %s)", (game['id'], dev_id))
    for genre_id in genre_ids:
        insert_ignore(cursor, "INSERT INTO Game_Genre (game_id, genre_id) VALUES (%s, %s)", (game['id'], genre_id))
    for platform_id in platform_ids:
        insert_ignore(cursor, "INSERT INTO Game_Platform (game_id, platform_id) VALUES (%s, %s)", (game['id'], platform_id))
    for tag_id in tag_ids:
        insert_ignore(cursor, "INSERT INTO Game_Tag (game_id, tag_id) VALUES (%s, %s)", (game['id'], tag_id))
    


# === DATA FETCHING ===
def fetch_and_store_games(cursor, limit=100):
    count = 0
    next_url = BASE_LIST_URL

    while next_url and count < limit:
        response = requests.get(next_url)
        data = response.json()
        for game in data['results']:
            if count >= limit:
                break

            game_id = game['id']
            detail_response = requests.get(DETAIL_URL.format(game_id))
            game_detail = detail_response.json()

            try:
                save_game_details(cursor, game_detail)
                conn.commit()
                print(f"Saved game {game_detail['name']} (#{count + 1})")
                count += 1
                time.sleep(0.5)  # Be kind to the API
            except Exception as e:
                print(f"Error saving game ID {game_id}: {e}")

        next_url = data.get('next')

folder_path = 'img/screenshots'

def modifyFilename():
    for filename in os.listdir(folder_path):
        if filename.endswith('.jpg.jpeg'):
            old_path = os.path.join(folder_path, filename)
            new_filename = filename.replace('.jpg.jpeg', '.jpeg')
            new_path = os.path.join(folder_path, new_filename)
            os.rename(old_path, new_path)
            print(f'Renamed: {filename} → {new_filename}')


import mysql.connector

def fix_screenshot_filenames_in_db(
    host="localhost",
    user="your_username",
    password="your_password",
    database="your_database"
):
    try:
        conn = mysql.connector.connect(
            host=host,
            user=user,
            password=password,
            database=database
        )
        cursor = conn.cursor()
        query = """
            UPDATE game_screenshots
            SET img_path = REPLACE(img_path, '.jpg.jpeg', '.jpeg')
            WHERE img_path LIKE '%.jpg.jpeg';
        """
        cursor.execute(query)
        conn.commit()
        print(f"{cursor.rowcount} rows updated.")
    except mysql.connector.Error as err:
        print(f"Error: {err}")
    finally:
        if conn.is_connected():
            cursor.close()
            conn.close()

# === MAIN EXECUTION ===
if __name__ == "__main__":
    # conn, cursor = setup_database()
    # fetch_and_store_games(cursor, limit=100)
    # conn.commit()
    # conn.close()
    modifyFilename();
    fix_screenshot_filenames_in_db(DB_HOST,DB_USER,DB_PASS,DB_NAME)
    print("Finished!")
