<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Parrot Smell CRM</title>
  <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="/assets/css/style.css">
  <style>
    body {
      background-color: #f8f9fa;
    }
    .navbar-brand img {
      height: 40px;
    }
    .card-icon {
      font-size: 2.5rem;
      opacity: 0.3;
    }
  </style>
</head>
<body>

  <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">
        <img src="/assets/images/logo.jpg" alt="Parrot Smell Logo">
        Parrot Smell CRM
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#"><i class="fas fa-tachometer-alt"></i> Bảng điều khiển</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#"><i class="fas fa-shopping-cart"></i> Đơn hàng</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#"><i class="fas fa-box-open"></i> Sản phẩm</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#"><i class="fas fa-users"></i> Khách hàng</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#"><i class="fas fa-chart-bar"></i> Báo cáo</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="fas fa-user-circle"></i> Tài khoản
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
              <li><a class="dropdown-item" href="#">Thông tin cá nhân</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="#">Đăng xuất</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <main class="container mt-4">
    <h1 class="mb-4">Bảng điều khiển</h1>

    <div class="row">
      <div class="col-md-3 mb-4">
        <div class="card text-white bg-primary shadow">
          <div class="card-body d-flex justify-content-between align-items-center">
            <div>
              <h5 class="card-title">12</h5>
              <p class="card-text">Đơn hàng mới</p>
            </div>
            <i class="fas fa-shopping-cart card-icon"></i>
          </div>
        </div>
      </div>
      <div class="col-md-3 mb-4">
        <div class="card text-white bg-success shadow">
          <div class="card-body d-flex justify-content-between align-items-center">
            <div>
              <h5 class="card-title">8,500,000₫</h5>
              <p class="card-text">Doanh thu tháng</p>
            </div>
            <i class="fas fa-dollar-sign card-icon"></i>
          </div>
        </div>
      </div>
      <div class="col-md-3 mb-4">
        <div class="card text-white bg-info shadow">
          <div class="card-body d-flex justify-content-between align-items-center">
            <div>
              <h5 class="card-title">5</h5>
              <p class="card-text">Khách hàng mới</p>
            </div>
            <i class="fas fa-users card-icon"></i>
          </div>
        </div>
      </div>
      <div class="col-md-3 mb-4">
        <div class="card text-white bg-warning shadow">
          <div class="card-body d-flex justify-content-between align-items-center">
            <div>
              <h5 class="card-title">3</h5>
              <p class="card-text">Phản hồi chờ xử lý</p>
            </div>
            <i class="fas fa-comments card-icon"></i>
          </div>
        </div>
      </div>
    </div>

    <div class="card shadow">
      <div class="card-header">
        <h5 class="mb-0">Đơn hàng gần đây</h5>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-hover">
            <thead>
              <tr>
                <th scope="col">Mã ĐH</th>
                <th scope="col">Khách hàng</th>
                <th scope="col">Ngày đặt</th>
                <th scope="col">Tổng tiền</th>
                <th scope="col">Trạng thái</th>
                <th scope="col">Hành động</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th scope="row">1025</th>
                <td>Nguyễn Văn A</td>
                <td>29/07/2025</td>
                <td>550,000₫</td>
                <td><span class="badge bg-success">Đã giao</span></td>
                <td><a href="#" class="btn btn-sm btn-info">Xem</a></td>
              </tr>
              <tr>
                <th scope="row">1026</th>
                <td>Trần Thị B</td>
                <td>30/07/2025</td>
                <td>1,200,000₫</td>
                <td><span class="badge bg-primary">Đang giao</span></td>
                <td><a href="#" class="btn btn-sm btn-info">Xem</a></td>
              </tr>
              <tr>
                <th scope="row">1027</th>
                <td>Lê Văn C</td>
                <td>30/07/2025</td>
                <td>320,000₫</td>
                <td><span class="badge bg-warning text-dark">Chờ xử lý</span></td>
                <td><a href="#" class="btn btn-sm btn-info">Xem</a></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </main>

  <footer class="bg-dark text-white text-center p-3 mt-5">
    <div class="container">
      &copy; 2025 Parrot Smell. All Rights Reserved.
    </div>
  </footer>

  <script src="/assets/js/jquery.min.js"></script>
  <script src="/assets/js/bootstrap.bundle.min.js"></script>
  <script src="/assets/js/main.js"></script>
</body>
</html>