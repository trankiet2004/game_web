<?php 
session_start();

// 1. Chưa đăng nhập → quay về login
if (!isset($_SESSION['user'])) {
    header('Location: ../../index.php?page=signin');
    exit;
}
$role = $_SESSION['user']['role'] ?? null;

// 2. Đã đăng nhập nhưng không phải admin → 403 Forbidden
if ($role !== 'admin') {
    http_response_code(403);
    exit('Bạn không có quyền truy cập trang này.');
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <base href="./View/admin/">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh Sửa Trang</title>
    <link rel="icon" type="image/icon" href="../img/logo.png">
    <link rel="stylesheet" crossorigin href="../assets/compiled/css/app.css">
    <link rel="stylesheet" crossorigin href="../assets/compiled/css/app-dark.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        * {
            margin: 0;
            padding: 0;
        }
        .editable:hover {
            outline: 2px dashed red;
            cursor: text;
        }
        #contentFrame {
            width: 100%;
            height: calc(100vh - 70px);
            border: none;
        }
        
        #stickyBar {
            position: sticky;
            top: 0;
            left: 0;
            width: 100%;
            height: 50px;
            display: flex;
            flex-flow: row wrap;
            align-items: center;
            justify-content: space-evenly;
            z-index: 100000;
        }
    </style>
