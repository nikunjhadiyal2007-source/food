<?php
if (session_status() == PHP_SESSION_NONE) session_start();
include(__DIR__ . "/config/db.php");

// Handle login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? LIMIT 1");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            $_SESSION["user_id"] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION["name"] = $user['name'];
            $_SESSION["role"] = $user['role'];

            if ($user['role'] === 'admin') {
                header("Location: admin/dashboard.php");
            } else {
                header("Location: user/dashboard.php");
            }
            exit;
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "User not found.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login - LDCE FoodHub</title>

  <!-- Bootstrap CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  
  <!-- Font Awesome for icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  
  <!-- Your Custom CSS -->
  <link rel="stylesheet" href="assets/css/login.css">
  <link rel="stylesheet" href="assets/css/header.css">
  
</head>
<body>

<!-- Navbar -->
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
        <a href="login.php" class="btn btn-success me-2">Login</a>
        <a href="register.php" class="btn">Register</a>
      <?php endif; ?>
    </div>
  </div>
</nav>

<!-- Login Form Section -->
<div class="login-wrapper">
  <div class="container d-flex justify-content-center">
    <div class="row w-100 justify-content-center">
      <div class="col-md-8 col-lg-6 col-xl-5">
        <div class="login-container mx-auto">
          <div class="brand-container text-center">
            <div class="logo-animation mb-2">
              <img src="assets/images/logo.png" alt="Logo" height="70" style="filter:invert(0%);">
            </div>
            <div class="brand-text">LDCE <span>FoodHub</span></div>
          </div>
          
          <div class="login-header">
            <h3>Welcome Back</h3>
            <p class="text-muted">Sign in to access your account</p>
          </div>
          
          <?php if (isset($error)): ?>
            <div class='alert alert-danger'>
              <i class="fas fa-exclamation-circle me-2"></i><?= $error ?>
            </div>
          <?php endif; ?>
          
          <form method="POST" class="login-form">
            <div class="input-with-icon mb-3">
              <span class="input-icon">
                <i class="fas fa-user"></i>
              </span>
              <input type="text" name="username" class="form-control" placeholder="Username" required>
            </div>
            
            <div class="input-with-icon mb-4">
              <span class="input-icon">
                <i class="fas fa-lock"></i>
              </span>
              <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>
            
            <div class="form-check mb-4">
              <input class="form-check-input" type="checkbox" id="rememberMe">
              <label class="form-check-label text-muted" for="rememberMe">
                Remember me
              </label>
              <a href="#" class="float-end text-decoration-none" style="color: var(--primary);">Forgot password?</a>
            </div>
            
            <button class="btn btn-primary w-100 btn-login">
              <i class="fas fa-sign-in-alt me-2"></i> Login
            </button>
          </form>
          
          <div class="social-login">
            <p>Or login with</p>
            <div class="social-icons">
              <a href="#" class="facebook"><i class="fab fa-facebook-f"></i></a>
              <a href="#" class="google"><i class="fab fa-google"></i></a>
              <a href="#" class="twitter"><i class="fab fa-twitter"></i></a>
            </div>
          </div>
          
          <div class="login-footer">
            <p>Don't have an account? <a href="register.php">Register</a></p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Footer -->
<footer class="bg-dark text-white text-center p-3">
  &copy; <?= date("Y") ?> LDCE FoodHub. All rights reserved.
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  // Add animation effects when the page loads
  document.addEventListener('DOMContentLoaded', function() {
    // Form fields entrance animations with delay
    const formFields = document.querySelectorAll('.login-form .form-control .btn-login');
    formFields.forEach((field, index) => {
      field.style.opacity = '0';
      field.style.transform = 'translateY(20px)';
      field.style.transition = 'all 0.5s ease';
      field.style.transitionDelay = `${0.2 + (index * 0.1)}s`;
      
      setTimeout(() => {
        field.style.opacity = '1';
        field.style.transform = 'translateY(0)';
      }, 100);
    });
    
    // Focus effect on first input field
    setTimeout(() => {
      document.querySelector('.login-form .form-control').focus();
    }, 800);
  });
</script>
</body>
</html>