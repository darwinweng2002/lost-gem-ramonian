<?php
// Database connection
$conn = new mysqli('localhost', 'root', '1234', 'lfis_db'); // Replace with your actual DB connection details

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch the claim history for displaying in the activity log
$sql = "SELECT ch.id, ch.claimed_by, ch.claimed_at, il.title 
        FROM claim_history ch 
        JOIN item_list il ON ch.item_id = il.id 
        ORDER BY ch.claimed_at DESC";
$result = $conn->query($sql);

// Handle delete request
if (isset($_POST['delete_id'])) {
    $delete_id = $_POST['delete_id'];
    $delete_sql = "DELETE FROM claim_history WHERE id = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param('i', $delete_id);
    $stmt->execute();
    header("Location: " . $_SERVER['PHP_SELF']); // Refresh the page to see the updated list
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activity Log - Claim History</title>
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

        .no-data {
            text-align: center;
            font-size: 1.2rem;
            color: #333; /* Dark color for no data message */
            padding: 30px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center mb-4">Claim Activity Log</h2>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Item Title</th>
                        <th>Claimed By</th>
                        <th>Claimed At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()):
                    ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo htmlspecialchars($row['title']); ?></td>
                            <td><?php echo htmlspecialchars($row['claimed_by']); ?></td>
                            <td><?php echo date("Y-m-d g:i A", strtotime($row['claimed_at'])); ?></td>
                            <td>
                                <form method="post" onsubmit="return confirm('Are you sure you want to delete this record?');">
                                    <input type="hidden" name="delete_id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" class="btn btn-delete">Delete
                                        <span class="spinner-border spinner-border-sm"></span>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php 
                        endwhile;
                    } else {
                        echo "<tr><td colspan='5' class='no-data'>No claim history found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        function deleteUser(id) {
            if (confirm("Are you sure you want to delete this record?")) {
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
                        alert('An error occurred while deleting the record.');
                    }
                })
                .catch(() => {
                    spinner.style.display = 'none'; // Hide loading spinner on error
                    button.disabled = false; // Re-enable button
                    alert('An error occurred while deleting the record.');
                });
            }
        }
    </script>
</body>
</html>

<?php
$conn->close();
?>
