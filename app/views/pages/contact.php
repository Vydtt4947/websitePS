<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liên Hệ - Parrot Smell</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/websitePS/public/assets/css/style.css">
    <style>
        :root {
            --primary-color: #009688;
            --secondary-color: #fdf5e6;
            --text-color: #5d4037;
            --heading-font: 'Playfair Display', serif;
            --body-font: 'Roboto', sans-serif;
        }
        
        body {
            font-family: var(--body-font);
            color: var(--text-color);
        }
        
        /* Hero Section */
        .hero-section {
            position: relative;
            padding: 8rem 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            background: url('https://img.freepik.com/premium-photo/contact-us-customer-support-hotline-people-connect-businessman-using-laptop-touching-virtual-screen-contact-icons_43780-7478.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            overflow: hidden;
        }
        
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: transparent;
        }
        
        .hero-content {
            position: relative;
            z-index: 2;
            color: white;
        }
        
        .hero-badge {
            display: inline-block;
            background: rgba(255,255,255,0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.5);
            color: var(--primary-color);
            padding: 0.5rem 1.5rem;
            border-radius: 50px;
            font-size: 0.9rem;
            font-weight: 500;
            margin-bottom: 1rem;
            animation: fadeInUp 1s ease;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }
        
        .hero-title {
            font-family: var(--heading-font);
            font-size: 4rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.8);
            animation: fadeInLeft 1s ease;
        }
        
        .hero-subtitle {
            font-size: 1.4rem;
            margin-bottom: 2.5rem;
            line-height: 1.6;
            opacity: 0.9;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.8);
            animation: fadeInLeft 1s ease 0.2s both;
        }
        
        .hero-features {
            display: flex;
            gap: 2rem;
            margin-bottom: 3rem;
            animation: fadeInUp 1s ease 0.4s both;
        }
        
        .hero-feature {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(255,255,255,0.9);
            backdrop-filter: blur(10px);
            padding: 0.75rem 1.5rem;
            border-radius: 25px;
            border: 1px solid rgba(255,255,255,0.5);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }
        
        .hero-feature i {
            font-size: 1.2rem;
            color: var(--primary-color);
        }
        
        .hero-feature span {
            color: var(--text-color);
            font-weight: 500;
        }
        
        .floating-card {
            position: absolute;
            top: 50%;
            right: 10%;
            transform: translateY(-50%);
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255,255,255,0.3);
            border-radius: 20px;
            padding: 2rem;
            color: white;
            animation: float 3s ease-in-out infinite;
        }
        
        .floating-card i {
            font-size: 3rem;
            margin-bottom: 1rem;
            display: block;
        }
        
        /* Contact Section */
        .contact-section {
            padding: 5rem 0;
            background: #f8f9fa;
        }
        
        .contact-title {
            font-family: var(--heading-font);
            color: var(--text-color);
            font-size: 2.5rem;
            text-align: center;
            margin-bottom: 1rem;
        }
        
        .contact-subtitle {
            text-align: center;
            color: #6c757d;
            font-size: 1.1rem;
            margin-bottom: 3rem;
        }
        
        .contact-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 2rem;
            margin-bottom: 4rem;
        }
        
        .contact-card {
            background: white;
            border-radius: 20px;
            padding: 2.5rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .contact-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
            transition: left 0.5s;
        }
        
        .contact-card:hover::before {
            left: 100%;
        }
        
        .contact-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }
        
        .contact-card-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--primary-color), #00796b);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            color: white;
            font-size: 2rem;
        }
        
        .contact-card-title {
            font-family: var(--heading-font);
            color: var(--text-color);
            font-size: 1.5rem;
            text-align: center;
            margin-bottom: 1rem;
        }
        
        .contact-card-content {
            text-align: center;
            color: #6c757d;
            line-height: 1.6;
        }
        
        .contact-info-item {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
            padding: 1rem;
            background: #f8f9fa;
            border-radius: 10px;
            transition: all 0.3s ease;
        }
        
        .contact-info-item:hover {
            background: var(--primary-color);
            color: white;
            transform: translateX(10px);
        }
        
        .contact-info-item i {
            color: var(--primary-color);
            margin-right: 1rem;
            font-size: 1.2rem;
            width: 20px;
            transition: color 0.3s ease;
        }
        
        .contact-info-item:hover i {
            color: white;
        }
        
        /* Form Section */
        .form-section {
            background: white;
            border-radius: 20px;
            padding: 3rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            margin-bottom: 4rem;
        }
        
        .form-title {
            font-family: var(--heading-font);
            color: var(--text-color);
            font-size: 2rem;
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .form-control {
            border: 2px solid #e9ecef;
            border-radius: 15px;
            padding: 1rem 1.5rem;
            margin-bottom: 1.5rem;
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(0, 150, 136, 0.25);
            transform: translateY(-2px);
        }
        
        .form-select {
            border: 2px solid #e9ecef;
            border-radius: 15px;
            padding: 1rem 1.5rem;
            margin-bottom: 1.5rem;
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        
        .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(0, 150, 136, 0.25);
            transform: translateY(-2px);
        }
        
        textarea.form-control {
            min-height: 150px;
            resize: vertical;
        }
        
        .btn-submit {
            background: linear-gradient(135deg, var(--primary-color), #00796b);
            border: none;
            color: white;
            padding: 1rem 2.5rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .btn-submit:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0, 150, 136, 0.3);
            color: white;
        }
        
        /* Social Media */
        .social-section {
            text-align: center;
            margin-bottom: 4rem;
        }
        
        .social-title {
            font-family: var(--heading-font);
            color: var(--text-color);
            font-size: 2rem;
            margin-bottom: 2rem;
        }
        
        .social-buttons {
            display: flex;
            justify-content: center;
            gap: 1.5rem;
        }
        
        .social-btn {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-decoration: none;
            font-size: 1.5rem;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .social-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, transparent, rgba(255,255,255,0.3), transparent);
            transform: translateX(-100%);
            transition: transform 0.3s ease;
        }
        
        .social-btn:hover::before {
            transform: translateX(100%);
        }
        
        .social-btn:hover {
            transform: translateY(-5px) scale(1.1);
            color: white;
        }
        
        .social-btn.facebook {
            background: linear-gradient(45deg, #1877f2, #0d6efd);
        }
        
        .social-btn.instagram {
            background: linear-gradient(45deg, #f09433, #e6683c, #dc2743, #cc2366, #bc1888);
        }
        
        .social-btn.youtube {
            background: linear-gradient(45deg, #ff0000, #cc0000);
        }
        
        .social-btn.tiktok {
            background: linear-gradient(45deg, #000000, #25f4ee, #fe2c55);
        }
        
        /* Map Section */
        .map-section {
            background: white;
            border-radius: 20px;
            padding: 3rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        
        .map-title {
            font-family: var(--heading-font);
            color: var(--text-color);
            font-size: 2rem;
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .map-frame {
            width: 100%;
            height: 500px;
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        
        .map-instruction {
            text-align: center;
            margin-top: 1.5rem;
            color: #6c757d;
            font-style: italic;
            padding: 1rem;
            background: #f8f9fa;
            border-radius: 10px;
        }
        
        /* Animations */
        @keyframes fadeInLeft {
            from {
                opacity: 0;
                transform: translateX(-50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes float {
            0%, 100% {
                transform: translateY(-50%) translateX(0);
            }
            50% {
                transform: translateY(-50%) translateX(10px);
            }
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            .hero-section {
                padding: 4rem 0;
                min-height: 70vh;
            }
            
            .hero-title {
                font-size: 2.5rem;
            }
            
            .hero-subtitle {
                font-size: 1.1rem;
            }
            
            .hero-features {
                flex-direction: column;
                gap: 1rem;
            }
            
            .floating-card {
                position: relative;
                top: auto;
                right: auto;
                transform: none;
                margin-top: 2rem;
            }
            
            .contact-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }
            
            .contact-card {
                padding: 2rem;
            }
            
            .form-section {
                padding: 2rem;
            }
            
            .social-buttons {
                flex-wrap: wrap;
                gap: 1rem;
            }
            
            .map-frame {
                height: 300px;
            }
        }
        
        /* Footer Styles */
        .footer {
            background-color: var(--text-color);
            color: var(--secondary-color);
            padding: 3rem 0 2rem;
            margin-top: 4rem;
        }
        
        .footer a {
            color: var(--secondary-color);
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        .footer a:hover {
            color: var(--primary-color);
            text-decoration: none;
        }
        
        .footer h6 {
            color: var(--secondary-color);
            margin-bottom: 1.5rem;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <?php include __DIR__ . '/layouts/navbar.php'; ?>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <div class="hero-content">
                        <div class="hero-badge">
                            <i class="fas fa-phone-alt me-2"></i>
                            Liên Hệ Ngay
                        </div>
                        <h1 class="hero-title">Hãy Liên Hệ Với Chúng Tôi</h1>
                        <p class="hero-subtitle">
                            Chúng tôi luôn sẵn sàng lắng nghe và hỗ trợ bạn. Hãy để lại tin nhắn hoặc liên hệ trực tiếp để được tư vấn tốt nhất về những chiếc bánh ngọt ngào của Parrot Smell.
                        </p>
                        <div class="hero-features">
                            <div class="hero-feature">
                                <i class="fas fa-clock"></i>
                                <span>24/7 Hỗ Trợ</span>
                            </div>
                            <div class="hero-feature">
                                <i class="fas fa-shipping-fast"></i>
                                <span>Giao Hàng Nhanh</span>
                            </div>
                            <div class="hero-feature">
                                <i class="fas fa-heart"></i>
                                <span>Chất Lượng Tốt</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="floating-card">
                        <i class="fas fa-headset"></i>
                        <h4>Hỗ Trợ Khách Hàng</h4>
                        <p>Chúng tôi luôn sẵn sàng phục vụ bạn mọi lúc!</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="contact-section">
        <div class="container">
            <h2 class="contact-title">Thông Tin Liên Hệ</h2>
            <p class="contact-subtitle">Liên hệ với chúng tôi qua nhiều cách khác nhau</p>
            
            <div class="contact-grid">
                <!-- Address Card -->
                <div class="contact-card">
                    <div class="contact-card-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <h3 class="contact-card-title">Địa Chỉ</h3>
                    <div class="contact-card-content">
                        <p>02 Võ Oanh, Phường 25, Quận Bình Thạnh, TP.HCM</p>
                        <div class="contact-info-item">
                            <i class="fas fa-location-dot"></i>
                            <div>
                                <strong>Vị trí:</strong> Trung tâm thành phố, dễ tìm
                            </div>
                        </div>
                        <div class="contact-info-item">
                            <i class="fas fa-parking"></i>
                            <div>
                                <strong>Bãi xe:</strong> Có sẵn bãi đỗ xe miễn phí
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Phone Card -->
                <div class="contact-card">
                    <div class="contact-card-icon">
                        <i class="fas fa-phone"></i>
                    </div>
                    <h3 class="contact-card-title">Điện Thoại</h3>
                    <div class="contact-card-content">
                        <p>0767 150 474</p>
                        <div class="contact-info-item">
                            <i class="fas fa-clock"></i>
                            <div>
                                <strong>Giờ làm việc:</strong> 7:00 - 22:00
                            </div>
                        </div>
                        <div class="contact-info-item">
                            <i class="fas fa-calendar"></i>
                            <div>
                                <strong>Ngày làm việc:</strong> Thứ 2 - Chủ nhật
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Email Card -->
                <div class="contact-card">
                    <div class="contact-card-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <h3 class="contact-card-title">Email</h3>
                    <div class="contact-card-content">
                        <p>cucxacdufong@gmail.com</p>
                        <div class="contact-info-item">
                            <i class="fas fa-reply"></i>
                            <div>
                                <strong>Phản hồi:</strong> Trong vòng 24h
                            </div>
                        </div>
                        <div class="contact-info-item">
                            <i class="fas fa-shield-alt"></i>
                            <div>
                                <strong>Bảo mật:</strong> Thông tin được mã hóa
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="form-section">
                <h3 class="form-title">Gửi Tin Nhắn Cho Chúng Tôi</h3>
                <form>
                    <div class="row">
                        <div class="col-md-6">
                            <input type="text" class="form-control" placeholder="Họ và tên *" required>
                        </div>
                        <div class="col-md-6">
                            <input type="email" class="form-control" placeholder="Email *" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <input type="tel" class="form-control" placeholder="Số điện thoại">
                        </div>
                        <div class="col-md-6">
                            <select class="form-select">
                                <option selected>Chọn chủ đề</option>
                                <option value="1">Đặt hàng</option>
                                <option value="2">Hỗ trợ khách hàng</option>
                                <option value="3">Góp ý</option>
                                <option value="4">Khác</option>
                            </select>
                        </div>
                    </div>
                    <textarea class="form-control" placeholder="Nội dung tin nhắn *" required></textarea>
                    <div class="text-center">
                        <button type="submit" class="btn btn-submit">
                            <i class="fas fa-paper-plane"></i>
                            Gửi Tin Nhắn
                        </button>
                    </div>
                </form>
            </div>

            <!-- Social Media -->
            <div class="social-section">
                <h3 class="social-title">Theo Dõi Chúng Tôi</h3>
                <div class="social-buttons">
                    <a href="#" class="social-btn facebook">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="social-btn instagram">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="social-btn youtube">
                        <i class="fab fa-youtube"></i>
                    </a>
                    <a href="#" class="social-btn tiktok">
                        <i class="fab fa-tiktok"></i>
                    </a>
                </div>
            </div>

            <!-- Map Section -->
            <div class="map-section">
                <h3 class="map-title">Bản Đồ</h3>
                <iframe 
                    class="map-frame"
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3918.484123456789!2d106.71234567890123!3d10.80123456789012!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x317529292e768d9d%3A0xf8f1c87e7c6c3b3a!2s02%20V%C3%B5%20Oanh%2C%20Ph%C6%B0%E1%BB%9Dng%2025%2C%20Qu%E1%BA%ADn%20B%C3%ACnh%20Th%E1%BA%A1nh%2C%20Th%C3%A0nh%20ph%E1%BB%91%20H%E1%BB%93%20Ch%C3%AD%20Minh!5e0!3m2!1svi!2s!4v1234567890123"
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
                <div class="map-instruction">
                    <i class="fas fa-info-circle me-2"></i>
                    Sử dụng ctrl + cuộn để thu phóng bản đồ hoặc click để xem chi tiết
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer pt-5 pb-4">
        <div class="container text-center text-md-start">
            <div class="row">
                <div class="col-md-4 col-lg-4 col-xl-4 mx-auto mb-4">
                    <h6 class="text-uppercase fw-bold">🦜 Parrot Smell</h6>
                    <hr class="mb-4 mt-0 d-inline-block mx-auto" style="width: 60px; background-color: var(--primary-color); height: 2px"/>
                    <p>Nơi mỗi chiếc bánh là một tác phẩm nghệ thuật, mang đến niềm vui và sự ngọt ngào cho cuộc sống của bạn.</p>
                </div>
                <div class="col-md-4 col-lg-2 col-xl-2 mx-auto mb-4">
                    <h6 class="text-uppercase fw-bold">Liên kết</h6>
                    <hr class="mb-4 mt-0 d-inline-block mx-auto" style="width: 60px; background-color: var(--primary-color); height: 2px"/>
                    <p><a href="/websitePS/public/pages/about">Về chúng tôi</a></p>
                    <p><a href="#!">Chính sách giao hàng</a></p>
                    <p><a href="#!">Điều khoản dịch vụ</a></p>
                </div>
                <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
                    <h6 class="text-uppercase fw-bold">Liên hệ</h6>
                    <hr class="mb-4 mt-0 d-inline-block mx-auto" style="width: 60px; background-color: var(--primary-color); height: 2px"/>
                    <p><i class="fas fa-home me-3"></i> 02 Võ Oanh, Phường 25, Quận Bình Thạnh, TP.HCM</p>
                    <p><i class="fas fa-envelope me-3"></i> cucxacdufong@gmail.com</p>
                    <p><i class="fas fa-phone me-3"></i> 0767 150 474</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
