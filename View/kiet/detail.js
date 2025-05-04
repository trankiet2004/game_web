// detail.js

function loadComponent(id, url) {
  fetch(url)
    .then(res => res.text())
    .then(html => document.getElementById(id).innerHTML = html)
    .catch(err => console.error(`Lỗi khi tải ${url}:`, err));
}

function getParameterByName(name, url = window.location.href) {
  name = name.replace(/[\[\]]/g, '\\$&');
  const regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)');
  const results = regex.exec(url);
  if (!results) return null;
  if (!results[2]) return '';
  return decodeURIComponent(results[2].replace(/\+/g, ' '));
}

function getApiUrl(path) {
  const segments = window.location.pathname.split("/").filter(Boolean);
  const basePath = segments.length >= 2 ? `/${segments[0]}` : "";
  return `${window.location.origin}${basePath}/${path}`;
}

async function fetchData(URL_string) {
  try {
    const response = await fetch(new URL(URL_string, window.location.href).href);
    if (!response.ok) throw new Error(`Lỗi ${response.status}`);
    return await response.json();
  } catch (error) {
    console.error(error.message);
  }
}

window.onload = async () => {
  loadComponent("header", "../component/header.php");
  loadComponent("footer", "../component/footer.php");

  const articleId = parseInt(getParameterByName('id'));
  if (isNaN(articleId)) {
    document.getElementById('article-container').innerHTML = "<p>ID không hợp lệ.</p>";
    return;
  }

  const articles = await fetchData(`${getApiUrl("Controller/ArticlesController.php")}?id=${articleId}`);
  const articleContainer = document.getElementById('article-container');

  if (!articles || articles.length === 0) {
    articleContainer.innerHTML = "<p>Bài viết không tồn tại.</p>";
    return;
  }

  const article = articles[0];
  document.title = "BKGame - " + article.title;

  articleContainer.innerHTML = `
    <div class="detail-content">
      <h2 class="text-neon" data-editable="true">${article.title}</h2>
      <p class="article-meta" data-editable="true"><small>Tác giả: ${article.author} - ${article.time}</small></p>
      <div class="text-center mb-3">
        <img src="${article.image}" alt="${article.title}" class="img-fluid" data-editable="true">
      </div>
      <p data-editable="true">${article.content}</p>
      <button class="btn-neon btn" onclick="window.history.back();">Quay lại</button>
    </div>
  `;

  const suggestionsList = document.getElementById('suggestions-list');
  suggestionsList.innerHTML = "";
  articles.filter(a => a.id !== article.id).slice(0, 5).forEach(article => {
    const suggestionItem = document.createElement('div');
    suggestionItem.classList.add("blog-item");
    suggestionItem.innerHTML = `
      <a href="detail.html?id=${article.id}" class="suggestion-link" style="text-decoration: none; color: inherit;">
        <h5 data-editable="true">${article.title}</h5>
        <p data-editable="true">${article.content.substring(0, 80)}...</p>
      </a>
    `;
    suggestionsList.appendChild(suggestionItem);
  });

  const observer = new IntersectionObserver(
    entries => entries.forEach(entry => {
      if (entry.isIntersecting) entry.target.classList.add("visible");
    }),
    { threshold: 0.1 }
  );
  document.querySelectorAll("[data-scroll]").forEach(el => observer.observe(el));

  loadComments(articleId);

  async function loadComments(articleId) {
    const commentList = document.getElementById('comment-list');
    commentList.innerHTML = "Đang tải bình luận...";
    const comments = await fetchData(`${getApiUrl("Controller/CommentsController.php")}?article_id=${articleId}`);
    commentList.innerHTML = (comments || []).map(c => `
      <div class="bg-dark p-3 rounded mb-2">
        <div class="d-flex justify-content-between">
          <strong class="text-neon">${c.user_name}</strong>
          <small>${new Date(c.created_at).toLocaleString()}</small>
        </div>
        <p class="text-light mb-0">${c.content}</p>
      </div>
    `).join('') || '<p class="text-light">Chưa có bình luận nào.</p>';
  }

  const commentForm = document.getElementById('comment-form');
  if (commentForm && typeof currentUser === "object" && currentUser !== null) {
    commentForm.addEventListener('submit', async (e) => {
      e.preventDefault();
      const content = document.getElementById('comment_content').value.trim();
      if (!content) return alert("Vui lòng nhập nội dung bình luận");

      const fd = new FormData();
      fd.append('article_id', articleId.toString());
      fd.append('user_id', currentUser.id);
      fd.append('user_name', currentUser.username);
      fd.append('content', content);

      // DEBUG
      for (let [key, value] of fd.entries()) {
        console.log(key, value);  // In từng field ra
      }

      const res = await fetch(getApiUrl("Controller/CommentsController.php"), {
        method: 'POST',
        body: fd
      });

      try {
        const json = await res.json();
        if (json.success) {
          commentForm.reset();
          loadComments(articleId);
        } else {
          alert("Gửi bình luận thất bại: " + (json.message || "Lỗi không xác định"));
        }
      } catch (err) {
        alert("Lỗi phản hồi từ máy chủ.");
      }
    });
  }
};