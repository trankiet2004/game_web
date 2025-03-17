document.querySelectorAll('.slider_3d .item img').forEach(img => {
    img.addEventListener('click', function(){
      const clickedSrc = this.getAttribute('src');
      
      const modelDiv = document.querySelector('.banner .content .model');
      
      let modelBg = window.getComputedStyle(modelDiv).backgroundImage;
      if(modelBg.startsWith('url(')){
          modelBg = modelBg.slice(4, -1).replace(/"/g, "");
      }
      
      modelDiv.style.backgroundImage = `url(${clickedSrc})`;
      this.setAttribute('src', modelBg);
    });
});


const navEl = document.querySelector('.navbar');

window.addEventListener('scroll', () => {
    if (window.scrollY >= 56) {
        navEl.classList.add('navbar-scrolled')
    } else if (window.scrollY < 56) {
        navEl.classList.remove('navbar-scrolled')
    }
});

