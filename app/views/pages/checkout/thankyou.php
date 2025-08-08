<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt hàng thành công - Parrot Smell</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container text-center my-5">
    <div class="py-5">
        <h1 class="display-4 text-success">Đặt hàng thành công!</h1>
        <p class="lead">Cảm ơn bạn đã mua sắm tại Parrot Smell Bakery.</p>
        <p>Mã đơn hàng của bạn là: <strong>#<?= htmlspecialchars($orderId) ?></strong></p>
        <p>Chúng tôi sẽ liên hệ với bạn để xác nhận đơn hàng trong thời gian sớm nhất.</p>
        <hr>
        <a href="/websitePS/public/" class="btn btn-primary btn-lg">Quay về trang chủ</a>
    </div>
</div>
</body>
</html>