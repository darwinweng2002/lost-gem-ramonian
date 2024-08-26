<?php
// Include the database configuration file
include '../config.php';

// Check if the user is logged in, if not then redirect to login page
if (!isset($_SESSION['user_id'])) {
    echo "Session not set, redirecting to login.<br>";
    header("Location: login.php");
    exit();
}

// Fetch the user's information from the database
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT first_name, last_name, course, year, section, email, college FROM user_member WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($first_name, $last_name, $course, $year, $section, $email, $college);
$stmt->fetch();
$stmt->close();

// Fetch the user's claim history
$claim_stmt = $conn->prepare("SELECT item_name, claim_date FROM claims WHERE user_id = ?");
$claim_stmt->bind_param("i", $user_id);
$claim_stmt->execute();
$claim_stmt->bind_result($item_name, $claim_date);
$claims = [];
while ($claim_stmt->fetch()) {
    $claims[] = ['item_name' => $item_name, 'claim_date' => $claim_date];
}
$claim_stmt->close();

// Fetch the user's posted items history
$post_stmt = $conn->prepare("SELECT item_name, post_date FROM posts WHERE user_id = ?");
$post_stmt->bind_param("i", $user_id);
$post_stmt->execute();
$post_stmt->bind_result($item_name, $post_date);
$posts = [];
while ($post_stmt->fetch()) {
    $posts[] = ['item_name' => $item_name, 'post_date' => $post_date];
}
$post_stmt->close();

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
    .claim-history-table,
    .post-history-table {
      margin-top: 20px;
      background-color: #fff;
      border-radius: 8px;
      box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
    }
    .claim-history-table thead,
    .post-history-table thead {
      background-color: #0D6EFD;
      color: #fff;
    }
    .claim-history-table th,
    .post-history-table th,
    .claim-history-table td,
    .post-history-table td {
      padding: 12px;
      text-align: left;
    }
    .claim-history-table tbody tr:nth-child(even),
    .post-history-table tbody tr:nth-child(even) {
      background-color: #f9f9f9;
    }
    .history-title {
      font-size: 1.5rem;
      font-weight: bold;
      text-align: center;
      margin-bottom: 20px;
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
              </div>
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
                      <label class="form-label">Course</label>
                      <p class="form-control"><?= htmlspecialchars($course) ?></p>
                    </div>
                    <div class="col-12">
                      <label class="form-label">Year</label>
                      <p class="form-control"><?= htmlspecialchars($year) ?></p>
                    </div>
                    <div class="col-12">
                      <label class="form-label">Section</label>
                      <p class="form-control"><?= htmlspecialchars($section) ?></p>
                    </div>
                    <div class="col-12">
                      <label class="form-label">Email</label>
                      <p class="form-control"><?= htmlspecialchars($email) ?></p>
                    </div>
                  </div>

                  <div class="history-title">Your Claim History</div>
                  <table class="table claim-history-table">
                    <thead>
                      <tr>
                        <th>Item Name</th>
                        <th>Claim Date</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php if (empty($claims)): ?>
                        <tr>
                          <td colspan="2" class="text-center">No claim history available.</td>
                        </tr>
                      <?php else: ?>
                        <?php foreach ($claims as $claim): ?>
                          <tr>
                            <td><?= htmlspecialchars($claim['item_name']) ?></td>
                            <td><?= htmlspecialchars($claim['claim_date']) ?></td>
                          </tr>
                        <?php endforeach; ?>
                      <?php endif; ?>
                    </tbody>
                  </table>

                  <div class="history-title">Your Posted Items</div>
                  <table class="table post-history-table">
                    <thead>
                      <tr>
                        <th>Item Name</th>
                        <th>Post Date</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php if (empty($posts)): ?>
                        <tr>
                          <td colspan="2" class="text-center">No posted items available.</td>
                        </tr>
                      <?php else: ?>
                        <?php foreach ($posts as $post): ?>
                          <tr>
                            <td><?= htmlspecialchars($post['item_name']) ?></td>
                            <td><?= htmlspecialchars($post['post_date']) ?></td>
                          </tr>
                        <?php endforeach; ?>
                      <?php endif; ?>
                    </tbody>
                  </table>

                  <div class="text-center mt-4 d-flex justify-content-center">
                    <a href="http://localhost/lostgemramonian/logout.php" class="btn btn-primary mx-2">Logout</a>
                    <a href="http://localhost/lostgemramonian/" class="btn btn-secondary mx-2">Back</a>
                  </div>

                </div>
              </div>
              <footer>
                  <div class="container text-center py-4">
                    <div class="copyright mb-2">
                      &copy; <strong><span>Ramonian LostGems</span></strong>. All Rights Reserved
                    </div>
                    <div class="credits">
                      <p>
                        <a href="http://localhost/lostgemramonian/register.php">prmsuramonianlostgems.com</a>
                      </p>
                    </div>
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
