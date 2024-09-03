<?php  
// Include the database configuration file
include 'config.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $college = $_POST['college'];
    $course = $_POST['course']; // New field
    $year = $_POST['year']; // New field
    $section = $_POST['section']; // New field
    $verified = isset($_POST['verified']) ? 1 : 0;
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Prepare and execute query
    $stmt = $conn->prepare("INSERT INTO user_member (first_name, last_name, college, course, year, section, verified, email, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssiss", $first_name, $last_name, $college, $course, $year, $section, $verified, $email, $password);

    if ($stmt->execute()) {
        $response = ["success" => true];
    } else {
        $response = ["success" => false, "message" => $stmt->error];
    }
    $stmt->close();

    // Send JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>
