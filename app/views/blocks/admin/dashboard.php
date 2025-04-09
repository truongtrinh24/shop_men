<?php $range = $_GET['range'] ?? 'month'; ?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
    }
    .sidebar {
      background-color: #ffffff;
      border-radius: 10px;
      padding: 20px;
      box-shadow: 0 0 8px rgba(0, 0, 0, 0.05);
      height: 100%;
    }
    .sidebar h5 {
      border-bottom: 2px solid #dee2e6;
      padding-bottom: 10px;
      margin-bottom: 20px;
    }
    .sidebar a {
      font-weight: 500;
      transition: all 0.2s ease-in-out;
    }
    .sidebar a:hover {
      padding-left: 10px;
      color: #0d6efd !important;
    }
    .sidebar a.text-danger:hover {
      color: #dc3545 !important;
    }
    .footer {
      text-align: center;
      font-size: 14px;
      padding: 15px;
      color: #6c757d;
    }
    .admin-avatar {
      display: flex;
      align-items: center;
      gap: 10px;
    }
    .admin-avatar img {
      width: 40px;
      height: 40px;
      object-fit: cover;
      border-radius: 50%;
    }
  </style>
</head>
<body>
<div class="container-fluid mt-4">
  <div class="row">

    <!-- Sidebar -->
    <div class="col-md-3">
      <div class="sidebar">
        <h5>📊 Quản lý</h5>
        <ul class="list-unstyled">
          <li class="mb-3">
            <a href="/admin/products" class="text-decoration-none d-flex align-items-center">
              🛍️ <span class="ms-2">Sản phẩm</span>
            </a>
          </li>
          <li class="mb-3">
            <a href="/admin/orders" class="text-decoration-none d-flex align-items-center">
              📦 <span class="ms-2">Đơn hàng</span>
            </a>
          </li>
          <li class="mb-3">
            <a href="/admin/users" class="text-decoration-none d-flex align-items-center">
              👤 <span class="ms-2">Tài khoản</span>
            </a>
          </li>
          <li class="mb-3">
            <a href="/logoutCtl/logout" class="text-decoration-none d-flex align-items-center text-danger">
              🚪 <span class="ms-2">Đăng xuất</span>
            </a>
          </li>
        </ul>
      </div>
    </div>

    <!-- Main Content -->
    <div class="col-md-9">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="border-bottom pb-2 mb-0">👑 Quản Trị Hệ Thống</h2>
        <div class="admin-avatar">
          <img src="https://i.pinimg.com/736x/25/7f/0d/257f0d17d450827a53d264b953335d1b.jpg" alt="avatar">
          <span class="fw-bold">xin chào Admin!</span>
        </div>
      </div>

      <!-- Quick Stats -->
      <div class="row g-3 mb-4">
        <?php
          $cards = [
            ['icon' => '🛍️', 'label' => 'Sản phẩm', 'value' => $stats['total_products'] ?? 0, 'suffix' => 'sản phẩm', 'color' => 'primary'],
            ['icon' => '📦', 'label' => 'Đơn hàng', 'value' => $stats['total_orders'] ?? 0, 'suffix' => 'đơn hàng', 'color' => 'info'],
            ['icon' => '👤', 'label' => 'Khách hàng', 'value' => $stats['total_customers'] ?? 0, 'suffix' => 'người dùng', 'color' => 'warning'],
            ['icon' => '💰', 'label' => 'Doanh thu', 'value' => number_format($stats['total_revenue'] ?? 0), 'suffix' => 'đ', 'color' => 'success'],
          ];
        ?>
        <?php foreach ($cards as $card): ?>
        <div class="col-md-6 col-xl-3">
          <div class="card shadow-sm border-0">
            <div class="card-body d-flex align-items-center">
              <div class="me-3 fs-1 text-<?= $card['color'] ?>"><?= $card['icon'] ?></div>
              <div>
                <div class="fw-bold text-muted"><?= $card['label'] ?></div>
                <div class="fs-4"><?= $card['value'] ?> <?= $card['suffix'] ?></div>
              </div>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>

      <!-- Filter -->
      <form method="get" class="mb-3 d-flex align-items-center gap-2">
        <label for="range" class="fw-semibold">📅 Xem theo:</label>
        <select name="range" onchange="this.form.submit()" class="form-select w-auto">
          <option value="month" <?= $range === 'month' ? 'selected' : '' ?>>Theo tháng</option>
          <option value="quarter" <?= $range === 'quarter' ? 'selected' : '' ?>>Theo quý</option>
          <option value="year" <?= $range === 'year' ? 'selected' : '' ?>>Theo năm</option>
        </select>
      </form>

      <!-- Chart -->
      <hr>
      <h4>📈 Doanh thu 12 tháng gần nhất</h4>
      <canvas id="revenueChart" height="120"></canvas>
    </div>
  </div>

  <!-- Footer -->
  <div class="footer mt-5">
    © <?= date('Y') ?> Dashboard Admin | Built with ❤️ by A Vũ đẹp trai
  </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('revenueChart').getContext('2d');
const bgColors = ['#198754', '#0d6efd', '#ffc107', '#dc3545', '#20c997', '#6610f2', '#6c757d', '#fd7e14', '#e83e8c', '#0dcaf0', '#198754', '#212529'];

new Chart(ctx, {
  type: 'bar',
  data: {
    labels: <?= json_encode(array_column($monthlyRevenue, 'month')) ?>,
    datasets: [{
      label: 'Doanh thu (VNĐ)',
      data: <?= json_encode(array_map('intval', array_column($monthlyRevenue, 'revenue'))) ?>,
      backgroundColor: bgColors.slice(0, <?= count($monthlyRevenue) ?>),
      borderRadius: 10
    }]
  },
  options: {
    responsive: true,
    plugins: {
      tooltip: {
        callbacks: {
          label: ctx => ctx.dataset.label + ': ' + ctx.parsed.y.toLocaleString('vi-VN') + ' đ'
        }
      },
      legend: { display: true }
    },
    scales: {
      y: {
        beginAtZero: true,
        ticks: {
          callback: value => value.toLocaleString('vi-VN') + ' đ'
        }
      }
    },
    animation: {
      duration: 1000,
      easing: 'easeOutBounce'
    }
  },
  plugins: [{
    id: 'labelPlugin',
    afterDatasetsDraw(chart) {
      const {ctx, data} = chart;
      ctx.save();
      chart.getDatasetMeta(0).data.forEach((bar, i) => {
        const value = data.datasets[0].data[i];
        ctx.fillStyle = 'black';
        ctx.font = 'bold 14px sans-serif';
        ctx.textAlign = 'center';
        ctx.fillText(value.toLocaleString('vi-VN') + ' đ', bar.x, bar.y - 10);
      });
    }
  }]
});
</script>
</body>
</html>
