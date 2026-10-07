<?php
if (session_status() == PHP_SESSION_NONE) session_start();
include(__DIR__ . "/config/db.php");
include('chatbot.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>LDCE FoodHub</title>

  <!-- ✅ Bootstrap CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  

  <!-- ✅ Your Custom CSS -->
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/chatbot.css">
  <link rel="stylesheet" href="assets/css/header.css">
  <link rel="stylesheet" href="assets/css/footer.css">

  <!-- ✅ Local styling -->
  <style>
 

    .food-card img {
      height: 300px;
      object-fit: cover;
    }
    .food-card .card-body {
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }
    .food-card .btn {
      width: 100%;
      margin-top: 10px;
    }

    .scrolling-wrapper {
      position: relative;
      height: 300px;
    }

    .image-track {
      animation: scroll-left 100s linear infinite;
      display: flex;
    }

    .menu-thumb {
      height: 300px;
      width: auto;
      border: 3px solid #fff;
      transition: transform 0.8s;
    }

    .menu-thumb:hover {
      transform: scale(1.05);
    }

    @keyframes scroll-left {
      0% { transform: translateX(0%); }
      100% { transform: translateX(-50%); }
    }

    /* 🎯 Restaurant Gallery Styles */
    .restaurant-gallery {
      width: 100%;
      overflow: hidden;
      position: relative;
    }

    #galleryTrack {
      display: flex;
      transition: transform 0.4s ease;
    }

    .gallery-item {
      flex: 0 0 33.3333%;
      max-width: 33.3333%;
      padding-right: 16px;
    }

    .gallery-img {
      width: 100%;
      height: 200px;
      object-fit: cover;
      border: 3px solid #fff;
      transition: transform 0.3s;
    }

    .gallery-img:hover {
      transform: scale(1.03);
    }

    .gallery-btn {
      position: absolute;
      top: 50%;
      transform: translateY(-50%);
      background: rgba(0, 0, 0, 0.5);
      color: white;
      border: none;
      font-size: 28px;
      padding: 8px 12px;
      cursor: pointer;
      z-index: 10;
      border-radius: 50%;
    }

    .gallery-btn.left {
      left: 0;
    }

    .gallery-btn.right {
      right: 0;
    }
  </style>
</head>
<body>

<!-- ✅ Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="#"><img src="assets/images/logo.png" alt="Logo" style="filter:invert(100%);height:40px;object-position: center;"> LDCE <span class="navbar-brand-span">FoodHub</span></a>
    <div>
      <?php if (isset($_SESSION['user_id'])): ?>
        <a href="user/dashboard.php" class="btn btn-success me-2">Dashboard</a>
        <a href="logout.php" class="btn btn-outline-light">Logout</a>
      <?php else: ?>
        <a href="index.php" class="btn me-2">Home</a>
        <a href="about.php" class="btn me-2">About</a>
        <a href="menu.php" class="btn me-2">Menu</a>
        <a href="login.php" class="btn me-2">Login</a>
        <a href="register.php" class="btn">Register</a>
      <?php endif; ?>
    </div>
  </div>
</nav>

<!-- ✅ Welcome Section -->
<div class="welcome-section d-flex flex-column align-items-center justify-content-center text-center py-5">
  <h2 class="fw-bold mb-3">Welcome to LDCE FoodHub</h2>
  <p class="lead mb-4 px-3" style="max-width: 1000px;">
    Experience the best dining experience with us. Our restaurant offers a wide range of delicious dishes, from traditional favorites to innovative creations. Our staff is dedicated to providing you with excellent service and a warm, welcoming atmosphere.
  </p>
  <div class="d-flex gap-3 mt-3 flex-wrap justify-content-center">
    <?php if (isset($_SESSION['user_id'])): ?>
      <a href="user/reserve_table.php" class="btn btn-outline-warning btn-lg">Reserve a Table</a>
    <?php else: ?>
      <a href="login.php" class="btn btn-outline-warning btn-lg">Login to Reserve</a>
      <a href="login.php" class="btn btn-success btn-lg">Order Now</a>
    <?php endif; ?>
  </div>
</div>


<!-- ✅ Menu Running Images -->
<div class="container-fluid mt-5 py-4 bg-light">
  <h2 class="text-center mb-4">A Glimpse of Our Menu</h2>
  <div class="scrolling-wrapper d-flex align-items-center overflow-hidden">
    <div class="image-track d-flex">
      <?php for ($i = 1; $i <= 20; $i++): ?>
        <div class="mx-2">
          <img src="assets/images/menu/menu<?= $i ?>.jpeg" class="menu-thumb rounded shadow" alt="Dish <?= $i ?>">
        </div>
      <?php endfor; ?>
    </div>
  </div>