</head>
<body>
    <div id="stickyBar">
        <img src="../img/logo.png" style="height: 90%; border-radius: 9999px;" alt="">
        <h4>Admin Editing</h4>
        <button id="saveBtn" class="btn btn-primary">
            Save Changes
        </button>
    </div>
    
    <iframe id="contentFrame"></iframe>
    
    <script>
        document.addEventListener("DOMContentLoaded", function(){
            var id = getParameterByName('id');
            var mapping = {
                'blogs': '../kiet/blogs.php',
                'index': '../thinh/index.php',
                'about_us': '../bao/about_us.php',
                'forum': '../bao/forum.php',
                'contact_us': '../thinh/contact_us.php'
            };

            var urlToLoad = mapping[id];
            if(!urlToLoad) {
                console.error("Không tìm thấy mapping cho id: " + id);
                return;
            }

            urlToLoad += '?t=' + new Date().getTime();

            var iframe = document.getElementById('contentFrame');
            fetch(`load_UI.php?id=${id}`)
            .then(res => res.text())
            .then(html => {
                var doc = iframe.contentDocument || iframe.contentWindow.document;
                doc.open();
                doc.write(html);
                doc.close();
            });
            iframe.onload = function() {
                var doc = iframe.contentDocument || iframe.contentWindow.document;
                let baseTag = doc.querySelector("base[href]");
                if (baseTag && baseTag.href.includes('./View/')) {
                    baseTag.href = baseTag.href.replace('./View/', '/View/');
                }
                var editableEls = doc.querySelectorAll('[data-editable="true"]');
                editableEls.forEach(function(el) {
                    el.contentEditable = true;
                });
                
                editableEls.forEach(function(el) {
                    el.querySelectorAll("img").forEach(function(img) {
                        img.style.cursor = "pointer";
                        img.addEventListener("click", function() {
                            var fileInput = doc.createElement("input");
                            fileInput.type = "file";
                            fileInput.style.display = "none";
                            fileInput.accept = "image/*";
                            fileInput.addEventListener("change", function() {
                                var file = fileInput.files[0];
                                if(!file) return;
                                var reader = new FileReader();
                                reader.onload = function(e) {
                                    img.src = e.target.result;
                                };
                                reader.readAsDataURL(file);
                            });
                            doc.body.appendChild(fileInput);
                            fileInput.click();
                        });
                    });
                });
                
                var timelineContainer = doc.querySelector(".time-line-container");
                if(!timelineContainer) {
                    console.warn("Không tìm thấy phần tử .time-line-container trong trang.");
                    return;
                }
                
                var addYearButton = doc.createElement("button");
                addYearButton.innerText = "Thêm Hành Trình Mới";
                addYearButton.className = "btn btn-info float-end fw-bold";
                timelineContainer.insertAdjacentElement("afterbegin", addYearButton);
                
                addYearButton.addEventListener("click", function(){
                    var h4Elements = timelineContainer.querySelectorAll("h4");
                    var maxYear = 0;
                    h4Elements.forEach(function(h4) {
                        var text = h4.innerText;
                        var parts = text.split(" - ");
                        var year = parseInt(parts[0]);
                        if(!isNaN(year) && year > maxYear) {
                            maxYear = year;
                        }
                    });
                    var newYear = (maxYear === 0) ? new Date().getFullYear() : maxYear + 1;
                    alert("Hành trình mới sẽ được tạo cho năm: " + newYear);
                    
                    var title = prompt("Nhập tiêu đề cho năm " + newYear + " (phần sau dấu '-'): ");
                    if(!title) return;
                    var description = prompt("Nhập mô tả ngắn cho năm " + newYear + ": ");
                    if(!description) return;
                    
                    var newDiv = doc.createElement("div");
                    newDiv.style.marginTop = "10%";
                    newDiv.setAttribute("data-scroll", "");
                    newDiv.classList.add("visible");
                    
                    var newH4 = doc.createElement("h4");
                    newH4.innerText = newYear + " - " + title;
                    
                    var newP = doc.createElement("p");
                    newP.style.fontSize = "100%";
                    newP.innerText = description;
                    
                    newDiv.appendChild(newH4);
                    newDiv.appendChild(newP);
                    
                    var secondRow = timelineContainer.querySelector("div.row:nth-of-type(2)");
                    if(!secondRow) {
                        alert("Không tìm thấy row thứ hai của timeline.");
                        console.error("Row thứ hai không tìm thấy trong:", timelineContainer);
                        return;
                    }
                    var columns = secondRow.querySelectorAll("div.col");
                    if(columns.length < 2) {
                        alert("Không tìm thấy cấu trúc cột timeline hợp lệ.");
                        console.error("Columns hiện có:", columns);
                        return;
                    }
                    
                    if(newYear % 2 === 0) {
                        columns[0].appendChild(newDiv);
                        console.log("Đã thêm hành trình mới vào cột bên trái (năm chẵn).");
                    } else {
                        columns[1].appendChild(newDiv);
                        console.log("Đã thêm hành trình mới vào cột bên phải (năm lẻ).");
                    }
                });
            };
            
            document.getElementById("saveBtn").addEventListener("click", async function() {
                var iframe = document.getElementById('contentFrame');
                var doc = iframe.contentDocument || iframe.contentWindow.document;
                var timelineContainer = doc.querySelector(".time-line-container");
                
                if (timelineContainer) {
                    var addYearButton = timelineContainer.querySelector("button.btn.btn-info.float-end.fw-bold");
                    if (addYearButton) {
                        addYearButton.remove();
                    }
                }
                
                var editedContent = doc.documentElement.outerHTML;
                var filePath = mapping[getParameterByName('id')];
                
                try {
                    const response = await fetch('save_changes.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            file: filePath,
                            content: editedContent
                        })
                    });

                    const result = await response.json();
                    if (result.status === 'success') {
                        alert("Lưu thay đổi thành công!");
                    } else {
                        alert("Lưu thay đổi thất bại: " + result.message);
                    }
                } catch (error) {
                    console.error("Lỗi khi lưu thay đổi:", error);
                    alert("Có lỗi xảy ra khi gửi dữ liệu lưu thay đổi.");
                }
            });
        });
        
        function getParameterByName(name) {
            var url = window.location.href;
            name = name.replace(/[\[\]]/g, "\\$&");
            var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
                results = regex.exec(url);
            if (!results) return null;
            if (!results[2]) return '';
            return decodeURIComponent(results[2].replace(/\+/g, " "));
        }
    </script>        
</body>
</html>
