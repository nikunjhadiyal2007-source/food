<?php
if (session_status() == PHP_SESSION_NONE) session_start();
include(__DIR__ . "/config/db.php");

$user_id = $_SESSION['user_id'] ?? null;
$role = $_SESSION['role'] ?? null;

// Fetch pending & unread notification count for badge
$notif_count = 0;
if ($user_id) {
  $stmt = $conn->prepare("SELECT COUNT(*) as count FROM notifications WHERE user_id = ? AND status = 'pending' AND is_read = 0");
  $stmt->bind_param("i", $user_id);
  $stmt->execute();
  $result = $stmt->get_result()->fetch_assoc();
  $notif_count = $result['count'] ?? 0;
}
?>
<link rel="stylesheet" href="<?php echo BASE_URL;?>assets/css/header.css">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="<?php echo BASE_URL;?>">
      <img src="<?php echo BASE_URL;?>assets/images/logo.png" alt="Logo" class="nav-logo">
      LDCE <span>FoodHub</span>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbar">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <?php if (isset($_SESSION['user_id'])): ?>
          <?php if ($role === 'admin'): ?>
            <!-- ADMIN NAVIGATION -->
            <li class="nav-item">
              <a class="nav-link" href="<?php echo BASE_URL;?>admin/dashboard.php">Dashboard</a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="manageDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Manage
              </a>
              <ul class="dropdown-menu" aria-labelledby="manageDropdown">
                <li><a class="dropdown-item" href="<?php echo BASE_URL;?>admin/manage_menu.php">Menu Items</a></li>
                <li><a class="dropdown-item" href="<?php echo BASE_URL;?>admin/manage_categories.php">Categories</a></li>
                <li><a class="dropdown-item" href="<?php echo BASE_URL;?>admin/manage_reservations.php">Reservations</a></li>
                <li><a class="dropdown-item" href="<?php echo BASE_URL;?>admin/users.php">Users</a></li>
              </ul>
            </li>
            <li class="nav-item">
              <a class="nav-link notifications-link" href="<?php echo BASE_URL;?>admin/notifications.php">
                Notifications
                <?php if ($notif_count > 0): ?>
                  <span class="badge bg-danger"><?= $notif_count ?></span>
                <?php endif; ?>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link logout-btn" href="<?php echo BASE_URL;?>logout.php" onclick="return confirm('Are you sure you want to logout?')">Logout</a>
            </li>
          
          <?php elseif ($role === 'user'): ?>
            <!-- USER NAVIGATION -->
            <li class="nav-item">
              <a class="nav-link" href="<?php echo BASE_URL;?>user/analytics.php">Dashboard</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo BASE_URL;?>menu.php">Menu Items</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo BASE_URL;?>user/order_food.php">Order Food</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo BASE_URL;?>user/reserve_table.php">Reserve Table</a>
            </li>
            <li class="nav-item">
              <a class="nav-link notifications-link" href="<?php echo BASE_URL;?>user/notifications.php">
                Notifications
                <?php if ($notif_count > 0): ?>
                  <span class="badge bg-danger"><?= $notif_count ?></span>
                <?php endif; ?>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link cart-link" href="<?php echo BASE_URL;?>user/cart.php">
                <i class="fas fa-shopping-cart"></i> Cart
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link logout-btn" href="<?php echo BASE_URL;?>logout.php" onclick="return confirm('Are you sure you want to logout?')">Logout</a>
            </li>
          <?php endif; ?>

        <?php else: ?>
          <!-- PUBLIC NAVIGATION (NOT LOGGED IN) -->
          <li class="nav-item">
            <a class="nav-link" href="<?php echo BASE_URL;?>index.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo BASE_URL;?>about.php">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo BASE_URL;?>menu.php">Menu</a>
          </li>
          <li class="nav-item">
            <a class="nav-link login-btn" href="<?php echo BASE_URL;?>login.php">Login</a>
          </li>
          <li class="nav-item">
            <a class="nav-link register-btn" href="<?php echo BASE_URL;?>register.php">Register</a>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>

<!-- Font Awesome CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">