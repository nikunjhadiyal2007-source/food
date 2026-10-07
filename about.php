<?php
if (session_status() == PHP_SESSION_NONE) session_start();
include(__DIR__ . "/config/db.php");
include("header.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>About Us - LDCE FoodHub</title>

  <!-- Bootstrap CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">   

  <!-- Custom CSS -->
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/about.css">
</head>
<body>


<!-- Hero Section -->
<div class="about-hero">
  <h1>About LDCE FoodHub</h1>
</div>

<!-- About Content -->
<div class="container mt-5">
  <h2 class="mb-3 text-center ">Who We Are</h2>
  <p class="lead text-center">
    At LDCE FoodHub, we believe food is more than just fuel – it's a celebration of life. Our journey started with a passion for flavors, warmth, and hospitality.
  </p>

  <div class="row mt-4">
    <div class="col-md-6">
      <h4>🍛 Our Mission</h4>
      <p>To serve delicious, affordable meals made with love and fresh ingredients. We aim to create a cozy space where every customer feels at home.</p>
    </div>
    <div class="col-md-6">
      <h4>👨‍🍳 Our Story</h4>
      <p>From a small family-run eatery to a beloved neighborhood favorite, LDCE FoodHub has grown with the love of our community. Every dish has a story, and we're excited to share it with you.</p>
    </div>
  </div>

  <div class="mt-5 text-center">
    <?php if (isset($_SESSION['user_id'])): ?>
      <a href="<?php echo BASE_URL; ?>user/order_food.php" class="btn btn-primary btn-lg me-3">Order Food</a>
      <a href="<?php echo BASE_URL; ?>user/reserve_table.php" class="btn btn-warning btn-lg">Reserve a Table</a>
    <?php else: ?>
      <a href="login.php" class="btn btn-success btn-lg">Login to Order or Reserve</a>
    <?php endif; ?>
  </div>
</div>

<!-- Footer -->
<footer class="bg-dark text-white text-center p-3 mt-5">
  &copy; <?= date("Y") ?> LDCE FoodHub. All rights reserved.
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
