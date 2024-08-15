<?php
// edit_user.php

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
    $course_year_section = $conn->real_escape_string($_POST['course_year_section']);
    $verified = intval($_POST['verified']);
    $email = $conn->real_escape_string($_POST['email']);

    $sql = "UPDATE user_member SET 
            first_name = '$first_name', 
            last_name = '$last_name', 
            course_year_section = '$course_year_section', 
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
    </style>
</head>
<body>

<div class="container">
    <h2 class="text-center mb-4">Edit User</h2>

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
                <label for="course_year_section" class="form-label">Course, Year, Section</label>
                <input type="text" class="form-control" id="course_year_section" name="course_year_section" value="<?= htmlspecialchars($user['course_year_section']) ?>" required>
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
</body>
</html>

<?php
$conn->close();
?>
