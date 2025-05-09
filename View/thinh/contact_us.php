<html lang="vi">
<head>
    <meta charset="UTF-8">
    <base href="./View/thinh/">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liên Hệ - BKGame</title>
    <link rel="icon" type="image/icon" href="../img/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet"> 
    <link rel="stylesheet" href="contact_us.css">

    <script>
      function loadComponent(id, file) {
        fetch(file)
        .then(response => response.text())
        .then(data => {
          document.getElementById(id).innerHTML = data;
          var linkHeader = document.createElement('link');
          linkHeader.rel = 'stylesheet';
          linkHeader.href = '../component/header.css';
      
          var linkFooter = document.createElement('link');
          linkFooter.rel = 'stylesheet';
          linkFooter.href = '../component/footer.css';
      
          document.head.appendChild(linkHeader);
          document.head.appendChild(linkFooter);
        }).catch(error => console.error(`Lỗi khi tải ${file}:`, error));
      }

      document.addEventListener("DOMContentLoaded", function () {
        loadComponent("header", "../component/header.php");
        loadComponent("footer", "../component/footer.php");
      });
    </script>
<link rel="stylesheet" href="../component/header.css"><link rel="stylesheet" href="../component/footer.css"><link rel="stylesheet" href="../component/header.css"><link rel="stylesheet" href="../component/footer.css"><link rel="stylesheet" href="../component/header.css"><link rel="stylesheet" href="../component/footer.css"><link rel="stylesheet" href="../component/header.css"><link rel="stylesheet" href="../component/footer.css"></head>
<body>
  <div id="header"><nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand text-neon" href="../../index.php?">
            <img src="../img/logo.png" width="40" height="40" class="rounded-circle me-2 glow-effect" alt="CyberGameHub Logo">BKGame
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link text-neon" href="../../index.php?">Trang Chủ</a></li>
                
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-neon" href="#" role="button" data-bs-toggle="dropdown">Games</a>
                    
                    <ul class="dropdown-menu cyber-dropdown">
                        <li><a class="dropdown-item" href="#">PC Games</a></li>
                        <li><a class="dropdown-item" href="#">Console Games</a></li>
                        <li><a class="dropdown-item" href="#">Mobile Games</a></li>
                        <li><a class="dropdown-item" href="#">VR Games</a></li>
                    </ul>
                </li>

                <li class="nav-item"><a class="nav-link text-neon" href="../../index.php?page=about_us">Giới Thiệu</a></li>
                
                <li class="nav-item"><a class="nav-link text-neon" href="../../index.php?page=blogs">Tin Tức</a></li>
                
                <li class="nav-item"><a class="nav-link text-neon" href="../../index.php?page=forum">Cộng Đồng</a></li>
                
                <li class="nav-item"><a class="nav-link text-neon" href="../../index.php?page=contact_us">Liên Hệ</a></li>
            
            </ul>
            
            <div class="d-flex align-items-center">
                <button class="btn btn-outline-neon me-2">
                    <a href="../../index.php?page=signin" style="text-decoration: none; color: var(--primary);">
                        Đăng Nhập
                    </a>
                </button>
                
                <button class="btn btn-neon">
                    <a href="../../index.php?page=signup" style="color: black; text-decoration: none;">
                        Đăng Ký
                    </a>
                </button>
            </div>
        </div>
    </div>
