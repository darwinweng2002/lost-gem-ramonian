<?php
include '../../config.php';

// Check if the database connection is established
if (!$conn) {
    die('Database connection failed: ' . mysqli_connect_error());
}

// Example if user information is stored in a table named `members`
$qry = $conn->query("
    SELECT 
        c.id AS claim_id, 
        c.user_id, 
        c.item_id, 
        c.verification_document, 
        c.additional_info,
        i.title AS item_title, 
        m.email AS user_email,
        m.course AS user_course,
        m.year AS user_year,
        m.section AS user_section
    FROM 
        claims c
    INNER JOIN 
        item_list i ON c.item_id = i.id
    INNER JOIN 
        user_member m ON c.user_id = m.id
");



// Debug output
if (!$qry) {
    echo 'Error executing query: ' . $conn->error;
    exit;
}

if ($qry->num_rows > 0) {
    $claims = $qry->fetch_all(MYSQLI_ASSOC);
} else {
    $claims = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<?php require_once('../inc/header.php') ?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Claims List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        h1 {
            text-align: center;
            margin: 20px 0;
            color: #333;
        }
        table {
            width: 90%;
            margin: 0 auto;
            border-collapse: collapse;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f9f9f9;
            color: black;
        }
        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tbody tr:hover {
            background-color: #f1f1f1;
        }
        .action-buttons {
            display: flex;
            gap: 10px;
        }
        .action-buttons button {
            border: none;
            border-radius: 4px;
            padding: 8px 12px;
            font-size: 14px;
            cursor: pointer;
            color: #fff;
            transition: background-color 0.3s;
        }
        .action-buttons .view {
            background-color: #007bff;
        }
        .action-buttons .approve {
            background-color: #28a745;
        }
        .action-buttons .delete {
            background-color: #dc3545;
        }
        .action-buttons button:hover {
            opacity: 0.8;
        }
    </style>
</head>
<body>
<?php require_once('../inc/topBarNav.php') ?>
<?php require_once('../inc/navigation.php') ?> 
    <h1>Claims List</h1>
    <table border="0">
        <thead>
            <tr>
                <th>Claim ID</th>
                <th>Item Title</th>
                <th>User Email</th>
                <th>User Course</th>
                <th>User Year</th>
                <th>User Section</th>
                <th>Verification Document</th>
                <th>Additional Info</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($claims)): ?>
                <?php foreach ($claims as $claim): ?>
                    <tr>
                        <td><?= htmlspecialchars($claim['claim_id']) ?></td>
                        <td><?= htmlspecialchars($claim['item_title']) ?></td>
                        <td><?= htmlspecialchars($claim['user_email']) ?></td>
                        <td><?= htmlspecialchars($claim['user_course']) ?></td>
                        <td><?= htmlspecialchars($claim['user_year']) ?></td>
                        <td><?= htmlspecialchars($claim['user_section']) ?></td>
                        <td><?= htmlspecialchars($claim['verification_document']) ?></td>
                        <td><?= htmlspecialchars($claim['additional_info']) ?></td>
                        <td class="action-buttons">
                            <button class="view">View</button>
                            <button class="approve">Approve</button>
                            <button class="delete">Delete</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="10">No claims found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <?php require_once('../inc/footer.php') ?>
</body>
</html>