</div>

<!-- ✅ Restaurant Gallery Section (Only 3 images visible) -->
<div class="container mt-5">
  <h2 class="text-center text-secondary mb-4">A Peek Inside Our Restaurant</h2>
  <div class="position-relative">
    <!-- Arrows -->
    <button class="gallery-btn left" onclick="scrollGallery(-1)">&#10094;</button>
    <button class="gallery-btn right" onclick="scrollGallery(1)">&#10095;</button>

    <!-- Gallery -->
    <div class="restaurant-gallery" id="galleryWrapper">
      <div id="galleryTrack">
        <?php for ($i = 1; $i <= 10; $i++): ?>
          <div class="gallery-item">
            <img src="assets/images/restaurant <?= $i ?>.jpg" class="gallery-img rounded shadow" alt="Restaurant <?= $i ?>">
          </div>
        <?php endfor; ?>
      </div>
    </div>
  </div>
</div>

<!-- ✅ Our Menu Highlights -->
<div class="container mt-5">
  <h2 class="text-center mb-4">Our Menu Highlights</h2>
  <div class="row">
    <?php
    $items = $conn->query("SELECT * FROM menu_items ORDER BY RAND() LIMIT 6");
    while ($item = $items->fetch_assoc()):
      $image = (!empty($item['image']) && file_exists($item['image'])) ? $item['image'] : "assets/images/no-image.jpg";
    ?>
      <div class='col-md-4 mb-4'>
        <div class='card food-card shadow-sm'>
          <img src='<?= $image ?>' class='card-img-top' alt='Food Image'>
          <div class='card-body'>
            <h5 class='card-title'><?= htmlspecialchars($item['name']) ?></h5>
            <p class='card-text'><?= htmlspecialchars($item['description']) ?></p>
            <strong>₹ <?= $item['price'] ?></strong><br>
            <?php if (isset($_SESSION['user_id'])): ?>
              <a href='user/order_food.php' class='btn btn-primary btn-sm mt-2'>Add</a>
            <?php else: ?>
              <a href='login.php' class='btn btn-warning btn-sm mt-2'>Add</a>
            <?php endif; ?>
          </div>
        </div>
      </div>
    <?php endwhile; ?>
  </div>

  <div class="menu-button text-center mt-4">
    <?php if (isset($_SESSION['user_id'])): ?>
      <a href='user/order_food.php' class='btn btn-success'>View Full Menu</a>
    <?php else: ?>
      <a href='login.php' class="btn btn-success">Login to View Full Menu</a>
    <?php endif; ?>
  </div>
</div>


<!-- ❤️ Customer Reviews -->
<div class="reviews-section mt-5">
  <h2 class="mb-4 fw-bold text-center">What Our Customers Say</h2>
  <div class="row">
    <div class="col-md-4">
      <blockquote class="blockquote bg-light p-3 rounded shadow-sm">"Absolutely loved the pasta!"<footer class="blockquote-footer bg-white text-black mt-2">Riya M.</footer></blockquote>
    </div>
    <div class="col-md-4">
      <blockquote class="blockquote bg-light p-3 rounded shadow-sm">"Fast service and delicious food!"<footer class="blockquote-footer bg-white  text-black mt-2">Amit K.</footer></blockquote>
    </div>
    <div class="col-md-4">
      <blockquote class="blockquote bg-light p-3 rounded shadow-sm">"We celebrated our anniversary here!"<footer class="blockquote-footer bg-white  text-black mt-2">Neha & Raj</footer></blockquote>
    </div>
  </div>
</div>

<!-- 📱 Final CTA -->
<div class="cta-section text-center">
  <h2 class="fw-bold mb-3">Ready to Taste the Best?</h2>
  <p>Reserve your table now or order online — your favorite dish is just a click away!</p>
  <div class="d-flex justify-content-center gap-3 mt-3">
    <a href="<?= isset($_SESSION['user_id']) ? 'user/order_food.php' : 'login.php'; ?>" class="btn btn-success btn-lg">Order Now</a>
  </div>
</div>

<!-- ✅ JS for Gallery Scroll -->
<script>
  let scrollIndex = 0;

  function scrollGallery(direction) {
    const track = document.getElementById('galleryTrack');
    const item = track.querySelector('.gallery-item');
    const itemWidth = item.offsetWidth + 16;
    const visible = 3;
    const total = track.children.length;
    const maxIndex = total - visible;

    scrollIndex += direction;
    if (scrollIndex < 0) scrollIndex = 0;
    if (scrollIndex > maxIndex) scrollIndex = maxIndex;

    track.style.transform = `translateX(-${scrollIndex * itemWidth}px)`;
  }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php include("footer.php"); ?>
