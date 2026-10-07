<?php
if (session_status() == PHP_SESSION_NONE) session_start();
include(__DIR__ . "/config/db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = $_POST["name"];
  $email = $_POST["email"];
  $username = $_POST["username"];
  $password = $_POST["password"];
  $confirm_password = $_POST["confirm_password"];

  // Password validation
  $uppercase = preg_match('@[A-Z]@', $password);
  $lowercase = preg_match('@[a-z]@', $password);
  $number    = preg_match('@[0-9]@', $password);
  $specialChars = preg_match('@[^\w]@', $password);

  if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
    $error = "Password should be at least 8 characters in length and should include at least one uppercase letter, one lowercase letter, one number, and one special character.";
  } else if ($password != $confirm_password) {
    $error = "Password and Confirm Password do not match.";
  } else {
    $password_hash = password_hash($password, PASSWORD_BCRYPT);
    $role = "user"; // Default role is user

    // Check if username already exists
    $check_username = $conn->prepare("SELECT * FROM users WHERE username = ? LIMIT 1");
    $check_username->bind_param("s", $username);
    $check_username->execute();
    $result_username = $check_username->get_result();

    // Check if email already exists
    $check_email = $conn->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
    $check_email->bind_param("s", $email);
    $check_email->execute();
    $result_email = $check_email->get_result();

    if ($result_username->num_rows > 0) {
      $error = "Username already exists. Please choose a different username.";
    } else if ($result_email->num_rows > 0) {
      $error = "Email already exists. Please use a different email address.";
    } else {
      $stmt = $conn->prepare("INSERT INTO users (name, email, username, password, role) VALUES (?, ?, ?, ?, ?)");
      $stmt->bind_param("sssss", $name, $email, $username, $password_hash, $role);

      if ($stmt->execute()) {
        $_SESSION["user_id"] = $stmt->insert_id;
        $_SESSION["name"] = $name;
        $_SESSION["role"] = $role;
        $_SESSION["username"] = $username;

        header("Location: user/dashboard.php");
        exit;
      } else {
        $error = "Registration failed. Please try again later.";
      }
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Register - LDCE FoodHub</title>

  <!-- Bootstrap CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Font Awesome for icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

  <!-- Your Custom CSS -->
  <link rel="stylesheet" href="assets/css/register.css">
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
          <a href="login.php" class="btn me-2">Login</a>
          <a href="register.php" class="btn btn-success">Register</a>
        <?php endif; ?>
      </div>
    </div>
  </nav>

  <!-- Register Form Section -->
  <div class="register-wrapper">
    <div class="container d-flex justify-content-center">
      <div class="row w-100 justify-content-center">
        <div class="col-md-8 col-lg-6 col-xl-5">
          <div class="register-container mx-auto">
            <div class="brand-container text-center">
              <div class="logo-animation mb-2">
                <img src="assets/images/logo.png" alt="Logo" height="70" style="filter:invert(0%);">
              </div>
              <div class="brand-text">LDCE <span>FoodHub</span></div>
            </div>

            <div class="register-header">
              <h3>Create an Account</h3>
              <p class="text-muted">Join us for a delightful culinary experience</p>
            </div>

            <?php if (isset($error)): ?>
              <div class='alert alert-danger'>
                <i class="fas fa-exclamation-circle me-2"></i><?= $error ?>
              </div>
            <?php endif; ?>

            <form method="POST" class="register-form">
              <div class="input-with-icon mb-3">
                <span class="input-icon">
                  <i class="fas fa-user"></i>
                </span>
                <input type="text" name="name" class="form-control" placeholder="Full Name" required value="<?= isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '' ?>">
              </div>

              <div class="input-with-icon mb-3">
                <span class="input-icon">
                  <i class="fas fa-envelope"></i>
                </span>
                <input type="email" name="email" class="form-control" placeholder="Email Address" required value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>">
              </div>

              <div class="input-with-icon mb-3">
                <span class="input-icon">
                  <i class="fas fa-at"></i>
                </span>
                <input type="text" name="username" class="form-control" placeholder="Username" required value="<?= isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '' ?>">
              </div>

              <div class="input-with-icon mb-4">
              <span class="input-icon">
                <i class="fas fa-lock"></i>
              </span>
                <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
                <div class="password-strength" id="passwordStrength"></div>
              </div>
              <div class="password-message" id="passwordMessage">
                  Password must contain at least 8 characters, including uppercase, lowercase, numbers and special characters
              </div>
              

              <div class="input-with-icon mb-4">
                <span class="input-icon">
                  <i class="fas fa-check-circle"></i>
                </span>
                <input type="password" name="confirm_password" id="confirmPassword" class="form-control" placeholder="Confirm Password" required>
                <div class="password-message" id="confirmMessage"></div>
              </div>

              <div class="buttons-container">
                <button onclick="window.location.href='index.php'" class="btn btn-home">
                  <i class="fas fa-home me-2"></i> Back
                </button>

                <button type="submit" class="btn btn-register" id="registerBtn">
                  <i class="fas fa-user-plus me-2"></i> Register
                </button>
              </div>
            </form>


          </div>

          <div class="register-footer">
            <p>Already have an account? <a href="login.php">Login here</a></p>
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
      const formFields = document.querySelectorAll('.register-form .form-control .btn-home .btn-register');
      formFields.forEach((field, index) => {
        field.style.opacity = '0';
        field.style.transform = 'translateY(20px)';
        field.style.transition = 'all 0.5s ease';
        field.style.transitionDelay = ${0.2 + (index * 0.1)}s;

        setTimeout(() => {
          field.style.opacity = '1';
          field.style.transform = 'translateY(0)';
        }, 100);
      });

      // Focus effect on first input field
      setTimeout(() => {
        document.querySelector('.register-form .form-control').focus();
      }, 800);

      // Password strength checker
      const passwordInput = document.getElementById('password');
      const confirmInput = document.getElementById('confirmPassword');
      const passwordStrength = document.getElementById('passwordStrength');
      const passwordMessage = document.getElementById('passwordMessage');
      const confirmMessage = document.getElementById('confirmMessage');
      const registerBtn = document.getElementById('registerBtn');

      passwordInput.addEventListener('input', function() {
        const password = passwordInput.value;
        let strength = 0;

        // Update password strength indicator
        if (password.length >= 8) strength += 1;
        if (password.match(/[A-Z]/)) strength += 1;
        if (password.match(/[a-z]/)) strength += 1;
        if (password.match(/[0-9]/)) strength += 1;
        if (password.match(/[^A-Za-z0-9]/)) strength += 1;

        passwordStrength.className = 'password-strength';

        if (password.length === 0) {
          passwordStrength.style.display = 'none';
          passwordMessage.innerHTML = 'Password must contain at least 8 characters, including uppercase, lowercase, numbers and special characters';
        } else {
          passwordStrength.style.display = 'block';

          if (strength < 2) {
            passwordStrength.classList.add('weak');
            passwordMessage.innerHTML = 'Password is too weak';
            passwordMessage.style.color = '#dc3545';
          } else if (strength < 4) {
            passwordStrength.classList.add('medium');
            passwordMessage.innerHTML = 'Password is medium strength';
            passwordMessage.style.color = '#ffc107';
          } else if (strength < 5) {
            passwordStrength.classList.add('strong');
            passwordMessage.innerHTML = 'Password is strong';
            passwordMessage.style.color = '#0dcaf0';
          } else {
            passwordStrength.classList.add('very-strong');
            passwordMessage.innerHTML = 'Password is very strong';
            passwordMessage.style.color = '#198754';
          }
        }

        // Check if passwords match when both fields have input
        if (confirmInput.value) {
          if (passwordInput.value === confirmInput.value) {
            confirmMessage.innerHTML = 'Passwords match';
            confirmMessage.style.color = '#198754';
          } else {
            confirmMessage.innerHTML = 'Passwords do not match';
            confirmMessage.style.color = '#dc3545';
          }
        }
      });

      confirmInput.addEventListener('input', function() {
        if (passwordInput.value === confirmInput.value) {
          confirmMessage.innerHTML = 'Passwords match';
          confirmMessage.style.color = '#198754';
        } else {
          confirmMessage.innerHTML = 'Passwords do not match';
          confirmMessage.style.color = '#dc3545';
        }
      });
    });
  </script>
</body>

</html>