<?php  
// Include the database configuration file
include 'config.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $course_year_section = $_POST['course_year_section'];
    $college = $_POST['college']; // Add this line
    $verified = isset($_POST['verified']) ? 1 : 0;
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Prepare and execute query
    $stmt = $conn->prepare("INSERT INTO user_member (first_name, last_name, course_year_section, college, verified, email, password) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssiss", $first_name, $last_name, $course_year_section, $college, $verified, $email, $password);
    if ($stmt->execute()) {
        echo "Registration successful!";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="en">
<?php require_once('inc/header.php'); ?>
<body>
  <style>
    body {
      background-size: cover;
      background-repeat: no-repeat;
      backdrop-filter: brightness(.7);
      overflow-x: hidden;
    }
    .logo img {
      max-height: 55px;
      margin-right: 25px;
    }
    .logo span {
      color: #fff;
      text-shadow: 0px 0px 10px #000;
    }
  </style>
  <main>
    <div class="container">
      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
              <div class="d-flex justify-content-center py-4">
                <a href="user_login.php" class="logo d-flex align-items-center w-auto">
                  <img src="<?= validate_image($_settings->info('logo')) ?>" alt="">
                  <span class="d-none d-lg-block text-center"><?= $_settings->info('name') ?></span>
                </a>
              </div><!-- End Logo -->
              <div class="card mb-3">
                <div class="card-body">
                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">User Registration</h5>
                    <p class="text-center small">Fill in the form to create an account</p>
                  </div>
                  <form class="row g-3 needs-validation" novalidate method="POST" action="register_process.php">
                    <div class="col-12">
                      <label for="firstName" class="form-label">First Name</label>
                      <input type="text" name="first_name" class="form-control" id="firstName" required>
                      <div class="invalid-feedback">Please enter your first name.</div>
                    </div>
                    <div class="col-12">
                      <label for="lastName" class="form-label">Last Name</label>
                      <input type="text" name="last_name" class="form-control" id="lastName" required>
                      <div class="invalid-feedback">Please enter your last name.</div>
                    </div>
                    <div class="col-12">
                    <label for="college" class="form-label">College</label>
                    <select name="college" class="form-control" id="college" required>
                      <option value="" disabled selected>Select your college</option>
                      <option value="CABA">CABA</option>
                      <option value="CTHM">CTHM</option>
                      <option value="CTE">CTE</option>
                      <option value="CAS">CAS</option>
                      <option value="CIT">CIT</option>
                      <option value="CON">CON</option>
                      <option value="CCIT">CCIT</option>
                      <option value="COE">COE</option>
                    </select>
                    <div class="invalid-feedback">Please select your college.</div>
                  </div>
                    <div class="col-12">
                      <label for="course" class="form-label">Course, Year, and Section</label>
                      <input type="text" name="course_year_section" class="form-control" id="course" required>
                      <div class="invalid-feedback">Please enter your course, year, and section.</div>
                    </div>
                    <div class="col-12">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="verified" id="verified" required>
                        <label class="form-check-label" for="verified">Verified Student in PRMSU IBA Main Campus</label>
                        <div class="invalid-feedback">You must verify your student status.</div>
                      </div>
                    </div>
                    <div class="col-12">
                      <label for="email" class="form-label">Email</label>
                      <input type="email" name="email" class="form-control" id="email" required>
                      <div class="invalid-feedback">Please enter a valid email address.</div>
                    </div>
                    <div class="col-12">
                      <label for="password" class="form-label">Password</label>
                      <input type="password" name="password" class="form-control" id="password" required>
                      <div class="invalid-feedback">Please enter your password.</div>
                    </div>
                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit">Register</button>
                    </div>
                  </form>
                  <div class="text-center mt-3">
                    <p>Already have an account? <a href="http://localhost/lostgemramonian/login.php/">Login here</a></p>
                  </div>
                </div>
              </div>
              <footer>
                <div class="copyright">
                  &copy; Copyright <strong><span>Ramonian LostGems</span></strong>. All Rights Reserved
                </div>
                <div class="credits">
                  <p style="text-align: center;">Developed by BSINFOTECH 3-C <a href="http://localhost/lostgemramonian/login.php">prmsuramonianlostgems.com</a></p>
                  <a href="<?= base_url ?>">
                    <center><img style="height: 55px; width: 55px;" src="<?= validate_image($_settings->info('logo')) ?>" alt="System Logo"></center>
                  </a>
                </div>
              </footer>
            </div>
          </div>
        </div>
      </section>
    </div>
  </main>
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
  <script src="<?= base_url ?>assets/js/jquery-3.6.4.min.js"></script>
  <script src="<?= base_url ?>assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="<?= base_url ?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="<?= base_url ?>assets/vendor/chart.js/chart.umd.js"></script>
  <script src="<?= base_url ?>assets/vendor/echarts/echarts.min.js"></script>
  <script src="<?= base_url ?>assets/vendor/quill/quill.min.js"></script>
  <script src="<?= base_url ?>assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="<?= base_url ?>assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="<?= base_url ?>assets/vendor/php-email-form/validate.js"></script>
  <script src="<?= base_url ?>assets/js/main.js"></script>
  <script>
    $(document).ready(function() {
      end_loader();
    });
  </script>
</body>
</html>
