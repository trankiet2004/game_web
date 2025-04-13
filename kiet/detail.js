// detail.js

// Hàm load component từ file ngoài (header, footer)
function loadComponent(id, url) {
  fetch(url)
    .then(response => {
      if(!response.ok) throw new Error("Network response was not ok");
      return response.text();
    })
    .then(html => {
      document.getElementById(id).innerHTML = html;
    })
    .catch(error => {
      console.error(`Lỗi khi tải ${url}:`, error);
    });
}

// Hàm lấy tham số từ URL theo tên
function getParameterByName(name, url = window.location.href) {
  name = name.replace(/[\[\]]/g, '\\$&');
  const regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
        results = regex.exec(url);
  if (!results) return null;
  if (!results[2]) return '';
  return decodeURIComponent(results[2].replace(/\+/g, ' '));
}

// Dữ liệu mẫu các bài viết
const articles = [
  {
    id: 0,
    title: "Làm sao để nâng cấp phần cứng?",
    content: "Chi tiết bài viết về cách nâng cấp GPU để chơi game AAA. Nội dung cung cấp các lưu ý quan trọng và hướng dẫn cụ thể từng bước.",
    author: "User123",
    time: "2 giờ trước",
    image: "https://via.placeholder.com/600x400?text=GPU+Upgrade"
  },
  {
    id: 1,
    title: "Cách tăng tốc máy tính chơi game",
    content: "Bài viết chia sẻ các thủ thuật tăng tốc để cải thiện hiệu suất chơi game. Hướng dẫn chi tiết và mẹo tối ưu hóa hệ thống.",
    author: "User456",
    time: "3 giờ trước",
    image: "https://via.placeholder.com/600x400?text=Speed+Up+PC"
  },
  {
    id: 2,
    title: "Tư vấn chọn laptop chơi game",
    content: "Bài viết cung cấp các gợi ý về cấu hình và thương hiệu laptop phù hợp cho game thủ, kèm theo các tiêu chí lựa chọn quan trọng.",
    author: "Admin",
    time: "5 giờ trước",
    image: "https://via.placeholder.com/600x400?text=Laptop+Gaming"
  },
  {
    id: 3,
    title: "Hướng dẫn xây dựng máy tính chơi game",
    content: "Hướng dẫn chi tiết cách lắp ráp máy tính chơi game từ các linh kiện phổ biến hiện nay, cùng với mẹo và lưu ý để tối ưu hiệu suất.",
    author: "User789",
    time: "7 giờ trước",
    image: "https://via.placeholder.com/600x400?text=Build+PC"
  },
  {
    id: 4,
    title: "Phần mềm hỗ trợ chơi game tốt nhất",
    content: "Giới thiệu danh sách các phần mềm giúp tối ưu trải nghiệm chơi game trên máy tính, với các tính năng ưu việt và hướng dẫn sử dụng.",
    author: "User101",
    time: "8 giờ trước",
    image: "https://via.placeholder.com/600x400?text=Game+Software"
  },
  {
    id: 5,
    title: "Những game mobile hot nhất 2023",
    content: "Bài viết tổng hợp các tựa game mobile được ưa chuộng trong năm 2023, kèm theo đánh giá và phân tích chi tiết.",
    author: "Admin",
    time: "10 giờ trước",
    image: "https://via.placeholder.com/600x400?text=Mobile+Games"
  }
];

window.onload = () => {
  // Load header và footer từ file component (đảm bảo đường dẫn đúng)
  loadComponent("header", "../component/header.html");
  loadComponent("footer", "../component/footer.html");
  
  // Lấy tham số "id" từ URL và chuyển đổi thành số nguyên
  const articleId = parseInt(getParameterByName('id'));
  const currentArticle = articles.find(a => a.id === articleId);
  const articleContainer = document.getElementById('article-container');

  if (!currentArticle) {
    articleContainer.innerHTML = "<p>Bài viết không tồn tại.</p>";
    return;
  }

  // Cập nhật tiêu đề trang theo định dạng "BKGame - [Tên bài viết]"
  document.title = "BKGame - " + currentArticle.title;

  // Render bài viết chi tiết (tác giả, thời gian ở trên nội dung)
  articleContainer.innerHTML = `
    <div class="detail-content">
      <h2 class="text-neon">${currentArticle.title}</h2>
      <p class="article-meta"><small>Tác giả: ${currentArticle.author} - ${currentArticle.time}</small></p>
      <div class="text-center mb-3">
        <img src="${currentArticle.image}" alt="${currentArticle.title}" class="img-fluid">
      </div>
      <p>${currentArticle.content}</p>
      <button class="btn-neon mt-3" onclick="window.history.back();">Quay lại</button>
    </div>
  `;

  // Render danh sách các bài viết khác (giới hạn tối đa 5 bài), không hiển thị hình ảnh
  const suggestionsList = document.getElementById('suggestions-list');
  suggestionsList.innerHTML = "";
  const suggestionArticles = articles.filter(a => a.id !== currentArticle.id).slice(0, 5);

  suggestionArticles.forEach(article => {
    const suggestionItem = document.createElement('div');
    // Sử dụng class "blog-item" để tái sử dụng định dạng block của trang blogs; các block nằm theo cột dọc nhờ vertical-list trong container
    suggestionItem.classList.add("blog-item");
    suggestionItem.innerHTML = `
      <a href="detail.html?id=${article.id}" class="suggestion-link" style="text-decoration: none; color: inherit;">
        <h5>${article.title}</h5>
        <p>${article.content.substring(0, 80)}...</p>
      </a>
    `;
    suggestionsList.appendChild(suggestionItem);
  });

  // Thiết lập hiệu ứng scroll cho các phần tử có attribute data-scroll
  const observer = new IntersectionObserver(
    entries => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add("visible");
        }
      });
    },
    { threshold: 0.1 }
  );
  document.querySelectorAll("[data-scroll]").forEach(elem => observer.observe(elem));
};
