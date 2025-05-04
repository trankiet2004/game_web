// blogs.js

// Mảng dữ liệu mẫu có thêm thuộc tính 'id' cho mỗi bài viết
let blogPosts = [
    {
        id: 0,
        title: "Làm sao để nâng cấp phần cứng?",
        content: "Mình muốn nâng cấp GPU để chơi game AAA, có bạn nào tư vấn giúp không?",
        author: "User123",
        time: "2 giờ trước",
        image: "../img/index/infinite_scroll/lol_bg.jpg"
    },
    {
        id: 1,
        title: "Cách tăng tốc máy tính chơi game",
        content: "Máy tính mình hơi chậm khi chơi game, có cách nào cải thiện hiệu suất không?",
        author: "User456",
        time: "3 giờ trước",
        image: "../img/index/infinite_scroll/lol_bg.jpg"
    },
    {
        id: 2,
        title: "Tư vấn chọn laptop chơi game",
        content: "Chọn laptop chơi game với giá dưới 20 triệu, có ai có kinh nghiệm không?",
        author: "Admin",
        time: "5 giờ trước",
        image: "../img/index/infinite_scroll/lol_bg.jpg"
    },
    {
        id: 3,
        title: "Hướng dẫn xây dựng máy tính chơi game",
        content: "Chia sẻ cách lắp ráp máy tính chơi game từ các linh kiện phổ biến nhất hiện nay.",
        author: "User789",
        time: "7 giờ trước",
        image: "../img/index/infinite_scroll/lol_bg.jpg"
    },
    {
        id: 4,
        title: "Phần mềm hỗ trợ chơi game tốt nhất",
        content: "Những phần mềm giúp tối ưu trải nghiệm chơi game trên máy tính cá nhân.",
        author: "User101",
        time: "8 giờ trước",
        image: "../img/index/infinite_scroll/lol_bg.jpg"
    },
    {
        id: 5,
        title: "Những game mobile hot nhất 2023",
        content: "Danh sách những game mobile đang được yêu thích trong năm 2023.",
        author: "Admin",
        time: "10 giờ trước",
        image: "../img/index/infinite_scroll/lol_bg.jpg"
    }
];

blogPosts = [];

function getApiUrl(path) {
    const basePath = window.location.pathname.split("/").filter(Boolean)[0] || "";
    const baseUrl = `${window.location.origin}${basePath ? '/' + basePath : ''}`;
    return `${baseUrl}/${path}`;
}

// Hàm fetch dữ liệu từ API
function fetchBlogPosts() {
    fetch(getApiUrl("Controller/ArticlesController.php"))
    .then(response => response.json())
    .then(data => {
        blogPosts = data; // Cập nhật blogPosts bằng dữ liệu API
        displayBlogPosts(currentPage); // Hiển thị bài viết lần đầu
    })
    .catch(error => {
        console.error("Lỗi khi lấy dữ liệu blog từ API:", error);
    });
}

const postsPerPage = 7;
let currentPage = 1;

// Hàm loại bỏ dấu tiếng Việt (diacritics)
function removeDiacritics(str) {
    return str.normalize("NFD").replace(/[\u0300-\u036f]/g, "");
}

// Hàm hiển thị bài viết theo trang (có phân trang)
function displayBlogPosts(page) {
    const blogContainer = document.querySelector('.blog-container');
    const startIndex = (page - 1) * postsPerPage;
    const endIndex = page * postsPerPage;
    
    // Xóa nội dung cũ
    blogContainer.innerHTML = "";

    const currentPosts = blogPosts.slice(startIndex, endIndex);

    currentPosts.forEach(post => {
        const blogItem = document.createElement('div');
        blogItem.classList.add('blog-item', 'col-lg-4', 'col-md-6', 'mb-4');

        blogItem.innerHTML = `
            <div class="cyber-card p-4">
                <img src="${post.image}" class="img-fluid mb-3" alt="${post.title}">
                <h5 class="text-neon-without-shadow">${post.title}</h5>
                <p>${post.content}</p>
                <button class="btn btn-neon">Đọc thêm</button>
            </div>
        `;
        // Dùng post.id để chuyển hướng trực tiếp đến trang chi tiết bài viết
        blogItem.querySelector('.btn-neon').addEventListener('click', function() {
            window.location.href = 'detail.php?id=' + post.id;
        });
        blogContainer.appendChild(blogItem);
    });

    updatePagination(page);
    // Hiển thị phân trang khi không tìm kiếm
    document.querySelector('.pagination').style.display = "flex";
}

