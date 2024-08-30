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
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            line-height: 1.6;
            color: #333;
        }
        h1 {
            text-align: center;
            margin: 20px 0;
            color: #2c3e50;
            font-size: 24px;
        }
        table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        th, td {
            padding: 12px 15px;
            text-align: left;
            font-size: 14px;
        }
        th {
            background-color: #2c3e50;
            color: #ecf0f1;
        }
        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tbody tr:hover {
            background-color: #e8e8e8;
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
            background-color: #3498db;
        }
        .action-buttons .approve {
            background-color: #28a745;
        }
        .action-buttons .delete {
            background-color: #dc3545;
        }
        .action-buttons button:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body>
<?php require_once('../inc/topBarNav.php') ?>
<?php require_once('../inc/navigation.php') ?> 
<br>
<br>
    <h1 class="text-center mb-4">Claims List</h1>
    <table>
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
                    <td colspan="9">No claims found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <?php require_once('../inc/footer.php') ?>
</body>
</html>
