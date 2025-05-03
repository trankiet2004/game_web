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

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            }
        });
    }, {
        threshold: 0.1 
    });

    document.querySelectorAll('[data-scroll]').forEach((element) => {
        observer.observe(element);
    });
});