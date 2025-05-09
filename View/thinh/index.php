<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <base href="./View/thinh/">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BKGame</title>
    <link rel="icon" type="image/icon" href="../img/logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="index.css">

    <script>
        function loadComponent(id, file) {
          fetch(file)
          .then(response => response.text())
          .then(data => {
            document.getElementById(id).innerHTML = data;
        
            var linkFooter = document.createElement('link');
            linkFooter.rel = 'stylesheet';
            linkFooter.href = '../component/footer.css';
        
            document.head.appendChild(linkFooter);
          }).catch(error => console.error(`Lỗi khi tải ${file}:`, error));
        }
  
        document.addEventListener("DOMContentLoaded", function () {
          loadComponent("footer", "../component/footer.php");
        });
    </script>
</head>
<body>
    <div class="page-container">
        <div class="content-wrapper"> 
            <div id="header"></div>
            
            <div class="hero-section">
                <img class="bg-img" src="../img/index/index_bg.jpg" alt="">
                <div id="particles-js"></div>
                
                <div class="hero-content">
                    <h1 class="hero-title">Welcome to <span class="highlight">BKGame</span></h1>
                    <p class="hero-subtitle"><span class="typing-text"></span><span class="cursor">|</span></p>
                    <div class="hero-buttons">
                        <a href="#hot-games" class="hero-btn primary-btn">Explore Games</a>
                    </div>
                    <div class="scroll-indicator">
                        <span>Scroll Down</span>
                        <div class="scroll-arrow"></div>
                    </div>
                </div>
            </div>

            <div id="hot-games" class="slider" style="
            --width: 25vw;
            --height: 80vh;
            --quantity: 4;
            ">
                <div class="section_title">HOT GAMES</div>
                <div class="list" id="hot-games-card">
                    <div class="card" style="width: 25vw; --position: 1;">
                        <img src="../img/index/infinite_scroll/balatro_bg.jpg" class="card-img-top" alt="">
                        <div class="card-body">
                            <h3>Balatro</h3>
                            <p>Một trò chơi bài rogue-like độc đáo, nơi bạn xây dựng bộ bài poker mạnh mẽ và sử dụng chiến thuật thông minh để vượt qua các thử thách.</p>
                        </div>
                        <div class="d-flex">
                            <button class="btn btn-primary ms-auto">Xem chi tiết</button>
                        </div>
                    </div>
                    <div class="card" style="width: 25vw; --position: 3;">
                        <img src="../img/index/infinite_scroll/cs_bg.jpg" class="card-img-top" alt="">
                        <div class="card-body">
                            <h3>Counter-Strike (CS:GO)</h3>
                            <p>Một trong những tựa game bắn súng góc nhìn thứ nhất phổ biến nhất, với gameplay chiến thuật, nhịp độ nhanh và đòi hỏi kỹ năng cao. Hợp tác cùng đồng đội để giành chiến thắng trong các trận đấu căng thẳng.</p>
                        </div>
                        <div class="d-flex">
                            <button class="btn btn-primary ms-auto">Xem chi tiết</button>
                        </div>
                    </div>
                    <div class="card" style="width: 25vw; --position: 5;">
                        <img src="../img/index/infinite_scroll/dota2_bg.png" class="card-img-top" alt="">
                        <div class="card-body">
                            <h3>Dota 2</h3>
                            <p>Tựa game MOBA kinh điển của Valve với hệ thống tướng đa dạng, chiến thuật sâu sắc và những trận đấu đầy căng thẳng. Sử dụng kỹ năng và tư duy chiến lược để dẫn dắt đội của bạn đến chiến thắng.</p>
                        </div>
                        <div class="d-flex">
                            <button class="btn btn-primary ms-auto">Xem chi tiết</button>
                        </div>
                    </div>
                    <div class="card" style="width: 25vw; --position: 7;">
                        <img src="../img/index/infinite_scroll/lol_bg.jpg" class="card-img-top" alt="">
                        <div class="card-body">
                            <h3>League of Legends (LoL)</h3>
                            <p>Một trò chơi MOBA đình đám với hơn 150 vị tướng, nơi bạn có thể thể hiện kỹ năng cá nhân, tư duy chiến thuật và phối hợp đồng đội để kiểm soát bản đồ và phá hủy nhà chính của đối thủ.</p>
                        </div>
                        <div class="d-flex">
                            <button class="btn btn-primary ms-auto">Xem chi tiết</button>
                        </div>
                    </div>
                    <div class="card" style="width: 25vw; --position: 9;">
                        <img src="../img/index/infinite_scroll/genshin_bg.jpg" class="card-img-top" alt="">
                        <div class="card-body">
                            <h3>Genshin Impact</h3>
                            <p>Một tựa game nhập vai thế giới mở tuyệt đẹp, nơi bạn khám phá lục địa Teyvat, thu thập nhân vật mới, chiến đấu với kẻ địch và giải mã những bí ẩn trong hành trình của mình.</p>
                        </div>
                        <div class="d-flex">
                            <button class="btn btn-primary ms-auto">Xem chi tiết</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="latest_game">
                <div class="section_title">LATEST GAME</div>
                <div class="home">
                    <div class="bgvdo-box">
                        <video src="https://marvelrivals.v.easebar.com/2025/0112/s1.mp4" autoplay muted loop preload></video>
                    </div>
                    <div class="home_inner">
                        <div class="home_inner_logo"></div>
                        <div class="home_inner_slogan"></div>
                        <div class="platforms">
                            <a rel="nofollow" href="https://store.steampowered.com/app/2767030/Marvel_Rivals/" target="_blank" class="pf-steam"><img src="../img/index/latest_home/steam.png"></a>
                            <a rel="nofollow" href="https://store.playstation.com/en-us/concept/10010451/" target="_blank" class="pf-ps"><img src="../img/index/latest_home/ps5.png"></a>
                            <a rel="nofollow" href="https://www.microsoft.com/store/productid/9n8pmw7qmd3d" target="_blank" class="pf-xbox"><img src="../img/index/latest_home/xbox.png"></a>
                            <a rel="nofollow" href="https://store.epicgames.com/p/marvel-rivals-182004" target="_blank" class="pf-epic"><img src="../img/index/latest_home/epic.png"></a>
                        </div>
                    </div>
                    <div class="home_footer">Ready for battle? Choose your hero!</div>
                </div>
                <div class="banner">
                    <div class="slider_3d" style="--quantity: 10">
                        <div class="item" style="--position: 1"><img src="../img/index/latest_img/marvel_rivals_hulk.webp" alt="Hulk"></div>
                        <div class="item" style="--position: 2"><img src="../img/index/latest_img/marvel_rivals_loki.webp" alt="Loki"></div>
                        <div class="item" style="--position: 3"><img src="../img/index/latest_img/marvel_rivals_scarlet.png" alt="Scarlet Witch"></div>
                        <div class="item" style="--position: 4"><img src="../img/index/latest_img/marvel_rivals_storm.webp" alt="Storm"></div>
                        <div class="item" style="--position: 5"><img src="../img/index/latest_img/marvel_rivals_black_panther.png" alt="Black Panther"></div>
                        <div class="item" style="--position: 6"><img src="../img/index/latest_img/marvel_rivals_captain_america.webp" alt="Captain America"></div>
                        <div class="item" style="--position: 7"><img src="../img/index/latest_img/marvel_rivals_spider_man.webp" alt="Spider-Man"></div>
                        <div class="item" style="--position: 8"><img src="../img/index/latest_img/marvel_rivals_venom.webp" alt="Venom"></div>
                        <div class="item" style="--position: 9"><img src="../img/index/latest_img/marvel_rivals_doctor_strange.png" alt="Doctor Strange"></div>
                        <div class="item" style="--position: 10"><img src="../img/index/latest_img/marvel_rivals_hela.png" alt="Hela"></div>
                    </div>
                    <div class="hero-description-container">
                        <div class="hero-description"></div>
                    </div>
                    <div class="content">
                        <h1 data-content="MARVEL RIVALS">MARVEL RIVALS</h1>
                        <div class="model"></div>
                    </div>
                </div>
            </div>

            <div class="event">
                <div class="event_title">
                    <div class="explore_game_world">
                        <h2>Explore game world</h2>
                        <a href="#" class="button-standard button-standard--small button-standard--black button-standard--right">
                            <span>Xem tất cả</span>
                        </a>
                    </div>
                </div>
                <div class="event_wrapper">
                    <a href="#" class="event_hero_wrapper">
                        <div class="event_hero">
                            <div class="responsive_media" style="padding-bottom:50%">
                                <iframe 
                                    data-src="https://www.youtube.com/embed/Miu_akSity4?autoplay=1&mute=1&loop=1&playlist=Miu_akSity4" 
                                    frameborder="0" 
                                    allow="autoplay; fullscreen" 
                                    allowfullscreen>
                                </iframe>
                            </div>
                        </div>
                        <div class="event_hero_content">
                            <h3>Hades II Chính Thức Mở Early Access – Chuyến Phiêu Lưu Mới Trong Địa Ngục Bắt Đầu!</h3>
                        </div>
                    </a>
                    <ul class="articles">
                        <li class="articles">
                            <a href="#" class="article_card">
                                <div class="article_title_wrapper">
                                    <h3 class="article_title"> Xenoblade Chronicles X: Definitive Edition Review</h3>
                                </div>
                                <div class="article_image" style="background-image: url(../img/index/events/article_image_1.jpg);"></div>
                            </a>
                        </li>
                        <li class="articles">
                            <a href="#" class="article_card">
                                <div class="article_title_wrapper">
                                    <h3 class="article_title">Từ kẻ "Không biết chơi Poker" đến "Game Indie hay nhất 2024"</h3>
                                </div>
                                <div class="article_image" style="background-image: url(../img/index/events/article_image_2.jpg);"></div>
                            </a>
                        </li>
                        <li class="articles">
                            <a href="#" class="article_card">
                                <div class="article_title_wrapper">
                                    <h3 class="article_title">Nintendo Switch 2: Có đáng để mua hay không?</h3>
                                </div>
                                <div class="article_image" style="background-image: url(../img/index/events/article_image_3.webp);"></div>
                            </a>
                        </li>
                        <li class="articles">
                            <a href="#" class="article_card">
                                <div class="article_title_wrapper">
                                    <h3 class="article_title">Lịch sử phát triển Super Smash Bros</h3>
                                </div>
                                <div class="article_image" style="background-image: url(../img/index/events/article_image_4.jpg);"></div>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="careers">
                <div class="careers_content">
                    <div class="careers_content_inner">
                        <h2>Chúng tôi đang tuyển dụng!</h2>
                        <p>Hãy tham gia BKGame để xây dựng những trải nghiệm không thể quên cho người chơi</p>
                        <div class="careers_jobs">
                            <div class="careers_jobs_count">
                                <span>12</span>
                                Vị trí đang tuyển dụng
                            </div>
                            <div class="careers_jobs_count">
                                <span>2</span>
                                Văn phòng
                            </div>
                        </div>
                        <a href="#" class="button">
                            <span>Khám phá công việc</span>
                        </a>
                    </div>
                </div>
                <div class="careers_image">
                    <img src="../img/index/careers/image.webp" alt="">
                </div>
            </div>
        </div>
    </div>

    <footer id="footer" class="cyber-footer py-5" style="margin-top: 0;"></footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
    <script src="index.js"></script>

    <script>
        function getApiUrl(path) {
            const segments = window.location.pathname.split("/").filter(Boolean);
            const basePath = segments.length >= 2 ? `/${segments[0]}` : "";
            return `${window.location.origin}${basePath}/${path}`;
        }

        async function fetchData() {
            const URL_GAMES_API = new URL(getApiUrl("Controller/GamesController.php"));

            try {
                const formData = new URLSearchParams();
                formData.append("action", "load_products");

                const response = await fetch(URL_GAMES_API, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded"
                    },
                    body: formData
                });

                if (!response.ok) {
                    throw new Error(`Response status: ${response.status}`);
                }

                const json = await response.json();
                return json.data;
            } catch (error) {
                console.error("Error fetch:", error.message);
            }
        }

        document.addEventListener("DOMContentLoaded", async function() {
            const data = await fetchData();
            if (!data) return;
            let gameCardContainer = document.getElementById("hot-games-card");
            gameCardContainer.innerHTML = "";

            data.forEach((item, index) => {
                // if (index >= 10) return;

                const position = index * 2 + 1;
                let newGameCard = document.createElement("div");
                newGameCard.classList.add("card");
                newGameCard.setAttribute("style", `width: 25vw; --position: ${position};`);
                
                let newGameCardImg = document.createElement("img");
                newGameCardImg.classList.add("card-img-top");
                newGameCardImg.src = `../data/${item['background_image']}`;
                newGameCardImg.alt = item['slug'];
                
                let newGameCardBody = document.createElement("div");
                newGameCardBody.classList.add("card-body");
                
                let newGameCardBodyH3 = document.createElement("h3");
                newGameCardBodyH3.innerHTML = item['name'];
                
                let newGameCardBodyP = document.createElement("p");
                newGameCardBodyP.innerHTML = item['description'] ? item['description'] : "Mô tả game của bạn tại đây.";
                newGameCardBody.append(newGameCardBodyH3, newGameCardBodyP);
                
                let btnContainer = document.createElement("div");
                btnContainer.classList.add("d-flex");
                
                let newGameCardButton = document.createElement("button");
                newGameCardButton.classList.add("btn", "btn-primary", "ms-auto");
                newGameCardButton.innerHTML = "Xem chi tiết";
                btnContainer.appendChild(newGameCardButton);
                newGameCard.append(newGameCardImg, newGameCardBody, btnContainer);
                gameCardContainer.appendChild(newGameCard);
            });
        });
    </script>
</body>
</html>