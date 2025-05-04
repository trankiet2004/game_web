function timeSince(createdAt) {
    const now = new Date();
    const createdDate = new Date(createdAt);
    const diffInSeconds = Math.floor((now - createdDate) / 1000);
  
    if (diffInSeconds < 60) {
      return `${diffInSeconds} giây trước`;
    }
  
    const diffInMinutes = Math.floor(diffInSeconds / 60);
    if (diffInMinutes < 60) {
      return `${diffInMinutes} phút trước`;
    }
  
    const diffInHours = Math.floor(diffInMinutes / 60);
    if (diffInHours < 24) {
      return `${diffInHours} giờ trước`;
    }
  
    const diffInDays = Math.floor(diffInHours / 24);
    return `${diffInDays} ngày trước`;
}

async function fetchData(URL_String) {
    const URL_GAMES_API = new URL(URL_String, window.location.href).href;

    try {
        const response = await fetch(URL_GAMES_API);
        if (!response.ok) {
            throw new Error(`Response status: ${response.status}`);
        }
        const json = await response.json();
        return json;
    } catch (error) {
        console.error(error.message);
    }
}

document.addEventListener("DOMContentLoaded", async function() {
    let commentListContainer = document.getElementsByClassName("card-body")[0];
    commentListContainer.innerHTML = "";

    // Fetch cả FAQs và Users
    const [faqs, users] = await Promise.all([
        fetchData("http://localhost:8080/Controller/FaqsController.php"),
        fetchData("http://localhost:8080/Controller/UsersController.php")
    ]);

    // Map user_id -> images path
    const usersMap = {};
    users.forEach(user => {
        usersMap[user.id] = user.images;
    });

    faqs.forEach((item, index) => {
        let commentDiv = document.createElement("div");
        commentDiv.classList.add("comment");

        let commentHeaderDiv = document.createElement("div");
        commentHeaderDiv.classList.add("comment-header");

        let pr50Div = document.createElement("div");
        pr50Div.classList.add("pr-50");
        let avatarDiv = document.createElement("div");
        avatarDiv.classList.add("avatar", "avatar-2xl");

        let imgTag = document.createElement("img");

        // 🔥 Sử dụng avatar từ usersMap theo user_id
        imgTag.src = usersMap[item.user_id] || "../assets/static/images/faces/default.jpg";
        imgTag.alt = "Avatar";

        avatarDiv.append(imgTag);
        pr50Div.append(avatarDiv);
        commentDiv.append(pr50Div);

        let commentBodyDiv = document.createElement("div");
        commentBodyDiv.classList.add("comment-body");

        let commentProfileName = document.createElement("div");
        commentProfileName.classList.add("comment-profileName");
        commentProfileName.innerHTML = item.posted_by;

        let commentTime = document.createElement("div");
        commentTime.classList.add("comment-time");
        commentTime.innerHTML = timeSince(item.created_at);

        let commentMessageDiv = document.createElement("div");
        commentMessageDiv.classList.add("comment-profileName");
        let commentMessageP = document.createElement("p");
        commentMessageP.classList.add("list-group-item-text", "truncate", "mb-20");
        commentMessageP.innerHTML = `Câu hỏi: ${item.question}`;
        commentMessageDiv.append(commentMessageP);
        commentMessageP = document.createElement("p");
        commentMessageP.classList.add("list-group-item-text", "truncate", "mb-20");
        commentMessageP.innerHTML = `Trả lời: ${item.answer}`;
        commentMessageDiv.append(commentMessageP);

        let commentActionsDiv = document.createElement("div");
        commentActionsDiv.classList.add("comment-actions");

        let commentActionsShowButton = document.createElement("button");
        commentActionsShowButton.classList.add("btn", "icon", "icon-left", "btn-primary", "me-2", "text-nowrap");
        let commentActionsShowButtonIcon = document.createElement("i");
        commentActionsShowButtonIcon.classList.add("bi", "bi-eye-fill");
        commentActionsShowButton.append(commentActionsShowButtonIcon, " Show");

        // let commentActionsEditButton = document.createElement("button");
        // commentActionsEditButton.classList.add("btn", "icon", "icon-left", "btn-warning", "me-2", "text-nowrap");
        // let commentActionsEditButtonIcon = document.createElement("i");
        // commentActionsEditButtonIcon.classList.add("bi", "bi-pencil-square");
        // commentActionsEditButton.append(commentActionsEditButtonIcon, " Edit");

        let commentActionsRemoveButton = document.createElement("button");
        commentActionsRemoveButton.classList.add("btn", "icon", "icon-left", "btn-danger", "me-2", "text-nowrap");
        let commentActionsRemoveButtonIcon = document.createElement("i");
        commentActionsRemoveButtonIcon.classList.add("bi", "bi-x-circle");
        commentActionsRemoveButton.append(commentActionsRemoveButtonIcon, " Remove");

        commentActionsShowButton.addEventListener('click', () => {
            const origin = window.location.origin;
            window.location.href = `${origin}/View/bao/forum.php#faq-${item.faq_id}`;
        });

        commentActionsRemoveButton.addEventListener('click', async () => {
            if (!confirm('Bạn có chắc muốn xóa mục này?')) return;
            try {
                const deleteUrl = `${window.location.origin}/Controller/FaqsController.php/${item.faq_id}`;
                const res = await fetch(deleteUrl, { method: 'DELETE' });
                const json = await res.json();
                if (json.success) {
                    commentDiv.remove();
                } else {
                    alert('Xóa không thành công.');
                }
            } catch (err) {
                console.error(err);
                alert('Lỗi khi xóa.');
            }
        });

        commentActionsDiv.append(commentActionsShowButton, /*commentActionsEditButton,*/ commentActionsRemoveButton);
        commentBodyDiv.append(commentProfileName, commentTime, commentMessageDiv, commentActionsDiv);
        commentHeaderDiv.append(pr50Div, commentBodyDiv);
        commentDiv.append(commentHeaderDiv);
        commentListContainer.append(commentDiv);
    });
});