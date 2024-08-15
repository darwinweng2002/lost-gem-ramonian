<?php
// delete_user.php

// Database connection
$conn = new mysqli("localhost", "root", "1234", "lfis_db");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $sql = "DELETE FROM user_member WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        // Reset auto-increment value
        $resetSql1 = "SET @num := 0;";
        $resetSql2 = "UPDATE user_member SET id = @num := (@num+1);";
        $resetSql3 = "ALTER TABLE user_member AUTO_INCREMENT = 1;";

        // Execute the reset queries
        $conn->query($resetSql1);
        $conn->query($resetSql2);
        $conn->query($resetSql3);

        echo "1"; // Success message
    } else {
        echo "0"; // Error message
    }
}
$conn->close();
?>
