<?php
// edit_user.php
include '../../config.php';
// Database connection
$conn = new mysqli("localhost", "root", "1234", "lfis_db");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user = null;

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "SELECT * FROM user_member WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        // Redirect or display an error message if no user is found
        echo "User not found.";
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $first_name = $conn->real_escape_string($_POST['first_name']);
    $last_name = $conn->real_escape_string($_POST['last_name']);
    $college = $conn->real_escape_string($_POST['college']);
    $course = $conn->real_escape_string($_POST['course']);
    $year = $conn->real_escape_string($_POST['year']);
    $section = $conn->real_escape_string($_POST['section']);
    $verified = intval($_POST['verified']);
    $email = $conn->real_escape_string($_POST['email']);

    $sql = "UPDATE user_member SET 
            first_name = '$first_name', 
            last_name = '$last_name', 
            college = '$college', 
            course = '$course',
            year = '$year',
            section = '$section', 
            verified = $verified, 
            email = '$email' 
            WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo "1";
    } else {
        echo "0";
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<?php require_once('../inc/header.php') ?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            color: #333;
            font-family: Arial, sans-serif;
        }

        .container {
            margin-top: 30px;
            max-width: 600px;
        }

        .form-label {
            font-weight: bold;
        }

        .btn-primary {
            background-color: #0e0b71;
            border: none;
        }

        .btn-primary:hover {
            background-color: #0c0a5c;
        }

        .loading {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 9999;
        }

        .loading.show {
            display: block;
        }
        .pagetitle {
  margin-bottom: 10px;
}

.pagetitle h1 {
  font-size: 24px;
  margin-bottom: 0;
  font-weight: 600;
  color: #012970;
}
    </style>
</head>
<body>
<br>
<br>
<?php require_once('../inc/topBarNav.php') ?>
<?php require_once('../inc/navigation.php') ?> 
<div class="container">
    <h1 class="pagetitle">Edit User</h1>
    <?php if ($user): ?>
        <form id="editForm" method="POST" action="edit_user.php">
            <input type="hidden" name="id" value="<?= $user['id'] ?>">
            <div class="mb-3">
                <label for="first_name" class="form-label">First Name</label>
                <input type="text" class="form-control" id="first_name" name="first_name" value="<?= htmlspecialchars($user['first_name']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="last_name" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="last_name" name="last_name" value="<?= htmlspecialchars($user['last_name']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="college" class="form-label">College</label>
                <input type="text" class="form-control" id="college" name="college" value="<?= htmlspecialchars($user['college']) ?>" required>
            </div>

            <!-- Group Course, Year, and Section fields side by side -->
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="course" class="form-label">Course</label>
                    <input type="text" class="form-control" id="course" name="course" value="<?= htmlspecialchars($user['course']) ?>" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="year" class="form-label">Year</label>
                    <input type="text" class="form-control" id="year" name="year" value="<?= htmlspecialchars($user['year']) ?>" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="section" class="form-label">Section</label>
                    <input type="text" class="form-control" id="section" name="section" value="<?= htmlspecialchars($user['section']) ?>" required>
                </div>
            </div>

            <div class="mb-3">
                <label for="verified" class="form-label">Verified</label>
                <select class="form-select" id="verified" name="verified" required>
                    <option value="1" <?= $user['verified'] ? 'selected' : '' ?>>Yes</option>
                    <option value="0" <?= !$user['verified'] ? 'selected' : '' ?>>No</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Save Changes</button>
        </form>
    <?php else: ?>
        <p>User not found or an error occurred.</p>
    <?php endif; ?>
</div>


<div class="loading" id="loading">
    <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script>
    document.getElementById('editForm').addEventListener('submit', function() {
        document.getElementById('loading').classList.add('show');
    });
</script>
<?php require_once('../inc/footer.php') ?>
</body>
</html>

<?php
$conn->close();
?>
