<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Khuyến Mãi - Parrot Smell</title>
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
        }
        .btn-primary-custom:hover {
            background-color: #00796b;
            border-color: #00796b;
            transform: translateY(-2px);
        }
        .btn-outline-primary-custom {
            background-color: transparent;
            border-color: var(--primary-color);
            color: var(--primary-color);
            padding: 12px 30px;
            font-weight: 500;
            transition: all 0.3s;
        }
        .btn-outline-primary-custom:hover {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
        }
        
        /* Hero Section */
        .hero-section {
            background: url('https://images.unsplash.com/photo-1588195538326-c5b1e9f80a1b?q=80&w=1950&auto=format&fit=crop') no-repeat center center;
            background-size: cover;
            background-attachment: fixed;
            color: white;
            padding: 6rem 0;
            text-align: center;
            position: relative;
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
            z-index: 1;
        }
        
        .hero-section .container {
            position: relative;
            z-index: 2;
        }
        .hero-title {
            font-family: var(--heading-font);
            font-size: 3.2rem;
            margin-bottom: 1.25rem;
            animation: fadeInUp 1s ease-out;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
        }
        .hero-subtitle {
            font-size: 1.1rem;
            margin-bottom: 2rem;
            opacity: 0.95;
            animation: fadeInUp 1s ease-out 0.2s both;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.5);
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
        }
        .hero-badge {
            display: inline-block;
            background: rgba(255,255,255,0.9);
            color: var(--primary-color);
            padding: 0.8rem 1.5rem;
            border-radius: 40px;
            font-weight: 600;
            font-size: 1rem;
            box-shadow: 0 8px 25px rgba(0,0,0,0.3);
            animation: fadeInUp 1s ease-out 0.4s both;
            transition: all 0.3s ease;
        }
        
        .hero-badge:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.4);
        }
        
        /* Hero Image Section */
        .hero-image-section {
            position: relative;
            margin: 0;
            padding: 0;
        }
        
        .hero-image-container {
            position: relative;
            height: 400px;
            overflow: hidden;
        }
        
        .hero-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            filter: brightness(0.7);
        }
        
        .hero-image-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: transparent;
            display: flex;
            align-items: center;
            color: white;
        }
        
        .hero-image-content {
            padding: 2rem 0;
        }
        
        .hero-image-title {
            font-family: var(--heading-font);
            font-size: 2.5rem;
            margin-bottom: 1.25rem;
            animation: fadeInLeft 1s ease-out;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.8);
        }
        
        .hero-image-description {
            font-size: 1rem;
            line-height: 1.6;
            margin-bottom: 1.5rem;
            opacity: 0.9;
            animation: fadeInLeft 1s ease-out 0.2s both;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.8);
        }
        
        .hero-image-features {
            margin-bottom: 2rem;
            animation: fadeInLeft 1s ease-out 0.4s both;
        }
        
        .hero-image-features .feature-item {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
            font-size: 1.1rem;
        }
        
        .hero-image-features .feature-item i {
            margin-right: 1rem;
            font-size: 1.3rem;
            color: #ffd700;
        }
        
        .hero-image-visual {
            position: relative;
            height: 350px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .floating-card {
            position: absolute;
            background: rgba(255,255,255,0.95);
            border-radius: 15px;
            padding: 1.5rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            backdrop-filter: blur(10px);
            animation: float 3s ease-in-out infinite;
            border: 2px solid rgba(255,255,255,0.3);
        }
        
        .floating-card:nth-child(1) {
            top: 20%;
            left: 10%;
            animation-delay: 0s;
        }
        
        .floating-card:nth-child(2) {
            bottom: 20%;
            right: 10%;
            animation-delay: 1.5s;
        }
        
        .card-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(135deg, #ff6b6b 0%, #ffa726 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 0.8rem;
            box-shadow: 0 4px 12px rgba(255,107,107,0.3);
        }
        
        .card-icon i {
            color: white;
            font-size: 1.3rem;
        }
        
        .card-content h4 {
            color: var(--text-color);
            margin-bottom: 0.5rem;
            font-weight: 600;
        }
        
        .card-content p {
            color: #6c757d;
            margin: 0;
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
        
        @keyframes float {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-20px);
            }
        }
        
        /* Featured Promotions */
        .featured-section {
            padding: 3rem 0;
            background-color: #f8f9fa;
        }
        .section-title {
            font-family: var(--heading-font);
            color: var(--text-color);
            font-size: 2.2rem;
            text-align: center;
            margin-bottom: 2.5rem;
        }
        
        /* Promotion Hero Sections */
        .promotion-hero-section {
            position: relative;
            margin-bottom: 3rem;
        }
        
        .promotion-hero-container {
            position: relative;
            height: 350px;
            overflow: hidden;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        
        .promotion-hero-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            filter: brightness(0.8);
        }
        
        .promotion-hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: transparent;
            display: flex;
            align-items: center;
            color: white;
        }
        
        .promotion-hero-content {
            padding: 2rem 0;
        }
        
        .promotion-hero-title {
            font-family: var(--heading-font);
            font-size: 2.2rem;
            margin-bottom: 0.8rem;
            animation: fadeInLeft 1s ease-out;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.8);
        }
        
        .promotion-hero-description {
            font-size: 1rem;
            line-height: 1.6;
            margin-bottom: 1.25rem;
            opacity: 0.9;
            animation: fadeInLeft 1s ease-out 0.2s both;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.8);
        }
        
        .promotion-hero-features {
            margin-bottom: 2rem;
            animation: fadeInLeft 1s ease-out 0.4s both;
        }
        
        .promotion-hero-features li {
            display: flex;
            align-items: center;
            margin-bottom: 0.5rem;
            font-size: 1rem;
        }
        
        .promotion-hero-features li i {
            margin-right: 0.5rem;
            color: #ffd700;
        }
        
        .promotion-hero-visual {
            position: relative;
            height: 250px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .floating-promo-card {
            position: absolute;
            background: rgba(255,255,255,0.95);
            border-radius: 12px;
            padding: 1.25rem;
            box-shadow: 0 8px 25px rgba(0,0,0,0.2);
            backdrop-filter: blur(10px);
            animation: float 3s ease-in-out infinite;
            border: 2px solid rgba(255,255,255,0.3);
        }
        
        .floating-promo-card .card-icon {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: linear-gradient(135deg, #ff6b6b 0%, #ffa726 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 0.8rem;
            box-shadow: 0 4px 12px rgba(255,107,107,0.3);
        }
        
        .floating-promo-card .card-icon i {
            color: white;
            font-size: 1.1rem;
        }
        
        .floating-promo-card .card-content h4 {
            color: var(--text-color);
            margin-bottom: 0.5rem;
            font-weight: 600;
        }
        
        .floating-promo-card .card-content p {
            color: #6c757d;
            margin: 0;
        }
        .promotion-card {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            text-align: center;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            height: 100%;
            position: relative;
            overflow: hidden;
        }
        .promotion-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, #009688, #00796b);
        }
        .promotion-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }
        .promotion-icon {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.25rem;
            font-size: 1.8rem;
            color: white;
            position: relative;
        }
        .promotion-icon.discount {
            background: linear-gradient(135deg, #ff6b6b, #ee5a52);
        }
        .promotion-icon.shipping {
            background: linear-gradient(135deg, #4ecdc4, #44a08d);
        }
        .promotion-icon.combo {
            background: linear-gradient(135deg, #a8edea, #fed6e3);
            color: #333;
        }
        .promotion-title {
            color: var(--text-color);
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 0.8rem;
        }
        .promotion-description {
            color: #6c757d;
            margin-bottom: 1.25rem;
            line-height: 1.5;
        }
        .promotion-features {
            list-style: none;
            padding: 0;
            margin-bottom: 1.5rem;
        }
        .promotion-features li {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            margin-bottom: 0.5rem;
            color: #6c757d;
        }
        .promotion-features i {
            color: #28a745;
            font-size: 0.9rem;
        }
        .promotion-badge {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: #ff6b6b;
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        /* Ongoing Deals */
        .ongoing-section {
            padding: 3rem 0;
            background: white;
        }
        
        /* Deal Hero Sections */
        .deal-hero-section {
            position: relative;
            margin-bottom: 3rem;
        }
        
        .deal-hero-container {
            position: relative;
            height: 300px;
            overflow: hidden;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        
        .deal-hero-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            filter: brightness(0.8);
        }
        
        .deal-hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: transparent;
            display: flex;
            align-items: center;
            color: white;
        }
        
        .deal-hero-content {
            padding: 1.5rem 0;
        }
        
        .deal-badge {
            display: inline-block;
            background: rgba(255,255,255,0.2);
            color: white;
            padding: 0.5rem 1.5rem;
            border-radius: 25px;
            font-weight: 600;
            font-size: 0.9rem;
            margin-bottom: 1rem;
            animation: pulse 2s infinite;
        }
        
        .deal-hero-title {
            font-family: var(--heading-font);
            font-size: 1.8rem;
            margin-bottom: 0.6rem;
            animation: fadeInLeft 1s ease-out;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.8);
        }
        
        .deal-hero-description {
            font-size: 0.95rem;
            line-height: 1.5;
            margin-bottom: 0.8rem;
            opacity: 0.9;
            animation: fadeInLeft 1s ease-out 0.2s both;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.8);
        }
        
        .deal-hero-timer {
            background: rgba(255,255,255,0.2);
            padding: 1rem;
            border-radius: 15px;
            margin-bottom: 1.5rem;
            animation: fadeInLeft 1s ease-out 0.4s both;
        }
        
        .deal-hero-timer .timer-item {
            display: inline-block;
            margin: 0 0.5rem;
            text-align: center;
        }
        
        .deal-hero-timer .timer-number {
            font-size: 1.5rem;
            font-weight: 700;
            display: block;
            color: #ffd700;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }
        
        .deal-hero-timer .timer-label {
            font-size: 0.9rem;
            opacity: 0.9;
        }
        
        .deal-hero-visual {
            position: relative;
            height: 200px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .floating-deal-card {
            position: absolute;
            background: rgba(255,255,255,0.95);
            border-radius: 12px;
            padding: 0.8rem;
            box-shadow: 0 8px 25px rgba(0,0,0,0.2);
            backdrop-filter: blur(10px);
            animation: float 3s ease-in-out infinite;
            border: 2px solid rgba(255,255,255,0.3);
        }
        
        .floating-deal-card .card-icon {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 0.6rem;
            box-shadow: 0 4px 12px rgba(102,126,234,0.3);
        }
        
        .floating-deal-card .card-icon i {
            color: white;
            font-size: 1rem;
        }
        
        .floating-deal-card .card-content h4 {
            color: var(--text-color);
            margin-bottom: 0.5rem;
            font-weight: 600;
        }
        
        .floating-deal-card .card-content p {
            color: #6c757d;
            margin: 0;
        }
        
        @keyframes pulse {
            0% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
            100% {
                transform: scale(1);
            }
        }
        
        /* Special Offers - New Card Design */
        .special-section {
            padding: 3rem 0;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            position: relative;
            overflow: hidden;
        }
        
        .special-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/><circle cx="50" cy="10" r="0.5" fill="white" opacity="0.1"/><circle cx="10" cy="60" r="0.5" fill="white" opacity="0.1"/><circle cx="90" cy="40" r="0.5" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            pointer-events: none;
        }
        
        .special-header {
            position: relative;
            z-index: 2;
        }
        
        .special-badge {
            display: inline-block;
            background: rgba(255,255,255,0.2);
            color: white;
            padding: 0.8rem 2rem;
            border-radius: 30px;
            font-weight: 600;
            font-size: 1rem;
            margin-bottom: 1rem;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.3);
            animation: glow 2s ease-in-out infinite alternate;
        }
        
        .special-title {
            font-family: var(--heading-font);
            font-size: 2.5rem;
            margin-bottom: 0.8rem;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }
        
        .special-subtitle {
            font-size: 1.1rem;
            opacity: 0.9;
            max-width: 600px;
            margin: 0 auto;
        }
        
        .special-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
            margin-top: 2.5rem;
            position: relative;
            z-index: 2;
            align-items: stretch;
        }
        
        .special-card {
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(15px);
            border-radius: 20px;
            padding: 1.5rem;
            border: 1px solid rgba(255,255,255,0.2);
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
            height: 500px;
            display: flex;
            flex-direction: column;
        }
        
        .special-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
            transition: left 0.5s ease;
        }
        
        .special-card:hover::before {
            left: 100%;
        }
        
        .special-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
            border-color: rgba(255,255,255,0.4);
        }
        
        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }
        
        .card-icon-wrapper {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            color: white;
            position: relative;
        }
        
        .vip-card .card-icon-wrapper {
            background: linear-gradient(135deg, #ffd700 0%, #ff8c00 100%);
            box-shadow: 0 5px 15px rgba(255,215,0,0.3);
        }
        
        .birthday-card .card-icon-wrapper {
            background: linear-gradient(135deg, #ff69b4 0%, #ff1493 100%);
            box-shadow: 0 5px 15px rgba(255,105,180,0.3);
        }
        
        .group-card .card-icon-wrapper {
            background: linear-gradient(135deg, #00bfff 0%, #1e90ff 100%);
            box-shadow: 0 5px 15px rgba(0,191,255,0.3);
        }
        
        .early-card .card-icon-wrapper {
            background: linear-gradient(135deg, #32cd32 0%, #228b22 100%);
            box-shadow: 0 5px 15px rgba(50,205,50,0.3);
        }
        
        .card-badge {
            background: rgba(255,255,255,0.2);
            color: white;
            padding: 0.4rem 1rem;
            border-radius: 15px;
            font-weight: 600;
            font-size: 0.8rem;
            backdrop-filter: blur(10px);
        }
        
        .card-body {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        
        .card-title {
            font-family: var(--heading-font);
            font-size: 1.3rem;
            margin-bottom: 0.8rem;
            color: white;
            flex-shrink: 0;
        }
        
        .card-description {
            color: rgba(255,255,255,0.9);
            line-height: 1.5;
            margin-bottom: 1.25rem;
            min-height: 70px;
        }
        
        .card-benefits {
            margin-bottom: 1.5rem;
            min-height: 120px;
        }
        
        .benefit-item {
            display: flex;
            align-items: center;
            margin-bottom: 0.6rem;
            padding: 0.4rem;
            background: rgba(255,255,255,0.1);
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        
        .benefit-item:hover {
            background: rgba(255,255,255,0.2);
            transform: translateX(5px);
        }
        
        .benefit-item i {
            color: #ffd700;
            margin-right: 0.6rem;
            font-size: 0.9rem;
            width: 18px;
            text-align: center;
        }
        
        .benefit-item span {
            color: white;
            font-size: 0.85rem;
        }
        
        .card-footer {
            text-align: center;
            margin-top: auto;
        }
        
        .card-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: rgba(255,255,255,0.2);
            color: white;
            padding: 0.7rem 1.25rem;
            border-radius: 20px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.3);
            min-width: 130px;
            min-height: 40px;
        }
        
        .card-button:hover {
            background: rgba(255,255,255,0.3);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        
        .card-button i {
            margin-left: 0.5rem;
            transition: transform 0.3s ease;
        }
        
        .card-button:hover i {
            transform: translateX(3px);
        }
        
        @keyframes glow {
            from {
                box-shadow: 0 0 10px rgba(255,255,255,0.3);
            }
            to {
                box-shadow: 0 0 20px rgba(255,255,255,0.5);
            }
        }
        
                          /* Compact Promotion Cards Styles */
         .compact-card {
             background: white;
             border-radius: 15px;
             overflow: hidden;
             box-shadow: 0 8px 25px rgba(0,0,0,0.1);
             transition: all 0.3s ease;
             border: 2px solid transparent;
             height: 100%;
             display: flex;
             flex-direction: column;
         }
         
         .compact-card:hover {
             transform: translateY(-5px);
             box-shadow: 0 15px 35px rgba(0,0,0,0.15);
             border-color: var(--primary-color);
         }
         
         .card-image-container {
             position: relative;
             height: 200px;
             overflow: hidden;
         }
         
         .card-image {
             width: 100%;
             height: 100%;
             object-fit: cover;
             transition: transform 0.3s ease;
         }
         
         .compact-card:hover .card-image {
             transform: scale(1.05);
         }
         
         .status-badge {
             position: absolute;
             top: 1rem;
             right: 1rem;
             padding: 0.4rem 0.8rem;
             border-radius: 20px;
             font-size: 0.75rem;
             font-weight: 600;
             color: white;
             backdrop-filter: blur(10px);
         }
         
         .status-badge.active {
             background: rgba(40, 167, 69, 0.9);
         }
         
         .status-badge.inactive {
             background: rgba(108, 117, 125, 0.9);
         }
         
         .card-content {
             padding: 1.5rem;
             flex: 1;
             display: flex;
             flex-direction: column;
         }
         
         .compact-card .card-title {
             font-family: var(--heading-font);
             font-size: 1.2rem;
             margin-bottom: 0.8rem;
             color: var(--text-color);
             line-height: 1.3;
         }
         
         .compact-card .card-description {
             color: #6c757d;
             margin-bottom: 1rem;
             line-height: 1.5;
             font-size: 0.9rem;
             flex: 1;
         }
         
         .promotion-details {
             margin-bottom: 1.5rem;
         }
         
         .detail-item {
             display: flex;
             align-items: center;
             margin-bottom: 0.5rem;
             padding: 0.4rem 0;
             font-size: 0.85rem;
         }
         
         .detail-item i {
             margin-right: 0.5rem;
             width: 16px;
             text-align: center;
         }
         
         .detail-item span {
             color: #495057;
         }
         
         .card-action {
             margin-top: auto;
         }
         
         .card-action .btn {
             font-size: 0.9rem;
             padding: 0.6rem 1rem;
         }
         
         /* Database Promotion Cards Styles */
          .database-promotion-card {
              transition: all 0.3s ease;
              border: 2px solid transparent;
              height: 100%;
              display: flex;
              flex-direction: column;
          }
         
         .database-promotion-card .card-body {
             flex: 1;
             display: flex;
             flex-direction: column;
         }
         
         .database-promotion-card .card-footer {
             margin-top: auto;
         }
         
         /* Grid Layout for Database Promotions */
         .database-promotions-section .row {
             display: flex !important;
             flex-wrap: wrap !important;
         }
         
         .database-promotions-section .col-lg-4 {
             flex: 0 0 33.333333% !important;
             max-width: 33.333333% !important;
         }
         
         .database-promotions-section .col-md-6 {
             flex: 0 0 50% !important;
             max-width: 50% !important;
         }
         
         .database-promotions-section .col-12 {
             flex: 0 0 100% !important;
             max-width: 100% !important;
         }
         
         /* Force horizontal layout */
         .database-promotions-section .row > * {
             float: none !important;
         }
        
        .database-promotion-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.15);
            border-color: var(--primary-color);
        }
        
        .database-promotion-card .promotion-icon-small {
            transition: all 0.3s ease;
        }
        
        .database-promotion-card:hover .promotion-icon-small {
            transform: scale(1.1);
        }
        
        .database-promotion-card .detail-item {
            padding: 0.5rem;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        
        .database-promotion-card .detail-item:hover {
            background-color: #f8f9fa;
            transform: translateX(5px);
        }
        
        .inactive-overlay {
            backdrop-filter: blur(5px);
        }
        
        .promotion-status .badge {
            font-size: 0.8rem;
            padding: 0.5rem 0.75rem;
        }
        
        /* Animations */
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
        
                          @media (max-width: 768px) {
              /* Responsive grid adjustments for medium screens */
              .compact-card .card-title {
                  font-size: 1.1rem;
                  margin-bottom: 0.6rem;
              }
              
              .compact-card .card-description {
                  font-size: 0.85rem;
                  margin-bottom: 0.8rem;
              }
              
              .detail-item {
                  font-size: 0.8rem;
                  margin-bottom: 0.4rem;
              }
              
              .card-content {
                  padding: 1.25rem;
              }
              
              .database-promotions-section .col-lg-4 {
                  flex: 0 0 50% !important;
                  max-width: 50% !important;
              }
             
             .database-promotions-section .col-md-6 {
                 flex: 0 0 50% !important;
                 max-width: 50% !important;
             }
             
             .hero-section {
                 padding: 4rem 0;
             }
            .hero-title {
                font-size: 2.2rem;
                margin-bottom: 1rem;
            }
            .hero-subtitle {
                font-size: 1rem;
                margin-bottom: 1.5rem;
            }
            .hero-badge {
                padding: 0.6rem 1.25rem;
                font-size: 0.9rem;
            }
            .hero-image-container {
                height: 300px;
            }
            .hero-image-title {
                font-size: 2rem;
                margin-bottom: 1rem;
            }
            .hero-image-description {
                font-size: 0.9rem;
                margin-bottom: 1.25rem;
            }
            .hero-image-visual {
                height: 250px;
            }
            .floating-card {
                padding: 1.25rem;
            }
            .card-icon {
                width: 45px;
                height: 45px;
                margin-bottom: 0.6rem;
            }
            .card-icon i {
                font-size: 1.1rem;
            }
            .featured-section {
                padding: 2.5rem 0;
            }
            .section-title {
                font-size: 1.8rem;
                margin-bottom: 2rem;
            }
            .promotion-hero-section {
                margin-bottom: 2.5rem;
            }
            .promotion-hero-container {
                height: 280px;
            }
            .promotion-hero-title {
                font-size: 1.8rem;
                margin-bottom: 0.6rem;
            }
            .promotion-hero-description {
                font-size: 0.9rem;
                margin-bottom: 1rem;
            }
            .promotion-hero-visual {
                height: 200px;
            }
            .floating-promo-card {
                padding: 1rem;
            }
            .floating-promo-card .card-icon {
                width: 40px;
                height: 40px;
                margin-bottom: 0.6rem;
            }
            .floating-promo-card .card-icon i {
                font-size: 1rem;
            }
            .promotion-card {
                padding: 1.5rem;
            }
            .promotion-icon {
                width: 60px;
                height: 60px;
                margin-bottom: 1rem;
                font-size: 1.6rem;
            }
            .promotion-title {
                font-size: 1.2rem;
                margin-bottom: 0.6rem;
            }
            .promotion-description {
                margin-bottom: 1rem;
            }
            .promotion-features {
                margin-bottom: 1.25rem;
            }
            .ongoing-section {
                padding: 2.5rem 0;
            }
            .deal-hero-section {
                margin-bottom: 2.5rem;
            }
            .deal-hero-container {
                height: 250px;
            }
            .deal-hero-title {
                font-size: 1.6rem;
                margin-bottom: 0.5rem;
            }
            .deal-hero-description {
                font-size: 0.85rem;
                margin-bottom: 0.6rem;
            }
            .deal-hero-visual {
                height: 180px;
            }
            .floating-deal-card {
                padding: 0.6rem;
            }
            .floating-deal-card .card-icon {
                width: 30px;
                height: 30px;
                margin-bottom: 0.5rem;
            }
            .floating-deal-card .card-icon i {
                font-size: 0.9rem;
            }
            .special-section {
                padding: 2.5rem 0;
            }
            .special-title {
                font-size: 2rem;
                margin-bottom: 0.6rem;
            }
            .special-subtitle {
                font-size: 1rem;
            }
            .special-grid {
                grid-template-columns: 1fr;
                gap: 1.25rem;
                margin-top: 2rem;
            }
            .special-card {
                padding: 1.25rem;
                height: auto;
                min-height: 400px;
            }
            .card-icon-wrapper {
                width: 45px;
                height: 45px;
                font-size: 1.1rem;
            }
            .card-title {
                font-size: 1.2rem;
                margin-bottom: 0.6rem;
            }
            .card-description {
                margin-bottom: 1rem;
                min-height: 60px;
            }
            .card-benefits {
                margin-bottom: 1.25rem;
                min-height: 100px;
            }
            .benefit-item {
                margin-bottom: 0.5rem;
                padding: 0.3rem;
            }
            .benefit-item i {
                margin-right: 0.5rem;
                font-size: 0.8rem;
                width: 16px;
            }
            .benefit-item span {
                font-size: 0.8rem;
            }
            .card-button {
                padding: 0.6rem 1rem;
                min-width: 120px;
                min-height: 35px;
            }
        }
        
                          @media (max-width: 480px) {
              /* Responsive grid adjustments for small screens */
              .compact-card .card-title {
                  font-size: 1rem;
                  margin-bottom: 0.5rem;
              }
              
              .compact-card .card-description {
                  font-size: 0.8rem;
                  margin-bottom: 0.6rem;
              }
              
              .detail-item {
                  font-size: 0.75rem;
                  margin-bottom: 0.3rem;
              }
              
              .card-content {
                  padding: 1rem;
              }
              
              .card-image-container {
                  height: 180px;
              }
              
              .database-promotions-section .col-lg-4,
              .database-promotions-section .col-md-6 {
                  flex: 0 0 100% !important;
                  max-width: 100% !important;
              }
             
             .hero-section {
                 padding: 3rem 0;
             }
            .hero-title {
                font-size: 1.8rem;
                margin-bottom: 0.8rem;
            }
            .hero-subtitle {
                font-size: 0.9rem;
                margin-bottom: 1.25rem;
            }
            .hero-badge {
                padding: 0.5rem 1rem;
                font-size: 0.85rem;
            }
            .hero-image-container {
                height: 250px;
            }
            .hero-image-title {
                font-size: 1.6rem;
                margin-bottom: 0.8rem;
            }
            .hero-image-description {
                font-size: 0.85rem;
                margin-bottom: 1rem;
            }
            .hero-image-visual {
                height: 200px;
            }
            .floating-card {
                padding: 1rem;
            }
            .card-icon {
                width: 40px;
                height: 40px;
                margin-bottom: 0.5rem;
            }
            .card-icon i {
                font-size: 1rem;
            }
            .featured-section {
                padding: 2rem 0;
            }
            .section-title {
                font-size: 1.5rem;
                margin-bottom: 1.5rem;
            }
            .promotion-hero-section {
                margin-bottom: 2rem;
            }
            .promotion-hero-container {
                height: 220px;
            }
            .promotion-hero-title {
                font-size: 1.5rem;
                margin-bottom: 0.5rem;
            }
            .promotion-hero-description {
                font-size: 0.8rem;
                margin-bottom: 0.8rem;
            }
            .promotion-hero-visual {
                height: 150px;
            }
            .floating-promo-card {
                padding: 0.8rem;
            }
            .floating-promo-card .card-icon {
                width: 35px;
                height: 35px;
                margin-bottom: 0.5rem;
            }
            .floating-promo-card .card-icon i {
                font-size: 0.9rem;
            }
            .promotion-card {
                padding: 1.25rem;
            }
            .promotion-icon {
                width: 50px;
                height: 50px;
                margin-bottom: 0.8rem;
                font-size: 1.4rem;
            }
            .promotion-title {
                font-size: 1.1rem;
                margin-bottom: 0.5rem;
            }
            .promotion-description {
                margin-bottom: 0.8rem;
            }
            .promotion-features {
                margin-bottom: 1rem;
            }
            .ongoing-section {
                padding: 2rem 0;
            }
            .deal-hero-section {
                margin-bottom: 2rem;
            }
            .deal-hero-container {
                height: 200px;
            }
            .deal-hero-title {
                font-size: 1.4rem;
                margin-bottom: 0.4rem;
            }
            .deal-hero-description {
                font-size: 0.8rem;
                margin-bottom: 0.5rem;
            }
            .deal-hero-visual {
                height: 150px;
            }
            .floating-deal-card {
                padding: 0.5rem;
            }
            .floating-deal-card .card-icon {
                width: 25px;
                height: 25px;
                margin-bottom: 0.4rem;
            }
            .floating-deal-card .card-icon i {
                font-size: 0.8rem;
            }
            .special-section {
                padding: 2rem 0;
            }
            .special-title {
                font-size: 1.6rem;
                margin-bottom: 0.5rem;
            }
            .special-subtitle {
                font-size: 0.9rem;
            }
            .special-grid {
                gap: 1rem;
                margin-top: 1.5rem;
            }
            .special-card {
                padding: 1rem;
                min-height: 350px;
            }
            .card-icon-wrapper {
                width: 40px;
                height: 40px;
                font-size: 1rem;
            }
            .card-title {
                font-size: 1.1rem;
                margin-bottom: 0.5rem;
            }
            .card-description {
                margin-bottom: 0.8rem;
                min-height: 50px;
            }
            .card-benefits {
                margin-bottom: 1rem;
                min-height: 80px;
            }
            .benefit-item {
                margin-bottom: 0.4rem;
                padding: 0.25rem;
            }
            .benefit-item i {
                margin-right: 0.4rem;
                font-size: 0.75rem;
                width: 14px;
            }
            .benefit-item span {
                font-size: 0.75rem;
            }
            .card-button {
                padding: 0.5rem 0.8rem;
                min-width: 110px;
                min-height: 30px;
                font-size: 0.85rem;
            }
            
            .database-promotion-card {
                padding: 1rem;
            }
            
            .database-promotion-card .promotion-icon-small {
                width: 40px;
                height: 40px;
                font-size: 1rem;
            }
            
            .database-promotion-card .card-title {
                font-size: 1rem;
            }
            
                         .database-promotion-card .card-description {
                 min-height: 50px;
                 font-size: 0.85rem;
             }
             
             /* Responsive grid adjustments */
             .col-xl-3 {
                 flex: 0 0 25%;
                 max-width: 25%;
             }
             
             .col-lg-4 {
                 flex: 0 0 33.333333%;
                 max-width: 33.333333%;
             }
             
             .col-md-6 {
                 flex: 0 0 50%;
                 max-width: 50%;
             }
             
             .col-12 {
                 flex: 0 0 100%;
                 max-width: 100%;
             }
        }
        
        /* Footer Styles */
        .footer {
            background-color: var(--text-color);
            color: var(--secondary-color);
            padding: 2rem 0 1.5rem;
            margin-top: 3rem;
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
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <?php include __DIR__ . '/layouts/navbar.php'; ?>
    
    <!-- Debug Info (chỉ hiển thị khi cần) -->
    <?php if (isset($_GET['debug']) && $_GET['debug'] == '1'): ?>
    <div class="container mt-3">
        <div class="alert alert-info">
            <h6>Debug Information:</h6>
            <p><strong>Promotions count:</strong> <?php echo isset($promotions) ? count($promotions) : 'Not set'; ?></p>
            <p><strong>Le Quoc Khanh Promotion:</strong> <?php echo isset($leQuocKhanhPromotion) ? 'Found: ' . $leQuocKhanhPromotion['TenKM'] : 'Not found'; ?></p>
            <?php if (isset($promotions) && !empty($promotions)): ?>
            <p><strong>First promotion:</strong> <?php echo $promotions[0]['TenKM']; ?></p>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <h1 class="hero-title">Khuyến Mãi Đặc Biệt</h1>
            <p class="hero-subtitle">Tận hưởng những ưu đãi hấp dẫn và tiết kiệm chi phí khi mua sắm tại Parrot Smell</p>
            <div class="hero-badge">
                <i class="fas fa-gift me-2"></i>
                Ưu đãi lên đến 50%
            </div>
            
            
        </div>
    </section>

    <!-- Hero Image Section -->
    <section class="hero-image-section">
        <div class="hero-image-container">
            <img src="https://images.unsplash.com/photo-1565958011703-44f9829ba187?q=80&w=1965&auto=format&fit=crop" 
                 alt="Bánh mùa hè Parrot Smell" class="hero-image">
            <div class="hero-image-overlay">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-6">
                            <div class="hero-image-content">
                                <h2 class="hero-image-title">Mùa Hè Ngọt Ngào</h2>
                                <p class="hero-image-description">
                                    Khám phá bộ sưu tập bánh mùa hè độc đáo với hương vị tươi mới và thiết kế đẹp mắt. 
                                    Giảm giá đặc biệt cho các sản phẩm mùa hè.
                                </p>
                                <div class="hero-image-features">
                                    <div class="feature-item">
                                        <i class="fas fa-ice-cream"></i>
                                        <span>Hương vị tươi mới</span>
                                    </div>
                                    <div class="feature-item">
                                        <i class="fas fa-palette"></i>
                                        <span>Thiết kế độc đáo</span>
                                    </div>
                                    <div class="feature-item">
                                        <i class="fas fa-percentage"></i>
                                        <span>Giảm giá 30%</span>
                                    </div>
                                </div>
                                <a href="/websitePS/public/products/list" class="btn btn-primary-custom btn-lg">
                                    <i class="fas fa-ice-cream me-2"></i>
                                    Khám Phá Mùa Hè
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="hero-image-visual">
                                <div class="floating-card">
                                    <div class="card-icon">
                                        <i class="fas fa-sun"></i>
                                    </div>
                                    <div class="card-content">
                                        <h4>Mùa Hè</h4>
                                        <p>Bánh tươi mỗi ngày</p>
                                    </div>
                                </div>
                                <div class="floating-card">
                                    <div class="card-icon">
                                        <i class="fas fa-ice-cream"></i>
                                    </div>
                                    <div class="card-content">
                                        <h4>Hương Vị</h4>
                                        <p>Tươi mới & Độc đáo</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

                   <!-- Featured Promotions -->
      <section class="featured-section">
          <div class="container">
              <h2 class="section-title">Ưu Đãi Đang Diễn Ra</h2>
              
              <?php if (isset($promotions) && !empty($promotions)): ?>
                  <div class="row g-4">
                      <?php foreach ($promotions as $index => $promo): ?>
                          <?php 
                              // Kiểm tra xem khuyến mãi có đang hoạt động không
                              $today = date('Y-m-d');
                              $isActive = true;
                              if ($promo['NgayBatDau'] && $promo['NgayBatDau'] > $today) {
                                  $isActive = false;
                              }
                              if ($promo['NgayKetThuc'] && $promo['NgayKetThuc'] < $today) {
                                  $isActive = false;
                              }
                              
                              // Chỉ hiển thị 3 khuyến mãi đầu tiên
                              if ($index >= 3) break;
                          ?>
                          
                          <div class="col-lg-4 col-md-6">
                              <div class="promotion-card compact-card h-100">
                                  <div class="card-image-container">
                                      <img src="<?php 
                                          if (stripos($promo['TenKM'], 'LEQUOCKHANH') !== false || stripos($promo['TenKM'], 'lễ quốc khánh') !== false || stripos($promo['TenKM'], 'quoc khanh') !== false) {
                                              echo 'https://aquacityvn.vn/wp-content/uploads/2021/03/iui87.png';
                                          } elseif (stripos($promo['TenKM'], 'FREESHIP') !== false || stripos($promo['TenKM'], 'freeship') !== false || stripos($promo['TenKM'], 'miễn phí vận chuyển') !== false) {
                                              echo 'https://file.hstatic.net/200000472237/file/cong-cu-freeship_bd1f7bb8e87e4cf7bd20d42e6eccc170_grande.png';
                                          } else {
                                              echo 'https://images.unsplash.com/photo-1607083206968-13611e3d76db?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Mnx8ZGlzY291bnR8ZW58MHx8MHx8fDA%3D';
                                          }
                                      ?>" 
                                          alt="<?php echo htmlspecialchars($promo['TenKM']); ?>" class="card-image">
                                      <div class="status-badge <?php echo $isActive ? 'active' : 'inactive'; ?>">
                                          <?php echo $isActive ? 'ĐANG HOẠT ĐỘNG' : 'ĐÃ KẾT THÚC'; ?>
                                      </div>
                                  </div>
                                  
                                  <div class="card-content">
                                      <h3 class="card-title"><?php echo htmlspecialchars($promo['TenKM'] ? $promo['TenKM'] : 'Khuyến Mãi Đặc Biệt'); ?></h3>
                                      <p class="card-description">
                                          <?php echo htmlspecialchars($promo['MoTa'] ? $promo['MoTa'] : 'Khuyến mãi đặc biệt từ Parrot Smell'); ?>
                                      </p>
                                      
                                      <div class="promotion-details">
                                          <?php if ($promo['PhanTramGiamGia'] && $promo['PhanTramGiamGia'] > 0): ?>
                                          <div class="detail-item">
                                              <i class="fas fa-percentage text-danger"></i>
                                              <span>Giảm giá <?php echo $promo['PhanTramGiamGia']; ?>%</span>
                                          </div>
                                          <?php endif; ?>
                                          
                                          <?php if ($promo['SoTienGiamGia'] && $promo['SoTienGiamGia'] > 0): ?>
                                          <div class="detail-item">
                                              <i class="fas fa-money-bill-wave text-success"></i>
                                              <span>Giảm <?php echo number_format($promo['SoTienGiamGia'], 0, ',', '.'); ?>đ</span>
                                          </div>
                                          <?php endif; ?>
                                          
                                          <div class="detail-item">
                                              <i class="fas fa-calendar-alt text-info"></i>
                                              <span>Từ <?php echo $promo['NgayBatDau'] ? date('d/m/Y', strtotime($promo['NgayBatDau'])) : 'N/A'; ?> đến <?php echo $promo['NgayKetThuc'] ? date('d/m/Y', strtotime($promo['NgayKetThuc'])) : 'N/A'; ?></span>
                                          </div>
                                          
                                          <div class="detail-item">
                                              <i class="fas fa-tag text-warning"></i>
                                              <span>Mã: <strong><?php echo htmlspecialchars($promo['TenKM'] ? $promo['TenKM'] : 'N/A'); ?></strong></span>
                                          </div>
                                      </div>
                                      
                                      <?php if ($isActive): ?>
                                      <div class="card-action">
                                          <a href="/websitePS/public/products/list" class="btn btn-primary-custom w-100">
                                              <i class="fas fa-shopping-cart me-2"></i>
                                              Áp Dụng Ngay
                                          </a>
                                      </div>
                                      <?php else: ?>
                                      <div class="card-action">
                                          <div class="btn btn-secondary w-100" style="cursor: not-allowed; opacity: 0.6;">
                                              <i class="fas fa-clock me-2"></i>
                                              Đã Kết Thúc
                                          </div>
                                      </div>
                                      <?php endif; ?>
                                  </div>
                              </div>
                          </div>
                      <?php endforeach; ?>
                  </div>
              <?php else: ?>
                  <div class="text-center">
                      <div class="alert alert-info">
                          <i class="fas fa-info-circle me-2"></i>
                          Hiện tại chưa có khuyến mãi nào đang diễn ra. Vui lòng quay lại sau!
                      </div>
                  </div>
              <?php endif; ?>
          </div>
      </section>

    

    <!-- Special Offers -->
    <section class="special-section">
        <div class="container">
            <div class="special-header text-center mb-5">
                <div class="special-badge">✨ ƯU ĐÃI ĐẶC BIỆT ✨</div>
                <h2 class="special-title">Dành Riêng Cho Bạn</h2>
                <p class="special-subtitle">Những ưu đãi độc quyền chỉ có tại Parrot Smell</p>
            </div>
            
            <div class="special-grid">
                <!-- VIP Card -->
                <div class="special-card vip-card">
                    <div class="card-header">
                        <div class="card-icon-wrapper">
                            <i class="fas fa-crown"></i>
                        </div>
                        <div class="card-badge">VIP</div>
                    </div>
                    <div class="card-body">
                        <h3 class="card-title">Khách Hàng VIP</h3>
                        <p class="card-description">Tận hưởng những ưu đãi đặc biệt và dịch vụ chăm sóc khách hàng cao cấp</p>
                        <div class="card-benefits">
                            <div class="benefit-item">
                                <i class="fas fa-percentage"></i>
                                <span>Giảm thêm 10%</span>
                            </div>
                            <div class="benefit-item">
                                <i class="fas fa-gift"></i>
                                <span>Quà tặng hàng tháng</span>
                            </div>
                            <div class="benefit-item">
                                <i class="fas fa-star"></i>
                                <span>Ưu tiên đặt hàng</span>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a href="/websitePS/public/products/list" class="card-button">
                                <span>Trở Thành VIP</span>
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Birthday Card -->
                <div class="special-card birthday-card">
                    <div class="card-header">
                        <div class="card-icon-wrapper">
                            <i class="fas fa-birthday-cake"></i>
                        </div>
                        <div class="card-badge">SINH NHẬT</div>
                    </div>
                    <div class="card-body">
                        <h3 class="card-title">Sinh Nhật Đặc Biệt</h3>
                        <p class="card-description">Làm cho ngày đặc biệt của bạn thêm ngọt ngào với những chiếc bánh xinh xắn</p>
                        <div class="card-benefits">
                            <div class="benefit-item">
                                <i class="fas fa-birthday-cake"></i>
                                <span>Bánh cupcake miễn phí</span>
                            </div>
                            <div class="benefit-item">
                                <i class="fas fa-calendar"></i>
                                <span>Trong tháng sinh nhật</span>
                            </div>
                            <div class="benefit-item">
                                <i class="fas fa-gift"></i>
                                <span>Quà tặng đặc biệt</span>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a href="/websitePS/public/products/list" class="card-button">
                                <span>Đăng Ký Sinh Nhật</span>
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Group Card -->
                <div class="special-card group-card">
                    <div class="card-header">
                        <div class="card-icon-wrapper">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="card-badge">NHÓM</div>
                    </div>
                    <div class="card-body">
                        <h3 class="card-title">Đặt Theo Nhóm</h3>
                        <p class="card-description">Tổ chức tiệc tùng, sự kiện với chi phí tiết kiệm và chất lượng cao. Lý tưởng cho các buổi họp mặt</p>
                        <div class="card-benefits">
                            <div class="benefit-item">
                                <i class="fas fa-users"></i>
                                <span>Từ 5 người trở lên</span>
                            </div>
                            <div class="benefit-item">
                                <i class="fas fa-percentage"></i>
                                <span>Giảm 15% cho nhóm</span>
                            </div>
                            <div class="benefit-item">
                                <i class="fas fa-gift"></i>
                                <span>Tặng kèm quà cho nhóm</span>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a href="/websitePS/public/products/list" class="card-button">
                                <span>Đặt Nhóm Ngay</span>
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Early Bird Card -->
                <div class="special-card early-card">
                    <div class="card-header">
                        <div class="card-icon-wrapper">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="card-badge">SỚM</div>
                    </div>
                    <div class="card-body">
                        <h3 class="card-title">Đặt Sớm</h3>
                        <p class="card-description">Lên kế hoạch sớm để có được những chiếc bánh đẹp nhất với giá tốt nhất</p>
                        <div class="card-benefits">
                            <div class="benefit-item">
                                <i class="fas fa-clock"></i>
                                <span>Trước 3 ngày</span>
                            </div>
                            <div class="benefit-item">
                                <i class="fas fa-percentage"></i>
                                <span>Giảm 5%</span>
                            </div>
                            <div class="benefit-item">
                                <i class="fas fa-check-circle"></i>
                                <span>Đảm bảo chất lượng</span>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a href="/websitePS/public/products/list" class="card-button">
                                <span>Đặt Sớm Ngay</span>
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    

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
    
    <!-- Countdown Timer Script -->
    <script>
        // Set end dates for countdown timers
        const endDate1 = new Date();
        endDate1.setHours(endDate1.getHours() + 23); // 23 hours from now
        endDate1.setMinutes(endDate1.getMinutes() + 45); // 45 minutes
        endDate1.setSeconds(endDate1.getSeconds() + 32); // 32 seconds
        
        const endDate2 = new Date();
        endDate2.setDate(endDate2.getDate() + 15); // 15 days from now
        endDate2.setHours(endDate2.getHours() + 8); // 8 hours
        endDate2.setMinutes(endDate2.getMinutes() + 30); // 30 minutes
        
        // Countdown function for Deal 1 (Flash Sale)
        function updateCountdown1() {
            const now = new Date().getTime();
            const distance = endDate1.getTime() - now;
            
            if (distance < 0) {
                // Deal has ended
                document.getElementById('hours1').textContent = '00';
                document.getElementById('minutes1').textContent = '00';
                document.getElementById('seconds1').textContent = '00';
                return;
            }
            
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);
            
            document.getElementById('hours1').textContent = hours.toString().padStart(2, '0');
            document.getElementById('minutes1').textContent = minutes.toString().padStart(2, '0');
            document.getElementById('seconds1').textContent = seconds.toString().padStart(2, '0');
        }
        
        // Countdown function for Deal 2 (Birthday Special)
        function updateCountdown2() {
            const now = new Date().getTime();
            const distance = endDate2.getTime() - now;
            
            if (distance < 0) {
                // Deal has ended
                document.getElementById('days2').textContent = '00';
                document.getElementById('hours2').textContent = '00';
                document.getElementById('minutes2').textContent = '00';
                return;
            }
            
            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            
            document.getElementById('days2').textContent = days.toString().padStart(2, '0');
            document.getElementById('hours2').textContent = hours.toString().padStart(2, '0');
            document.getElementById('minutes2').textContent = minutes.toString().padStart(2, '0');
        }
        
        // Update countdowns every second
        setInterval(updateCountdown1, 1000);
        setInterval(updateCountdown2, 1000);
        
        // Initial update
        updateCountdown1();
        updateCountdown2();
        
        // Add pulse effect when time is running low
        function checkLowTime() {
            const hours1 = parseInt(document.getElementById('hours1').textContent);
            const minutes1 = parseInt(document.getElementById('minutes1').textContent);
            
            if (hours1 <= 1 && minutes1 <= 30) {
                document.querySelector('.deal-hero-timer').style.animation = 'pulse 1s infinite';
            }
        }
        
        setInterval(checkLowTime, 1000);
    </script>
</body>
</html>