</nav></div>

  <section>
    <div class="container mt-5">
      <div class="row mt-5 mb-5 flex-row">
        <div class="col-md-6 col-sm-12">
          <div class="card h-100">
            <div class="card-body">
              <h5 class="card-title">Văn Phòng BKGame</h5>
              <div class="office-selector mb-3">
                <button class="btn btn-sm btn-outline-primary office-btn active" data-office="1">Văn Phòng 1</button>
                <button class="btn btn-sm btn-outline-primary office-btn" data-office="2">Văn Phòng 2</button>
              </div>
              <div class="office-info">
                <div class="office-details active" data-office="1">
                  <p data-editable="true" contenteditable="true"><strong>Địa chỉ:</strong> 268 Lý Thường Kiệt, Phường 14, Quận 10, TP.HCM, Việt Nam</p>
                </div>
                <div class="office-details" data-office="2">
                  <p data-editable="true" contenteditable="true"><strong>Địa chỉ:</strong> Đông Hòa, Dĩ An, Bình Dương</p>
                </div>
              </div>
              <div class="map-container">
                <iframe id="office-map" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.511579457489!2d106.65790179999999!3d10.772075!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752ec3c161a3fb%3A0xef77cd47a1cc691e!2zVHLGsOG7nW5nIMSQ4bqhaSBo4buNYyBCw6FjaCBraG9hIC0gxJDhuqFpIGjhu41jIFF14buRYyBnaWEgVFAuSENN!5e0!3m2!1svi!2s!4v1742344973165!5m2!1svi!2s" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
              </div>
            </div>
          </div>
        </div>
        
        <div class="col-md-6 col-sm-12">
          <form action="#" class="card p-4">
            <h5 class="mb-3">Phản Hồi Của Bạn</h5>
            <div class="mb-3">
              <input type="text" placeholder="Họ và tên" class="form-control">
            </div>
            <div class="mb-3">
              <input type="email" placeholder="Email" class="form-control">
            </div>
            <div class="mb-3">
              <input type="number" placeholder="Số điện thoại" class="form-control">
            </div>
            <div class="mb-3">
              <select class="form-control" id="subject">
                <option value="" disabled="" selected="">Chọn chủ đề</option>
                <option value="account">Vấn đề về tài khoản</option>
                <option value="payment">Vấn đề thanh toán</option>
                <option value="product">Vấn đề hội viên</option>
                <option value="other">Vấn đề khác</option>
              </select>
            </div>
            <div class="mb-3">
              <textarea placeholder="Nội dung" class="form-control" cols="30" rows="5"></textarea>
            </div>
            <div class="d-flex justify-content-end">
              <button type="submit" class="btn btn-dark">Gửi</button>
            </div>
          </form>
        </div>
      </div>
      
      <div class="row mt-5">
        <div class="col-md-6 mb-3">
          <div class="card h-100">
            <div class="card-body">
              <h5 class="card-title">Phản Hồi Khách Hàng</h5>
              <div class="feedback-carousel">
                <div class="feedback-item active">
                  <blockquote class="blockquote">
                    <p data-editable="true" contenteditable="true">"BKGame luôn mang lại trải nghiệm tuyệt vời. Tôi hoàn toàn yên tâm khi sử dụng dịch vụ của họ."</p>
                    <footer class="blockquote-footer" data-editable="true" contenteditable="true">Trần Tuấn Kiệt</footer>
                  </blockquote>
                </div>
                <div class="feedback-item">
                  <blockquote class="blockquote">
                    <p data-editable="true" contenteditable="true">"Dịch vụ khách hàng của BKGame thật sự xuất sắc. Họ đã giải quyết vấn đề của tôi một cách nhanh chóng và hiệu quả."</p>
                    <footer class="blockquote-footer" data-editable="true" contenteditable="true">Trần Tuấn Kiệt</footer>
                  </blockquote>
                </div>
                <div class="feedback-item">
                  <blockquote class="blockquote">
                    <p data-editable="true" contenteditable="true">"Tôi rất hài lòng với trải nghiệm mua sắm tại BKGame. Sản phẩm chất lượng và giao hàng đúng hẹn."</p>
                    <footer class="blockquote-footer" data-editable="true" contenteditable="true">Trần Tuấn Kiệt</footer>
                  </blockquote>
                </div>
                <div class="feedback-item">
                  <blockquote class="blockquote">
                    <p data-editable="true" contenteditable="true">"BKGame có những sản phẩm chất lượng cao với giá cả phải chăng. Tôi sẽ tiếp tục ủng hộ."</p>
                    <footer class="blockquote-footer" data-editable="true" contenteditable="true">Trần Tuấn Kiệt</footer>
                  </blockquote>
                </div>
                <div class="feedback-item">
                  <blockquote class="blockquote">
                    <p data-editable="true" contenteditable="true">"Đội ngũ nhân viên tại BKGame rất thân thiện và chuyên nghiệp. Họ đã giúp tôi lựa chọn sản phẩm phù hợp."</p>
                    <footer class="blockquote-footer" data-editable="true" contenteditable="true">Trần Tuấn Kiệt</footer>
                  </blockquote>
                </div>
              </div>
              <div class="carousel-controls mt-3">
                <button class="btn btn-sm btn-outline-primary carousel-btn active" data-target="feedback" data-index="0">1</button>
                <button class="btn btn-sm btn-outline-primary carousel-btn" data-target="feedback" data-index="1">2</button>
                <button class="btn btn-sm btn-outline-primary carousel-btn" data-target="feedback" data-index="2">3</button>
                <button class="btn btn-sm btn-outline-primary carousel-btn" data-target="feedback" data-index="3">4</button>
                <button class="btn btn-sm btn-outline-primary carousel-btn" data-target="feedback" data-index="4">5</button>
              </div>
            </div>
          </div>
        </div>
        
        <div class="col-md-6 mb-3">
          <div class="card h-100">
            <div class="card-body">
              <h5 class="card-title">Hỗ Trợ / FAQ</h5>
              <div class="faq-carousel">
                <div class="faq-item">
                  <ul class="list-unstyled">
                    <li data-editable="true" contenteditable="true">
                      <strong>Q:</strong> Làm thế nào để liên hệ với BKGame?<br>
                      <strong>A:</strong> Quý khách có thể gọi điện hoặc gửi email để được hỗ trợ.
                    </li>
                    <li class="mt-2" data-editable="true" contenteditable="true">
                      <strong>Q:</strong> Dịch vụ của BKGame hỗ trợ những gì?<br>
                      <strong>A:</strong> Chúng tôi cung cấp dịch vụ hỗ trợ game, tư vấn và giải đáp thắc mắc.
                    </li>
                  </ul>
                </div>
                <div class="faq-item">
                  <ul class="list-unstyled">
                    <li data-editable="true" contenteditable="true">
                      <strong>Q:</strong> BKGame có chính sách hoàn trả không?<br>
                      <strong>A:</strong> Có, chúng tôi có chính sách hoàn trả trong vòng 7 ngày nếu sản phẩm có lỗi.
                    </li>
                    <li class="mt-2" data-editable="true" contenteditable="true">
                      <strong>Q:</strong> Thời gian giao hàng là bao lâu?<br>
                      <strong>A:</strong> Thời gian giao hàng từ 2-5 ngày làm việc tùy theo khu vực.
                    </li>
                  </ul>
                </div>
                <div class="faq-item">
                  <ul class="list-unstyled">
                    <li data-editable="true" contenteditable="true">
                      <strong>Q:</strong> BKGame có hỗ trợ thanh toán qua thẻ tín dụng không?<br>
                      <strong>A:</strong> Có, chúng tôi hỗ trợ thanh toán qua thẻ tín dụng, thẻ ghi nợ và các ví điện tử.
                    </li>
                    <li class="mt-2" data-editable="true" contenteditable="true">
                      <strong>Q:</strong> Làm thế nào để theo dõi đơn hàng?<br>
                      <strong>A:</strong> Quý khách có thể theo dõi đơn hàng thông qua mã đơn hàng được gửi qua email.
                    </li>
                  </ul>
                </div>
                <div class="faq-item active">
                  <ul class="list-unstyled">
                    <li data-editable="true" contenteditable="true">
                      <strong>Q:</strong> BKGame có cung cấp dịch vụ bảo hành không?<br>
                      <strong>A:</strong> Có, chúng tôi cung cấp dịch vụ bảo hành từ 12-36 tháng tùy theo sản phẩm.
                    </li>
                    <li class="mt-2" data-editable="true" contenteditable="true">
                      <strong>Q:</strong> Tôi có thể mua hàng trực tiếp tại cửa hàng không?<br>
                      <strong>A:</strong> Có, quý khách có thể đến trực tiếp cửa hàng của chúng tôi tại các chi nhánh trên toàn quốc.
                    </li>
                  </ul>
                </div>
                <div class="faq-item">
                  <ul class="list-unstyled">
                    <li data-editable="true" contenteditable="true">
                      <strong>Q:</strong> BKGame có chương trình khuyến mãi nào không?<br>
                      <strong>A:</strong> Chúng tôi thường xuyên có các chương trình khuyến mãi vào các dịp lễ, Tết và sinh nhật BKGame.
                    </li>
                    <li class="mt-2" data-editable="true" contenteditable="true">
                      <strong>Q:</strong> Làm thế nào để đăng ký thành viên BKGame?<br>
                      <strong>A:</strong> Quý khách có thể đăng ký thành viên trên website hoặc tại cửa hàng của chúng tôi.
                    </li>
                  </ul>
                </div>
              </div>
              <div class="carousel-controls mt-3">
                <button class="btn btn-sm btn-outline-primary carousel-btn" data-target="faq" data-index="0">1</button>
                <button class="btn btn-sm btn-outline-primary carousel-btn" data-target="faq" data-index="1">2</button>
                <button class="btn btn-sm btn-outline-primary carousel-btn" data-target="faq" data-index="2">3</button>
                <button class="btn btn-sm btn-outline-primary carousel-btn active" data-target="faq" data-index="3">4</button>
                <button class="btn btn-sm btn-outline-primary carousel-btn" data-target="faq" data-index="4">5</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <footer id="footer" class="cyber-footer py-5" style="margin-top: 0;">
<footer class="py-4">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4">
                <h5 class="text-neon">Về BKGame</h5>
                <p>Tạo ra những trải nghiệm chơi game của tương lai</p>
            </div>
            
            <div class="col-lg-4">
                <h5 class="text-neon">Quick Links</h5>
                <ul class="list-unstyled">
                    <li><a href="#" style="text-decoration: none;">Hỗ Trợ</a></li>
                    <li><a href="#" style="text-decoration: none;">Điều khoản dịch vụ</a></li>
                    <li><a href="#" style="text-decoration: none;">Chính sách bảo mật</a></li>
                </ul>
            </div>
            
            <div class="col-lg-4">
                <h5 class="text-neon">Phương Thức Thanh Toán</h5>
                
                <div class="payment-methods">
                    <i class="bi bi-credit-card"></i>
                    <i class="bi bi-paypal"></i>
                    <i class="bi bi-wallet2"></i>
                </div>
            </div>
        </div>
    </div>
</footer>
</footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script src="contact_us.js"></script>


</body></html>