document.querySelectorAll('.slider_3d .item img').forEach(img => {
    img.addEventListener('click', function(){
      const clickedSrc = this.getAttribute('src');
      const heroName = this.getAttribute('alt');
      
      const modelDiv = document.querySelector('.banner .content .model');
      
      let modelBg = window.getComputedStyle(modelDiv).backgroundImage;
      if(modelBg.startsWith('url(')){
          modelBg = modelBg.slice(4, -1).replace(/"/g, "");
      }
      
      modelDiv.style.backgroundImage = `url(${clickedSrc})`;
      // Store the current hero name as a data attribute on the model div
      modelDiv.setAttribute('data-hero', heroName);
      this.setAttribute('src', modelBg);
      
      // Extract the previous hero name from the model image URL
      const prevImagePath = modelBg.split('/').pop();
      const prevHeroMatch = prevImagePath.match(/marvel_rivals_(.+?)\.(webp|png)/);
      let prevHero = "";
      
      if (prevHeroMatch && prevHeroMatch[1]) {
          // Convert snake_case to Title Case
          prevHero = prevHeroMatch[1].split('_').map(word => 
              word.charAt(0).toUpperCase() + word.slice(1)
          ).join(' ');
          
          // Special case for specific heroes
          if (prevHero === "Doctor Strange") prevHero = "Doctor Strange";
          else if (prevHero === "Black Panther") prevHero = "Black Panther";
          else if (prevHero === "Captain America") prevHero = "Captain America";
          else if (prevHero === "Spider Man") prevHero = "Spider-Man";
      }
      
      // Find the matching slider image and update its alt
      document.querySelectorAll('.slider_3d .item img').forEach(sliderImg => {
          if (sliderImg.getAttribute('src') === modelBg) {
              sliderImg.setAttribute('alt', prevHero);
          }
      });
    });
});

// Hero descriptions for the model
const heroDescriptions = {
    "Hulk": "The strongest Avenger, Dr. Bruce Banner transforms into the unstoppable Hulk when angered. With unmatched strength and durability, he can smash through any obstacle.",
    "Loki": "The God of Mischief and Thor's adopted brother. Loki is a master of illusion and deception, using his cunning intellect and magical abilities to manipulate his foes.",
    "Scarlet Witch": "Wanda Maximoff possesses reality-altering chaos magic. Her telekinetic and telepathic abilities make her one of the most powerful beings in the Marvel universe.",
    "Storm": "Ororo Munroe can control the weather, conjuring lightning, wind, and other atmospheric phenomena. A natural leader with command over the elements.",
    "Black Panther": "T'Challa, king of Wakanda, uses the heart-shaped herb and vibranium suit to gain enhanced strength, speed, and reflexes. A skilled tactician and warrior.",
    "Captain America": "Steve Rogers, a super-soldier with peak human abilities, leads through example with unwavering moral conviction. His vibranium shield is both offense and defense.",
    "Spider-Man": "Peter Parker possesses superhuman strength, agility, and spider-sense that alerts him to danger. A genius inventor who combines wit with incredible reflexes.",
    "Venom": "A symbiote that grants its host enhanced strength, shapeshifting abilities, and organic webbing. Venom is both brutal and unpredictable in combat.",
    "Doctor Strange": "Master of the Mystic Arts Stephen Strange protects reality itself. His magical capabilities include time manipulation, astral projection, and interdimensional travel.",
    "Hela": "The Goddess of Death and Thor's sister, Hela possesses immense strength, durability, and the ability to manifest weapons. Her power grows the longer she's in Asgard.",
    "Iron Man": "Tony Stark, genius billionaire inventor, fights in a powered armor suit equipped with advanced technology. His intellect is his greatest weapon as he constantly upgrades his suit with new capabilities."
};

document.addEventListener("DOMContentLoaded", function () {
    // Set initial hero for the model (Iron Man)
    const modelDiv = document.querySelector('.banner .content .model');
    modelDiv.setAttribute('data-hero', 'Iron Man');
    
    // Add mouse events to the model div
    const descriptionContainer = document.querySelector('.hero-description');
    
    modelDiv.addEventListener('mouseenter', function() {
        const currentHero = this.getAttribute('data-hero');
        if (heroDescriptions[currentHero]) {
            descriptionContainer.textContent = heroDescriptions[currentHero];
            descriptionContainer.classList.add('active');
        }
    });
    
    modelDiv.addEventListener('mouseleave', function() {
        descriptionContainer.classList.remove('active');
    });
    
    // Typing animation for hero subtitle
    const typingTextElement = document.querySelector('.typing-text');
    if (typingTextElement) {
        const phrases = [
            "Your Ultimate Gaming Destination",
            "Discover Amazing Game Worlds",
            "Join Our Gaming Community",
            "Experience The Best Games"
        ];
        
        let phraseIndex = 0;
        let charIndex = 0;
        let isDeleting = false;
        let typingSpeed = 100;
        
        function typeText() {
            const currentPhrase = phrases[phraseIndex];
            
            if (isDeleting) {
                // Deleting text
                typingTextElement.textContent = currentPhrase.substring(0, charIndex - 1);
                charIndex--;
                typingSpeed = 50;
            } else {
                // Typing text
                typingTextElement.textContent = currentPhrase.substring(0, charIndex + 1);
                charIndex++;
                typingSpeed = 100;
            }
            
            // If we've typed the full phrase
            if (!isDeleting && charIndex === currentPhrase.length) {
                // Pause at the end of typing
                isDeleting = true;
                typingSpeed = 1500; // Wait before deleting
            } 
            // If we've deleted the full phrase
            else if (isDeleting && charIndex === 0) {
                isDeleting = false;
                phraseIndex = (phraseIndex + 1) % phrases.length; // Move to next phrase
                typingSpeed = 500; // Pause before typing new phrase
            }
            
            setTimeout(typeText, typingSpeed);
        }
        
        // Start the typing animation
        setTimeout(typeText, 1000);
    }
    
    // Initialize particles.js
    if (document.getElementById('particles-js')) {
        particlesJS('particles-js', {
            "particles": {
                "number": {
                    "value": 80,
                    "density": {
                        "enable": true,
                        "value_area": 800
                    }
                },
                "color": {
                    "value": "#ffffff"
                },
                "shape": {
                    "type": "circle",
                    "stroke": {
                        "width": 0,
                        "color": "#000000"
                    },
                    "polygon": {
                        "nb_sides": 5
                    }
                },
                "opacity": {
                    "value": 0.5,
                    "random": false,
                    "anim": {
                        "enable": false,
                        "speed": 1,
                        "opacity_min": 0.1,
                        "sync": false
                    }
                },
                "size": {
                    "value": 3,
                    "random": true,
                    "anim": {
                        "enable": false,
                        "speed": 40,
                        "size_min": 0.1,
                        "sync": false
                    }
                },
                "line_linked": {
                    "enable": true,
                    "distance": 150,
                    "color": "#ffffff",
                    "opacity": 0.4,
                    "width": 1
                },
                "move": {
                    "enable": true,
                    "speed": 6,
                    "direction": "none",
                    "random": false,
                    "straight": false,
                    "out_mode": "out",
                    "bounce": false,
                    "attract": {
                        "enable": false,
                        "rotateX": 600,
                        "rotateY": 1200
                    }
                }
            },
            "interactivity": {
                "detect_on": "canvas",
                "events": {
                    "onhover": {
                        "enable": true,
                        "mode": "grab"
                    },
                    "onclick": {
                        "enable": true,
                        "mode": "push"
                    },
                    "resize": true
                },
                "modes": {
                    "grab": {
                        "distance": 140,
                        "line_linked": {
                            "opacity": 1
                        }
                    },
                    "bubble": {
                        "distance": 400,
                        "size": 40,
                        "duration": 2,
                        "opacity": 8,
                        "speed": 3
                    },
                    "repulse": {
                        "distance": 200,
                        "duration": 0.4
                    },
                    "push": {
                        "particles_nb": 4
                    },
                    "remove": {
                        "particles_nb": 2
                    }
                }
            },
            "retina_detect": true
        });
    }
    
    // Add smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            
            const targetId = this.getAttribute('href');
            if (targetId === '#') return;
            
            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                targetElement.scrollIntoView({
                    behavior: 'smooth'
                });
            }
        });
    });
    
    // Header and footer components removed
    
    const iframe = document.querySelector("iframe");
    
    // Check if iframe exists before trying to access it
    if (!iframe) {
        console.log("No iframe found on this page");
    } else {
        if ("IntersectionObserver" in window) {
            let observer = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        iframe.src = iframe.getAttribute("data-src");
                        observer.unobserve(iframe);
                    }
                });
            });

            observer.observe(iframe);
        } else {
            iframe.src = iframe.getAttribute("data-src");
        }
    }
});

function loadComponent(id, file) {
    fetch(file)
        .then(response => response.text())
        .then(data => {
            document.getElementById(id).innerHTML = data;
        })
        .catch(error => console.error(`Lỗi khi tải ${file}:`, error));
}

document.addEventListener("DOMContentLoaded", function () {
    loadComponent("header", "../component/header.php");
    loadComponent("footer", "../component/footer.php");
});