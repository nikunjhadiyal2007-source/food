<?php
// Include the database connection file
if (session_status() == PHP_SESSION_NONE) session_start();
include(__DIR__ . "/config/db.php");
?>
<!DOCTYPE html>
<body>
<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/footer.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<footer class="footer">
  <div class="container">
    <div class="footer-content">
      <!-- Restaurant Info Section -->
      <div class="footer-section">
        <div class="footer-logo">
          <h3><img src="<?php echo BASE_URL;?>assets/images/logo.png" alt="Logo" style="filter:invert(100%);height:30px;"> LDCE <span>FoodHub</span></h3>
        </div>
        <div class="footer-about">
          <p>Experience the perfect blend of taste, ambiance, and service at your favorite local spot.</p>
        </div>
        <div class="contact-info">
          <div><i class="fas fa-map-marker-alt"></i> 123 Restaurant St, City</div>
          <div><i class="fas fa-phone"></i> +91 1234567890</div>
          <div><i class="fas fa-envelope"></i> ldcefoodhub@example.com</div>
        </div>
      </div>

      <!-- Quick Links Section -->
      <div class="footer-section">
        <h4>Quick Links</h4>
        <ul class="footer-links">
          <li><a href="<?php echo BASE_URL; ?>index.php">Home</a></li>
          <li><a href="<?php echo BASE_URL; ?>about.php">About Us</a></li>
          <li><a href="<?php echo BASE_URL; ?>menu.php">Menu</a></li>
          <li><a href="<?php echo BASE_URL; ?>user/reserve_table.php">Reservations</a></li>
          <li><a href="<?php echo BASE_URL; ?>about.php">Contact</a></li>
        </ul>
      </div>

      <!-- Opening Hours Section -->
      <div class="footer-section">
        <h4>Opening Hours</h4>
        <ul class="open-hours">
          <li><span class="day">Monday - Friday</span> <span class="time">9:00 AM - 10:00 PM</span></li>
          <li><span class="day">Saturday</span> <span class="time">10:00 AM - 11:00 PM</span></li>
          <li><span class="day">Sunday</span> <span class="time">10:00 AM - 9:00 PM</span></li>
        </ul>
      </div>

      <!-- Newsletter Section -->
      <div class="footer-section">
        <h4>Newsletter</h4>
        <p>Subscribe to get special offers and updates.</p>
        <div class="newsletter">
          <form>
            <input type="email" placeholder="Your Email Address">
            <button type="submit">Subscribe</button>
          </form>
        </div>
        <div class="social-icons">
          <a href="#"><i class="fab fa-facebook-f"></i></a>
          <a href="#"><i class="fab fa-twitter"></i></a>
          <a href="#"><i class="fab fa-instagram"></i></a>
          <a href="#"><i class="fab fa-pinterest"></i></a>
        </div>
      </div>
    </div>

    <!-- Footer Bottom -->
    <div class="footer-bottom">
      <p>&copy; <?= date("Y") ?> LDCE FoodHub. All rights reserved.</p>

    </div>
  </div>

  <!-- Back to Top Button -->
  <div class="back-to-top">
    <i class="fas fa-chevron-up"></i>
  </div>
</footer>

<!-- Add this script for back-to-top functionality -->
<script>
  // Back to top button
  window.addEventListener('scroll', function() {
    var backToTop = document.querySelector('.back-to-top');
    if (window.pageYOffset > 300) {
      backToTop.classList.add('active');
    } else {
      backToTop.classList.remove('active');
    }
  });

  document.querySelector('.back-to-top').addEventListener('click', function(e) {
    e.preventDefault();
    window.scrollTo({top: 0, behavior: 'smooth'});
  });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
