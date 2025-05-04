import mysql.connector
import re

# Connect to the MySQL database
conn = mysql.connector.connect(
    host="localhost",            # Your database host (e.g., localhost)
    user="root",        # Your MySQL username
    password="",    # Your MySQL password
    database="game_website"      # Name of the database
)

cursor = conn.cursor()

# Fetch all rows from the 'tag' table
cursor.execute("SELECT id, description FROM developers")
rows = cursor.fetchall()

# Iterate through each row and clean the description
for row in rows:
    tag_id = row[0]
    description = row[1]

    # Remove <p> and </p> tags from the description
    cleaned_description = re.sub(r'</?p>', '', description)

    # Update the row with the cleaned description
    cursor.execute("UPDATE developers SET description = %s WHERE id = %s", (cleaned_description, tag_id))

# Commit the changes to the database
conn.commit()

# Close the cursor and connection
cursor.close()
conn.close()

print("Descriptions updated successfully.")
