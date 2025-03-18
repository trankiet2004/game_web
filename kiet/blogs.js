const blogPosts = [
    {
        title: "Làm sao để nâng cấp phần cứng?",
        content: "Mình muốn nâng cấp GPU để chơi game AAA, có bạn nào tư vấn giúp không?",
        author: "User123",
        time: "2 giờ trước",
        image: "https://via.placeholder.com/300x200?text=GPU+Upgrade"
    },
    {
        title: "Cách tăng tốc máy tính chơi game",
        content: "Máy tính mình hơi chậm khi chơi game, có cách nào cải thiện hiệu suất không?",
        author: "User456",
        time: "3 giờ trước",
        image: "https://via.placeholder.com/300x200?text=Speed+Up+PC"
    },
    {
        title: "Tư vấn chọn laptop chơi game",
        content: "Chọn laptop chơi game với giá dưới 20 triệu, có ai có kinh nghiệm không?",
        author: "Admin",
        time: "5 giờ trước",
        image: "https://via.placeholder.com/300x200?text=Laptop+Gaming"
    },
    {
        title: "Hướng dẫn xây dựng máy tính chơi game",
        content: "Chia sẻ cách lắp ráp máy tính chơi game từ các linh kiện phổ biến nhất hiện nay.",
        author: "User789",
        time: "7 giờ trước",
        image: "https://via.placeholder.com/300x200?text=Build+PC"
    },
    {
        title: "Phần mềm hỗ trợ chơi game tốt nhất",
        content: "Những phần mềm giúp tối ưu trải nghiệm chơi game trên máy tính cá nhân.",
        author: "User101",
        time: "8 giờ trước",
        image: "https://via.placeholder.com/300x200?text=Game+Software"
    },
    {
        title: "Những game mobile hot nhất 2023",
        content: "Danh sách những game mobile đang được yêu thích trong năm 2023.",
        author: "Admin",
        time: "10 giờ trước",
        image: "https://via.placeholder.com/300x200?text=Mobile+Games"
    },
    {
        title: "Cách tăng tốc máy tính chơi game",
        content: "Máy tính mình hơi chậm khi chơi game, có cách nào cải thiện hiệu suất không?",
        author: "User456",
        time: "3 giờ trước",
        image: "https://via.placeholder.com/300x200?text=Speed+Up+PC"
    },
    {
        title: "Tư vấn chọn laptop chơi game",
        content: "Chọn laptop chơi game với giá dưới 20 triệu, có ai có kinh nghiệm không?",
        author: "Admin",
        time: "5 giờ trước",
        image: "https://via.placeholder.com/300x200?text=Laptop+Gaming"
    },
    {
        title: "Hướng dẫn xây dựng máy tính chơi game",
        content: "Chia sẻ cách lắp ráp máy tính chơi game từ các linh kiện phổ biến nhất hiện nay.",
        author: "User789",
        time: "7 giờ trước",
        image: "https://via.placeholder.com/300x200?text=Build+PC"
    },
    {
        title: "Phần mềm hỗ trợ chơi game tốt nhất",
        content: "Những phần mềm giúp tối ưu trải nghiệm chơi game trên máy tính cá nhân.",
        author: "User101",
        time: "8 giờ trước",
        image: "https://via.placeholder.com/300x200?text=Game+Software"
    },
    {
        title: "Những game mobile hot nhất 2023",
        content: "Danh sách những game mobile đang được yêu thích trong năm 2023.",
        author: "Admin",
        time: "10 giờ trước",
        image: "https://via.placeholder.com/300x200?text=Mobile+Games"
    },
];

// Số lượng bài viết hiển thị trên mỗi trang
const postsPerPage = 7;

// Số trang hiện tại
let currentPage = 1;

// Hàm hiển thị các bài viết
function displayBlogPosts(page) {
    const blogContainer = document.querySelector('.blog-container');
    const startIndex = (page - 1) * postsPerPage;
    const endIndex = page * postsPerPage;
    
    // Xóa hết các bài viết cũ
    blogContainer.innerHTML = "";

    // Lọc bài viết cho trang hiện tại
    const currentPosts = blogPosts.slice(startIndex, endIndex);

    // Duyệt qua các bài viết và tạo HTML
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
        blogContainer.appendChild(blogItem);
    });

    // Cập nhật phân trang
    updatePagination(page);
}

// Hàm cập nhật phân trang
function updatePagination(currentPage) {
    const totalPages = Math.ceil(blogPosts.length / postsPerPage);
    const paginationContainer = document.querySelector('.pagination');

    paginationContainer.innerHTML = "";

    // Tạo các nút phân trang
    for (let i = 1; i <= totalPages; i++) {
        const pageItem = document.createElement('li');
        pageItem.classList.add('page-item');
        
        const pageLink = document.createElement('a');
        pageLink.classList.add('page-link');
        pageLink.classList.add('text-neon');
        pageLink.classList.add('bg-dark');
        pageLink.href = "#";
        pageLink.textContent = i;

        // Nếu là trang hiện tại, thêm class active
        if (i === currentPage) {
            pageItem.classList.add('active');
        }

        pageLink.addEventListener('click', function (e) {
            e.preventDefault();
            displayBlogPosts(i);
        });

        pageItem.appendChild(pageLink);
        paginationContainer.appendChild(pageItem);
    }
}

// Gọi hàm để hiển thị bài viết của trang đầu tiên
document.addEventListener('DOMContentLoaded', function () {
    displayBlogPosts(currentPage);
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
    loadComponent("header", "../component/header.html");
    loadComponent("footer", "../component/footer.html");

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