// Hàm cập nhật phân trang
function updatePagination(currentPage) {
    const totalPages = Math.ceil(blogPosts.length / postsPerPage);
    const paginationContainer = document.querySelector('.pagination');

    paginationContainer.innerHTML = "";

    for (let i = 1; i <= totalPages; i++) {
        const pageItem = document.createElement('li');
        pageItem.classList.add('page-item');
        
        const pageLink = document.createElement('a');
        pageLink.classList.add('page-link', 'text-neon', 'bg-dark');
        pageLink.href = "#";
        pageLink.textContent = i;

        if (i === currentPage) {
            pageItem.classList.add('active');
        }

        pageLink.addEventListener('click', function (e) {
            e.preventDefault();
            currentPage = i;
            displayBlogPosts(i);
        });

        pageItem.appendChild(pageLink);
        paginationContainer.appendChild(pageItem);
    }
}

// Hàm hiển thị kết quả tìm kiếm (không có phân trang)
function displayFilteredPosts(filteredPosts) {
    const blogContainer = document.querySelector('.blog-container');
    blogContainer.innerHTML = "";

    if (filteredPosts.length === 0) {
        blogContainer.innerHTML = "<p class='text-center'>Không tìm thấy bài viết nào.</p>";
        return;
    }

    filteredPosts.forEach(post => {
        const blogItem = document.createElement('div');
        blogItem.classList.add('blog-item', 'col-lg-4', 'col-md-6', 'mb-4');

        blogItem.innerHTML = `
            <div class="cyber-card p-4">
                <img src="${post.image}" class="img-fluid mb-3" alt="${post.title}">
                <h5 class="text-neon-without-shadow">${post.title}</h5>
                <p>${post.content}</p>
                <button class="btn btn-neon">Đọc thêm</button>
            </div>
        `;
        // Sử dụng luôn post.id để chuyển hướng đến trang chi tiết trong kết quả tìm kiếm
        blogItem.querySelector('.btn-neon').addEventListener('click', function() {
            window.location.href = 'detail.html?id=' + post.id;
        });
        blogContainer.appendChild(blogItem);
    });

    // Ẩn phân trang khi hiển thị kết quả tìm kiếm
    document.querySelector('.pagination').style.display = "none";
}

// Xử lý tìm kiếm
const searchInput = document.getElementById("searchInput");
searchInput.addEventListener("input", function () {
    const query = removeDiacritics(searchInput.value.toLowerCase().trim());

    // Nếu ô tìm kiếm trống, hiển thị lại bài viết với phân trang
    if (query === "") {
        displayBlogPosts(currentPage);
        return;
    }

    // Lọc danh sách bài viết dựa trên tiêu đề, nội dung và tác giả (loại bỏ dấu)
    const filteredPosts = blogPosts.filter(post => {
        const title = removeDiacritics(post.title.toLowerCase());
        const content = removeDiacritics(post.content.toLowerCase());
        const author = removeDiacritics(post.author.toLowerCase());
        
        return title.includes(query) || content.includes(query) || author.includes(query);
    });

    displayFilteredPosts(filteredPosts);
});

// Hàm load các thành phần header và footer từ file bên ngoài (nếu có)
function loadComponent(id, file) {
    fetch(file)
        .then(response => response.text())
        .then(data => {
            document.getElementById(id).innerHTML = data;
        })
        .catch(error => console.error(`Lỗi khi tải ${file}:`, error));
}

document.addEventListener("DOMContentLoaded", function () {
    fetchBlogPosts();
    displayBlogPosts(currentPage);
    loadComponent("header", "../component/header.php");
    loadComponent("footer", "../component/footer.php");

    // Tạo hiệu ứng scroll cho các phần tử có thuộc tính data-scroll
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
