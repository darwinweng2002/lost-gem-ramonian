<?php
// Include the database configuration file
include '../config.php';

// Debugging output


// Check if the user is logged in, if not then redirect to login page
if (!isset($_SESSION['user_id'])) {
    echo "Session not set, redirecting to login.<br>";
    header("Location: login.php");
    exit();
}

// Fetch the user's information from the database
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT first_name, last_name, course_year_section, email, college FROM user_member WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($first_name, $last_name, $course_year_section, $email, $college);
$stmt->fetch();
$stmt->close();

?>

<!DOCTYPE html>
<html lang="en">
<?php require_once('../inc/header.php'); ?>
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
      <section class="section profile min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-6 d-flex flex-column align-items-center justify-content-center">
              <div class="d-flex justify-content-center py-4">
                <a href="#" class="logo d-flex align-items-center w-auto">
                  <img src="<?= validate_image($_settings->info('logo')) ?>" alt="">
                  <span class="d-none d-lg-block text-center"><?= $_settings->info('name') ?></span>
                </a>
              </div><!-- End Logo -->
              <div class="card mb-3">
                <div class="card-body">
                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">User Dashboard</h5>
                    <p class="text-center small">Welcome, <?= htmlspecialchars($first_name . ' ' . $last_name) ?></p>
                  </div>

                  <div class="row">
                    <div class="col-12">
                      <label class="form-label">Full Name</label>
                      <p class="form-control"><?= htmlspecialchars($first_name . ' ' . $last_name) ?></p>
                    </div>
                     <div class="col-12">
                      <label class="form-label">College</label>
                      <p class="form-control"><?= htmlspecialchars($college) ?></p>
                    </div>
                    <div class="col-12">
                      <label class="form-label">Course, Year, and Section</label>
                      <p class="form-control"><?= htmlspecialchars($course_year_section) ?></p>
                    </div>
                    <div class="col-12">
                      <label class="form-label">Email</label>
                      <p class="form-control"><?= htmlspecialchars($email) ?></p>
                    </div>
                  </div>

                  <div class="text-center mt-4">
                    <a href="http://localhost/lostgemramonian/login.php" class="btn btn-primary">Logout</a>
                  </div>
                   <div class="text-center mt-4">
                    <a href="http://localhost/lostgemramonian/" class="btn btn-primary">Back</a>
                  </div>
                </div>
              </div>
              <footer>
                  <div class="container text-center py-4">
                    <!-- Copyright Section -->
                    <div class="copyright mb-2">
                      &copy; <strong><span>Ramonian LostGems</span></strong>. All Rights Reserved
                    </div>
                    <!-- Credits Section -->
                    <div class="credits">
                      <p>
                        <a href="http://localhost/lostgemramonian/register.php">prmsuramonianlostgems.com</a>
                      </p>
                    </div>
                    <!-- Logo Section -->
                    <div class="logo mb-2">
                      <a href="<?= base_url ?>">
                        <img style="height: 55px; width: 55px;" src="<?= validate_image($_settings->info('logo')) ?>" alt="System Logo">
                      </a>
                    </div>
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
  <script src="<?= base_url ?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="<?= base_url ?>assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="<?= base_url ?>assets/js/main.js"></script>
</body>
</html>