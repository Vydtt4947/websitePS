<?php
// Dashboard content partial: wrapped by app/views/admin/layouts/admin_layout.php
?>
<header class="d-flex justify-content-between align-items-center mb-4">
  <h1 class="h2 mb-0">Bảng điều khiển</h1>
  <div class="d-flex align-items-center">
    <span class="me-3">Chào, <?= htmlspecialchars($_SESSION['HoTen'] ?? 'User') ?>!</span>
    <img src="https://i.pravatar.cc/40?img=1" alt="Avatar" class="rounded-circle">
  </div>
</header>

<div class="row g-4 mb-4">
  <div class="col-md-6 col-lg-3">
    <div class="card stat-card border-primary shadow-sm h-100">
      <div class="card-body">
        <h6 class="text-primary mb-1">DOANH THU HÔM NAY</h6>
        <div class="fs-3 fw-bold"><?= number_format($todaysRevenue ?? 0, 0, ',', '.') ?> đ</div>
      </div>
    </div>
  </div>
  <div class="col-md-6 col-lg-3">
    <div class="card stat-card border-success shadow-sm h-100">
      <div class="card-body">
        <h6 class="text-success mb-1">ĐƠN HÀNG MỚI (Hôm nay)</h6>
        <div class="fs-3 fw-bold"><?= (int)($todaysOrders ?? 0) ?></div>
      </div>
    </div>
  </div>
  <div class="col-md-6 col-lg-3">
    <div class="card stat-card border-info shadow-sm h-100">
      <div class="card-body">
        <h6 class="text-info mb-1">KHÁCH HÀNG MỚI (Tháng)</h6>
        <div class="fs-3 fw-bold"><?= (int)($newCustomers ?? 0) ?></div>
      </div>
    </div>
  </div>
  <div class="col-md-6 col-lg-3">
    <div class="card stat-card border-secondary shadow-sm h-100">
      <div class="card-body">
        <h6 class="text-secondary mb-1">TỔNG SẢN PHẨM</h6>
        <div class="fs-3 fw-bold"><?= (int)($totalProducts ?? 0) ?></div>
      </div>
    </div>
  </div>
</div>

<div class="row g-4">
  <div class="col-lg-7">
    <div class="card shadow-sm h-100">
      <div class="card-header"><strong>Doanh thu 7 ngày gần nhất</strong></div>
      <div class="card-body" style="height:360px;">
        <canvas id="revenueChart" aria-label="Biểu đồ doanh thu"></canvas>
      </div>
    </div>
  </div>
  <div class="col-lg-5">
    <div class="card shadow-sm h-100">
      <div class="card-header"><strong>Đơn hàng gần đây</strong></div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0">
            <tbody>
            <?php if (empty($recentOrders)): ?>
              <tr>
                <td colspan="6" class="text-center">Không có đơn hàng nào gần đây.</td>
              </tr>
            <?php else: foreach ($recentOrders as $order): ?>
              <tr>
                <td>
                  <strong>#<?= htmlspecialchars($order['MaDH']) ?></strong><br>
                  <small><?= htmlspecialchars($order['HoTen']) ?></small>
                </td>
                <td class="text-end">
                  <?= number_format($order['TongTien'], 0, ',', '.') ?> đ<br>
                  <?php
                    $statusText = '';
                    switch ($order['TenTrangThai']) {
                      case 'Pending':    $statusText = 'Chờ xử lý'; break;
                      case 'Processing': $statusText = 'Đang xử lý'; break;
                      case 'Shipping':   $statusText = 'Đang giao hàng'; break;
                      case 'Delivered':  $statusText = 'Đã giao hàng'; break;
                      case 'Cancelled':  $statusText = 'Đã hủy'; break;
                      default:           $statusText = $order['TenTrangThai'];
                    }
                  ?>
                  <small class="badge bg-light text-dark"><?= htmlspecialchars($statusText) ?></small>
                </td>
              </tr>
            <?php endforeach; endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Only dashboard needs Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  (function(){
    const el = document.getElementById('revenueChart');
    if (!el) return;
    const ctx = el.getContext('2d');
    new Chart(ctx, {
      type: 'bar',
      data: {
        labels: <?= json_encode($chartLabels ?? []) ?>,
        datasets: [{
          label: 'Doanh thu (đ)',
          data: <?= json_encode($chartData ?? []) ?>,
          backgroundColor: 'rgba(0, 150, 136, 0.6)',
          borderColor: 'rgba(0, 150, 136, 1)',
          borderWidth: 1,
          borderRadius: 5
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: { y: { beginAtZero: true,
          ticks: { callback: (v) => v >= 1_000_000 ? (v/1_000_000)+'tr' : (v>=1_000 ? (v/1_000)+'k' : v) } } },
        plugins: { legend: { display: false } }
      }
    });
  })();
</script>