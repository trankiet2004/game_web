const feedbackItems = document.querySelectorAll('.feedback-item');
const faqItems = document.querySelectorAll('.faq-item');
const carouselBtns = document.querySelectorAll('.carousel-btn');

carouselBtns.forEach((btn) => {
    btn.addEventListener('click', () => {
    const target = btn.dataset.target;
    const index = parseInt(btn.dataset.index);
    
    if (target === 'feedback') {
        feedbackItems.forEach((item, i) => {
        item.classList.toggle('active', i === index);
        });
        
        // Update active button
        document.querySelectorAll(`.carousel-btn[data-target="feedback"]`).forEach((button, i) => {
        button.classList.toggle('active', i === index);
        });
    } else {
        faqItems.forEach((item, i) => {
        item.classList.toggle('active', i === index);
        });
        
        // Update active button
        document.querySelectorAll(`.carousel-btn[data-target="faq"]`).forEach((button, i) => {
        button.classList.toggle('active', i === index);
        });
    }
    });
});

// Office location selector
const officeBtns = document.querySelectorAll('.office-btn');
const officeDetails = document.querySelectorAll('.office-details');
const officeMap = document.getElementById('office-map');

// Map URLs for each office
const mapUrls = {
    1: "https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.511579457489!2d106.65790179999999!3d10.772075!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752ec3c161a3fb%3A0xef77cd47a1cc691e!2zVHLGsOG7nW5nIMSQ4bqhaSBo4buNYyBCw6FjaCBraG9hIC0gxJDhuqFpIGjhu41jIFF14buRYyBnaWEgVFAuSENN!5e0!3m2!1svi!2s!4v1742344973165!5m2!1svi!2s",
    2: "https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3918.092640350774!2d106.80255349181198!3d10.880558244095207!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3174d8a5568c997f%3A0xdeac05f17a166e0c!2zVHLGsOG7nW5nIMSQ4bqhaSBo4buNYyBCw6FjaCBraG9hIC0gxJBIUUcgVFAuSENN!5e0!3m2!1svi!2s!4v1742625536310!5m2!1svi!2s"
};

officeBtns.forEach((btn) => {
    btn.addEventListener('click', () => {
    const officeId = btn.dataset.office;
    
    // Update active button
    officeBtns.forEach((button) => {
        button.classList.toggle('active', button.dataset.office === officeId);
    });
    
    // Update visible office details
    officeDetails.forEach((details) => {
        details.classList.toggle('active', details.dataset.office === officeId);
    });
    
    // Update map
    officeMap.src = mapUrls[officeId];
    });
});