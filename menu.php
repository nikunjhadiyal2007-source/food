<?php
if (session_status() == PHP_SESSION_NONE) session_start();
include(__DIR__ . "/config/db.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Our Full Menu</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/style.css">
  <style>
    .food-card img {
      height: 250px;
      object-fit: cover;
    }

    .food-card .btn {
      width: 100%;
      margin-top: 10px;
    }

    .btn {
      background-color: #ff6b35;
      color: white;
      border: none;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
      opacity: 0.9;
      transition: var(--transition);
    }

    .btn:hover {
      background-color: var(--primary-light);
      border-color: var(--primary-light);
      color: white;
    }

    .btn:focus {
      box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }

    .food-card {
      transition: transform 0.3s ease;
    }

    .food-card:hover {
      transform: scale(1.05);
    }

    footer {
      background-color: #343a40;
      color: white;
      padding: 20px;
      position: relative;
      bottom: 0;
      width: 100%;
    }
  </style>
</head>

<body>
  <?php include("header.php"); ?>

  <div class="container mt-5 mb-3">
    <h2 class="container text-center mb-4">🍴 Explore Our Full Menu</h2>

    <?php
    $categories = $conn->query("SELECT * FROM menu_categories");

    while ($cat = $categories->fetch_assoc()) {
      echo "<h4 class='container mt-4 mb-2'>{$cat['name']}</h4><div class='row'>";

      $menu_items = $conn->query("SELECT * FROM menu_items WHERE category_id = {$cat['id']}");
      if ($menu_items->num_rows === 0) {
        echo "<div class='text-muted'>No items available in this category.</div>";
      }

      while ($item = $menu_items->fetch_assoc()) {
        // ✅ Corrected path: no hardcoded "assets/images/" — use directly
        $image = !empty($item['image']) ? $item['image'] : "assets/images/no-image.jpg";

        echo "
            <div class='col-md-4 mb-4'>
              <div class='card food-card shadow-sm'>
                <img src='{$image}' class='card-img-top' alt='Food Image'>
                <div class='card-body'>
                  <h5 class='card-title'>{$item['name']}</h5>
                  <p class='card-text'>{$item['description']}</p>
                  <strong>₹ {$item['price']}</strong>";
        if (isset($_SESSION['user_id'])) {
          echo "<a href='user/order_food.php' class='btn btn-sm mt-2 mb-2'>Order Now</a>";
        } else {
          echo "<a href='login.php' class='btn btn-sm mt-2 mb-2'>Login to Order</a>";
        }
        echo "
                </div>
              </div>
            </div>";
      }

      echo "</div>";
    }
    ?>
  </div>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
<?php
// Include footer
include("footer.php");
?>