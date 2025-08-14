<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Về Chúng Tôi - Parrot Smell</title>
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
        .navbar {
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            background-color: #fff;
        }
        .navbar-brand {
            font-family: var(--heading-font);
            font-weight: 700;
            color: var(--primary-color) !important;
        }
        .btn-primary-custom {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
            padding: 12px 30px;
            font-weight: 500;
            transition: all 0.3s;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.3);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }
        .btn-primary-custom:hover {
            background-color: #00796b;
            border-color: #00796b;
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0,0,0,0.3);
        }
        .btn-outline-primary-custom {
            background-color: rgba(255,255,255,0.9);
            border-color: var(--primary-color);
            color: var(--primary-color);
            padding: 12px 30px;
            font-weight: 500;
            transition: all 0.3s;
            text-shadow: none;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }
        .btn-outline-primary-custom:hover {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0,0,0,0.3);
        }
        
        /* Hero Section */
        .hero-section {
            background: url('https://media.istockphoto.com/id/527613951/vi/anh/v%E1%BB%81-ch%C3%BAng-t%C3%B4i-kh%C3%A1i-ni%E1%BB%87m-v%C3%A0-b%C3%B3ng-t%E1%BB%91i.jpg?b=1&s=612x612&w=0&k=20&c=IECQ-nmt0-8iIHhThPOnYBhDRObpXmrCOC0UZ9fuySU=');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: white;
            padding: 8rem 0;
            position: relative;
            overflow: hidden;
            min-height: 100vh;
            display: flex;
            align-items: center;
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
        }
        .hero-title {
            font-family: var(--heading-font);
            font-size: 4rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.8);
            animation: fadeInLeft 1s ease-out;
        }
        .hero-subtitle {
            font-size: 1.4rem;
            margin-bottom: 2.5rem;
            opacity: 0.9;
            line-height: 1.6;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.8);
            animation: fadeInLeft 1s ease-out 0.2s both;
        }
        .hero-image-container {
            position: relative;
            z-index: 2;
            animation: fadeInRight 1s ease-out 0.4s both;
        }
        .hero-image {
            width: 100%;
            height: 500px;
            object-fit: cover;
            border-radius: 25px;
            box-shadow: 0 25px 50px rgba(0,0,0,0.3);
            transform: rotate(2deg);
            transition: all 0.4s ease;
        }
        .hero-image:hover {
            transform: rotate(0deg) scale(1.02);
            box-shadow: 0 30px 60px rgba(0,0,0,0.4);
        }
        .hero-badge {
            display: inline-block;
            background: rgba(255,255,255,0.9);
            color: var(--primary-color);
            padding: 1rem 2rem;
            border-radius: 30px;
            font-weight: 600;
            font-size: 1.1rem;
            margin-bottom: 2rem;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.5);
            animation: fadeInUp 1s ease-out 0.6s both;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }
        
        .hero-features {
            display: flex;
            gap: 2rem;
            margin-bottom: 2.5rem;
            animation: fadeInLeft 1s ease-out 0.8s both;
        }
        
        .hero-feature {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(255,255,255,0.9);
            padding: 0.8rem 1.2rem;
            border-radius: 20px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.5);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }
        
        .hero-feature i {
            color: var(--primary-color);
            font-size: 1.2rem;
        }
        
        .hero-feature span {
            font-weight: 500;
            font-size: 0.9rem;
            color: var(--text-color);
        }
        
        .floating-card {
            position: absolute;
            top: -20px;
            right: -20px;
            background: rgba(255,255,255,0.95);
            border-radius: 15px;
            padding: 1.5rem;
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.3);
            animation: float 3s ease-in-out infinite;
        }
        
        .floating-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, var(--primary-color) 0%, #00796b 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
            color: white;
            font-size: 1.5rem;
        }
        
        .floating-content h4 {
            color: var(--text-color);
            margin-bottom: 0.5rem;
            font-weight: 600;
        }
        
        .floating-content p {
            color: #6c757d;
            margin: 0;
            font-size: 0.9rem;
        }
        
        @keyframes float {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-10px);
            }
        }
        
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
        
        @keyframes fadeInRight {
            from {
                opacity: 0;
                transform: translateX(50px);
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
        
        /* Story Section */
        .story-section {
            padding: 5rem 0;
            background-color: #f8f9fa;
        }
        .story-content {
            background: white;
            border-radius: 20px;
            padding: 3rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            position: relative;
        }
        .story-content::before {
            content: '';
            position: absolute;
            top: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 4px;
            background: var(--primary-color);
            border-radius: 2px;
        }
        .story-title {
            font-family: var(--heading-font);
            color: var(--primary-color);
            font-size: 2.5rem;
            margin-bottom: 2rem;
            text-align: center;
        }
        .story-text {
            font-size: 1.1rem;
            line-height: 1.8;
            color: #6c757d;
            margin-bottom: 2rem;
        }
        .story-image {
            width: 100%;
            height: 400px;
            object-fit: cover;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
            transition: all 0.4s ease;
        }
        .story-image:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 25px 50px rgba(0,0,0,0.3);
        }
        
        /* Values Section */
        .values-section {
            padding: 5rem 0;
            background: white;
        }
        .values-title {
            font-family: var(--heading-font);
            color: var(--text-color);
            font-size: 2.5rem;
            text-align: center;
            margin-bottom: 3rem;
        }
        .value-card {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 20px;
            padding: 2.5rem;
            text-align: center;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            height: 100%;
            border: none;
        }
        .value-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }
        .value-icon {
            width: 80px;
            height: 80px;
            background: var(--primary-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            color: white;
            font-size: 2rem;
        }
        .value-title {
            font-family: var(--heading-font);
            color: var(--text-color);
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }
        .value-description {
            color: #6c757d;
            line-height: 1.6;
        }
        
        /* Stats Section */
        .stats-section {
            padding: 4rem 0;
            background: linear-gradient(135deg, var(--primary-color) 0%, #00796b 100%);
            color: white;
        }
        .stat-item {
            text-align: center;
            padding: 2rem 1rem;
        }
        .stat-number {
            font-family: var(--heading-font);
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            display: block;
        }
        .stat-label {
            font-size: 1.1rem;
            opacity: 0.9;
        }
        
        /* Team Section */
        .team-section {
            padding: 5rem 0;
            background-color: #f8f9fa;
        }
        .team-title {
            font-family: var(--heading-font);
            color: var(--text-color);
            font-size: 2.5rem;
            text-align: center;
            margin-bottom: 1rem;
        }
        .team-subtitle {
            text-align: center;
            color: #6c757d;
            font-size: 1.1rem;
            margin-bottom: 3rem;
        }
        
        .team-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .team-member {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            transition: all 0.4s ease;
            position: relative;
        }
        
        .team-member:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }
        
        .member-image {
            position: relative;
            overflow: hidden;
            height: 300px;
        }
        
        .member-avatar {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
        }
        
        .team-member:hover .member-avatar {
            transform: scale(1.1);
        }
        
        .member-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(transparent, rgba(0,0,0,0.7));
            display: flex;
            align-items: flex-end;
            justify-content: center;
            padding: 2rem;
            opacity: 0;
            transition: opacity 0.4s ease;
        }
        
        .team-member:hover .member-overlay {
            opacity: 1;
        }
        
        .member-social {
            display: flex;
            gap: 1rem;
        }
        
        .member-social a {
            width: 40px;
            height: 40px;
            background: rgba(255,255,255,0.9);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-color);
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .member-social a:hover {
            background: var(--primary-color);
            color: white;
            transform: translateY(-3px);
        }
        
        .member-info {
            padding: 2rem;
            text-align: center;
        }
        
        .member-name {
            font-family: var(--heading-font);
            color: var(--text-color);
            font-size: 1.4rem;
            margin-bottom: 0.5rem;
        }
        
        .member-role {
            color: var(--primary-color);
            font-weight: 600;
            margin-bottom: 1rem;
            font-size: 1rem;
        }
        
        .member-description {
            color: #6c757d;
            font-size: 0.95rem;
            line-height: 1.6;
            margin: 0;
        }
        
        /* Gallery Section */
        .gallery-section {
            padding: 5rem 0;
            background: white;
        }
        .gallery-title {
            font-family: var(--heading-font);
            color: var(--text-color);
            font-size: 2.5rem;
            text-align: center;
            margin-bottom: 1rem;
        }
        .gallery-subtitle {
            text-align: center;
            color: #6c757d;
            font-size: 1.1rem;
            margin-bottom: 3rem;
        }
        .gallery-item {
            position: relative;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            transition: all 0.4s ease;
        }
        .gallery-item:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        }
        .gallery-image {
            width: 100%;
            height: 300px;
            object-fit: cover;
            transition: transform 0.4s ease;
        }
        .gallery-item:hover .gallery-image {
            transform: scale(1.1);
        }
        .gallery-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(transparent, rgba(0,0,0,0.8));
            color: white;
            padding: 2rem 1.5rem 1.5rem;
            transform: translateY(100%);
            transition: transform 0.4s ease;
        }
        .gallery-item:hover .gallery-overlay {
            transform: translateY(0);
        }
        .gallery-overlay h4 {
            font-family: var(--heading-font);
            margin-bottom: 0.5rem;
            font-size: 1.3rem;
        }
        .gallery-overlay p {
            margin: 0;
            opacity: 0.9;
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            .hero-section {
                padding: 4rem 0;
                min-height: auto;
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
            .hero-feature {
                padding: 0.6rem 1rem;
            }
            .hero-image {
                height: 300px;
                margin-top: 2rem;
            }
            .floating-card {
                position: relative;
                top: 0;
                right: 0;
                margin-top: 1rem;
            }
            .story-content {
                padding: 2rem;
            }
            .story-image {
                height: 250px;
                margin-top: 2rem;
            }
            .value-card {
                margin-bottom: 2rem;
            }
            .stat-number {
                font-size: 2.5rem;
            }
            .team-grid {
                grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
                gap: 1.5rem;
            }
            .member-image {
                height: 250px;
            }
            .member-info {
                padding: 1.5rem;
            }
            .gallery-image {
                height: 200px;
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
                            <i class="fas fa-heart me-2"></i>
                            Tình Yêu & Đam Mê
                        </div>
                        <h1 class="hero-title">Về Chúng Tôi</h1>
                        <p class="hero-subtitle">Khám phá câu chuyện đằng sau những chiếc bánh ngọt tuyệt vời của Parrot Smell. Nơi mỗi chiếc bánh là một tác phẩm nghệ thuật được tạo nên từ tình yêu và đam mê.</p>
                        <div class="hero-features">
                            <div class="hero-feature">
                                <i class="fas fa-star"></i>
                                <span>Chất lượng cao cấp</span>
                            </div>
                            <div class="hero-feature">
                                <i class="fas fa-award"></i>
                                <span>5 năm kinh nghiệm</span>
                            </div>
                            <div class="hero-feature">
                                <i class="fas fa-users"></i>
                                <span>5000+ khách hàng</span>
                            </div>
                        </div>
                        <a href="#story" class="btn btn-primary-custom btn-lg">
                            <i class="fas fa-arrow-down me-2"></i>
                            Khám phá ngay
                        </a>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="hero-image-container">
                        <img src="https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?q=80&w=2070&auto=format&fit=crop" 
                             alt="Bánh kem Parrot Smell" 
                             class="hero-image">
                        <div class="floating-card">
                            <div class="floating-icon">
                                <i class="fas fa-crown"></i>
                            </div>
                            <div class="floating-content">
                                <h4>Parrot Smell</h4>
                                <p>Nghệ thuật làm bánh</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Story Section -->
    <section id="story" class="story-section">
        <div class="container">
            <div class="story-content">
                <h2 class="story-title">Câu Chuyện Của Chúng Tôi</h2>
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <p class="story-text">
                            Được thành lập với niềm đam mê vô tận dành cho những chiếc bánh ngọt, Parrot Smell tự hào là điểm đến lý tưởng cho những ai yêu thích hương vị tinh tế và nghệ thuật làm bánh truyền thống kết hợp với sự sáng tạo hiện đại.
                        </p>
                        <p class="story-text">
                            Chúng tôi cam kết sử dụng những nguyên liệu chất lượng cao nhất, những công thức độc đáo và sự sáng tạo không ngừng để mang đến cho khách hàng những trải nghiệm ẩm thực tuyệt vời nhất. Mỗi chiếc bánh không chỉ là một món ăn, mà còn là một tác phẩm nghệ thuật được tạo nên từ tâm huyết và tình yêu.
                        </p>
                        <p class="story-text">
                            Từ những ngày đầu tiên, chúng tôi đã đặt chất lượng và sự hài lòng của khách hàng lên hàng đầu. Mỗi chiếc bánh được làm thủ công với sự tỉ mỉ và cẩn thận, đảm bảo mang đến hương vị hoàn hảo cho mọi dịp đặc biệt.
                        </p>
                    </div>
                    <div class="col-lg-6">
                        <img src="https://media.istockphoto.com/id/1472441771/photo/modern-kitchen-with-homemade-gingerbread-cookies-and-gift-boxes-on-kitchen-counter-baking-and.webp?a=1&b=1&s=612x612&w=0&k=20&c=VD9ZOFQzRSdq8lS8jhvzLFC0hnf3Dg2Xa8V2wL-7_y8=" 
                             alt="Bếp chính hiện đại" 
                             class="story-image img-fluid">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Values Section -->
    <section class="values-section">
        <div class="container">
            <h2 class="values-title">Giá Trị Cốt Lõi</h2>
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="value-card">
                        <div class="value-icon">
                            <i class="fas fa-heart"></i>
                        </div>
                        <h3 class="value-title">Tình Yêu & Đam Mê</h3>
                        <p class="value-description">Mỗi chiếc bánh được tạo nên từ tình yêu và đam mê thực sự dành cho nghệ thuật làm bánh.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="value-card">
                        <div class="value-icon">
                            <i class="fas fa-star"></i>
                        </div>
                        <h3 class="value-title">Chất Lượng Tuyệt Hảo</h3>
                        <p class="value-description">Chúng tôi chỉ sử dụng những nguyên liệu tốt nhất để đảm bảo chất lượng hoàn hảo.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="value-card">
                        <div class="value-icon">
                            <i class="fas fa-lightbulb"></i>
                        </div>
                        <h3 class="value-title">Sáng Tạo Không Ngừng</h3>
                        <p class="value-description">Luôn tìm tòi và sáng tạo những hương vị mới để làm hài lòng khách hàng.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="stat-item">
                        <span class="stat-number">5000+</span>
                        <div class="stat-label">Khách hàng hài lòng</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="stat-item">
                        <span class="stat-number">100+</span>
                        <div class="stat-label">Loại bánh đa dạng</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="stat-item">
                        <span class="stat-number">5</span>
                        <div class="stat-label">Năm kinh nghiệm</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="stat-item">
                        <span class="stat-number">24/7</span>
                        <div class="stat-label">Hỗ trợ khách hàng</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Gallery Section -->
    <section class="gallery-section">
        <div class="container">
            <h2 class="gallery-title">Không Gian Làm Bánh</h2>
            <p class="gallery-subtitle">Khám phá môi trường làm việc chuyên nghiệp và hiện đại của chúng tôi</p>
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="gallery-item">
                        <img src="https://media.istockphoto.com/id/1472441771/photo/modern-kitchen-with-homemade-gingerbread-cookies-and-gift-boxes-on-kitchen-counter-baking-and.webp?a=1&b=1&s=612x612&w=0&k=20&c=VD9ZOFQzRSdq8lS8jhvzLFC0hnf3Dg2Xa8V2wL-7_y8=" 
                             alt="Bếp chính hiện đại" 
                             class="gallery-image">
                        <div class="gallery-overlay">
                            <h4>Bếp Chính</h4>
                            <p>Không gian làm việc hiện đại</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="gallery-item">
                        <img src="https://images.pexels.com/photos/94443/pexels-photo-94443.jpeg" 
                             alt="Nguyên liệu chất lượng" 
                             class="gallery-image">
                        <div class="gallery-overlay">
                            <h4>Nguyên Liệu</h4>
                            <p>Chất lượng cao cấp</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="gallery-item">
                        <img src="https://plus.unsplash.com/premium_photo-1722686461601-b2a018a4213b?q=80&w=955&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" 
                             alt="Thành phẩm" 
                             class="gallery-image">
                        <div class="gallery-overlay">
                            <h4>Thành Phẩm</h4>
                            <p>Tác phẩm nghệ thuật</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section class="team-section">
        <div class="container">
            <h2 class="team-title">Đội Ngũ Của Chúng Tôi</h2>
            <p class="team-subtitle">Những con người tài năng đằng sau những chiếc bánh tuyệt vời</p>
            
            <!-- Team Grid -->
            <div class="team-grid">
                <!-- Team Member 1 -->
                <div class="team-member">
                    <div class="member-image">
                        <img src="https://plus.unsplash.com/premium_photo-1661962655543-b88aafe382e9?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MXx8bWVtZXxlbnwwfHwwfHx8MA%3D%3D" 
                             alt="Chef chính" 
                             class="member-avatar">
                        <div class="member-overlay">
                            <div class="member-social">
                                <a href="#"><i class="fab fa-facebook"></i></a>
                                <a href="#"><i class="fab fa-instagram"></i></a>
                                <a href="#"><i class="fab fa-linkedin"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="member-info">
                        <h4 class="member-name">Lê Hoàng Phi Ngân</h4>
                        <p class="member-role">Chef Chính</p>
                        <p class="member-description">Với hơn 10 năm kinh nghiệm trong nghề bánh, chị Ngân là người tạo nên những công thức độc đáo của Parrot Smell.</p>
                    </div>
                </div>

                <!-- Team Member 2 -->
                <div class="team-member">
                    <div class="member-image">
                        <img src="https://images.unsplash.com/photo-1533738363-b7f9aef128ce?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8OHx8bWVtZXxlbnwwfHwwfHx8MA%3D%3D" 
                             alt="Quản lý chất lượng" 
                             class="member-avatar">
                        <div class="member-overlay">
                            <div class="member-social">
                                <a href="#"><i class="fab fa-facebook"></i></a>
                                <a href="#"><i class="fab fa-instagram"></i></a>
                                <a href="#"><i class="fab fa-linkedin"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="member-info">
                        <h4 class="member-name">Đinh Thị Thúy Vy</h4>
                        <p class="member-role">Quản Lý Chất Lượng</p>
                        <p class="member-description">Chị Vy đảm bảo mọi nguyên liệu và quy trình sản xuất đều đạt tiêu chuẩn chất lượng cao nhất.</p>
                    </div>
                </div>

                <!-- Team Member 3 -->
                <div class="team-member">
                    <div class="member-image">
                        <img src="https://images.unsplash.com/photo-1543852786-1cf6624b9987?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTB8fG1lbWV8ZW58MHx8MHx8fDA%3D" 
                             alt="Chuyên gia trang trí" 
                             class="member-avatar">
                        <div class="member-overlay">
                            <div class="member-social">
                                <a href="#"><i class="fab fa-facebook"></i></a>
                                <a href="#"><i class="fab fa-instagram"></i></a>
                                <a href="#"><i class="fab fa-linkedin"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="member-info">
                        <h4 class="member-name">Lương Tú Linh</h4>
                        <p class="member-role">Chuyên Gia Trang Trí</p>
                        <p class="member-description">Chị Linh là nghệ nhân trang trí bánh, biến mỗi chiếc bánh thành một tác phẩm nghệ thuật đẹp mắt.</p>
                    </div>
                </div>

                <!-- Team Member 4 -->
                <div class="team-member">
                    <div class="member-image">
                        <img src="https://media.istockphoto.com/id/1366434595/photo/portrait-of-fluffy-white-cat-with-funny-smile-grimace-merry-christmas-decoration-and-red.webp?a=1&b=1&s=612x612&w=0&k=20&c=VOwnp_BOSyerK1aOKzgkPhzhvFIqQKl3OHV1mwm9Akc=" 
                             alt="Nhân viên bán hàng" 
                             class="member-avatar">
                        <div class="member-overlay">
                            <div class="member-social">
                                <a href="#"><i class="fab fa-facebook"></i></a>
                                <a href="#"><i class="fab fa-instagram"></i></a>
                                <a href="#"><i class="fab fa-linkedin"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="member-info">
                        <h4 class="member-name">Nguyễn Hoàng Phương</h4>
                        <p class="member-role">Nhân Viên Bán Hàng</p>
                        <p class="member-description">Anh Phương là người tư vấn nhiệt tình, giúp khách hàng chọn lựa những chiếc bánh phù hợp nhất.</p>
                    </div>
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
