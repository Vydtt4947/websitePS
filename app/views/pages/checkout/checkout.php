<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh toán - Parrot Smell</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container my-5">
    <div class="py-5 text-center">
        <h2>Thanh toán</h2>
        <p class="lead">Vui lòng điền thông tin bên dưới để hoàn tất đơn hàng của bạn.</p>
    </div>
    <div class="row g-5">
        <div class="col-md-5 col-lg-4 order-md-last">
            <h4 class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-primary">Đơn hàng của bạn</span>
                <span class="badge bg-primary rounded-pill"><?= count($cart) ?></span>
            </h4>
            <ul class="list-group mb-3">
                <?php $total = 0; ?>
                <?php foreach ($cart as $item): ?>
                    <?php $subtotal = $item['price'] * $item['quantity']; $total += $subtotal; ?>
                    <li class="list-group-item d-flex justify-content-between lh-sm">
                        <div>
                            <h6 class="my-0"><?= htmlspecialchars($item['name']) ?></h6>
                            <small class="text-muted">Số lượng: <?= $item['quantity'] ?></small>
                        </div>
                        <span class="text-muted"><?= number_format($subtotal, 0, ',', '.') ?> đ</span>
                    </li>
                <?php endforeach; ?>
                <li class="list-group-item d-flex justify-content-between">
                    <span>Tổng cộng (VNĐ)</span>
                    <strong><?= number_format($total, 0, ',', '.') ?> đ</strong>
                </li>
            </ul>
        </div>
        <div class="col-md-7 col-lg-8">
            <h4 class="mb-3">Thông tin giao hàng</h4>
            <form action="/websitePS/public/checkout/placeOrder" method="POST">
                <div class="row g-3">
                    <div class="col-12">
                        <label for="fullname" class="form-label">Họ và Tên</label>
                        <input type="text" class="form-control" id="fullname" name="fullname" required>
                    </div>
                    <div class="col-12">
                        <label for="phone" class="form-label">Số điện thoại</label>
                        <input type="tel" class="form-control" id="phone" name="phone" required>
                    </div>
                    <div class="col-12">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="you@example.com" required>
                    </div>
                    <div class="col-12">
                        <label for="address" class="form-label">Địa chỉ nhận hàng</label>
                        <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
                    </div>
                </div>
                <hr class="my-4">
                <button class="w-100 btn btn-primary btn-lg" type="submit">Hoàn tất Đơn hàng</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>