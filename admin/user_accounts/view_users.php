<?php
// view_users.php

// Database connection
$conn = new mysqli("localhost", "root", "1234", "lfis_db");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize search term
$searchTerm = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';

// Update SQL query to include search functionality
$sql = "SELECT * FROM user_member WHERE 
        CONCAT_WS(' ', first_name, last_name, course, year, section, email) LIKE '%$searchTerm%'";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Users</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f1f2f1;
            color: #333;
            font-family: Arial, sans-serif;
        }

        .container {
            margin-top: 30px;
        }

        .table-responsive {
            background: #fff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .table thead {
            background-color: #0e0b71;
            color: white;
        }

        .table th, .table td {
            text-align: center;
            vertical-align: middle;
        }

        .btn {
            border-radius: 0; /* No border radius */
        }

        .btn-edit {
            background-color: #007bff;
            color: #fff;
            border: none; /* No border */
        }

        .btn-edit:hover {
            background-color: #0056b3;
            color: #fff;
        }

        .btn-delete {
            background-color: #dc3545;
            color: #fff;
            border: none; /* No border */
            position: relative;
        }

        .btn-delete:hover {
            background-color: #c82333;
            color: #fff;
        }

        .btn-delete .spinner-border {
            display: none;
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
        }

        .search-form {
            margin-bottom: 20px;
        }

        .search-input {
            border-radius: 0;
            box-shadow: none;
            border: 1px solid #ddd;
            width: 200px; /* Adjust width to make it smaller */
        }

        .search-button {
            border-radius: 0;
            background-color: #28a745; /* Green background */
            color: #fff; /* White text */
            border: none;
        }

        .search-button:hover {
            background-color: #218838; /* Darker green on hover */
        }
    </style>
</head>
<body>
<section class="section">
<div class="container">
    <h2 class="text-center mb-4">Registered Users</h2>

    <!-- Search Form -->
    <form class="search-form d-flex" method="GET" action="view_users.php">
        <input type="text" name="search" class="form-control search-input" placeholder="Search users..." value="<?= htmlspecialchars($searchTerm) ?>">
        <button type="submit" class="btn search-button ms-2">Search</button>
    </form>

    <div class="table-responsive">
        <table class="table table-hover table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>College</th>
                    <th>Course</th>
                    <th>Year</th>
                    <th>Section</th>
                    <th>Verified</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= $row['first_name'] ?></td>
                        <td><?= $row['last_name'] ?></td>
                        <td><?= $row['college'] ?></td>
                        <td><?= $row['course'] ?></td>
                        <td><?= $row['year'] ?></td>
                        <td><?= $row['section'] ?></td>
                        <td><?= $row['verified'] ? 'Yes' : 'No' ?></td>
                        <td><?= $row['email'] ?></td>
                        <td>
    <div class="d-flex justify-content-center">
        <a href="edit_user.php?id=<?= $row['id'] ?>" class="btn btn-edit btn-sm me-2">
            <i class="fa fa-edit"></i> Edit
        </a>
        <button class="btn btn-delete btn-sm" onclick="deleteUser(<?= $row['id'] ?>)">
            <i class="fa fa-trash"></i> Delete
            <span class="spinner-border spinner-border-sm"></span>
        </button>
    </div>
</td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" class="text-center">No registered users found.</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
</section>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script>
    function deleteUser(id) {
        if (confirm("Are you sure you want to delete this user?")) {
            const button = event.currentTarget;
            const spinner = button.querySelector('.spinner-border');
            button.disabled = true; // Disable button to prevent multiple clicks
            spinner.style.display = 'inline-block'; // Show loading spinner

            fetch('delete_user.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'id=' + id
            })
            .then(response => response.text())
            .then(result => {
                spinner.style.display = 'none'; // Hide loading spinner
                button.disabled = false; // Re-enable button
                if (result.trim() === '1') {
                    location.reload();
                } else {
                    alert('An error occurred while deleting the user.');
                }
            })
            .catch(() => {
                spinner.style.display = 'none'; // Hide loading spinner on error
                button.disabled = false; // Re-enable button
                alert('An error occurred while deleting the user.');
            });
        }
    }
</script>

</body>
</html>

<?php
$conn->close();
?>
