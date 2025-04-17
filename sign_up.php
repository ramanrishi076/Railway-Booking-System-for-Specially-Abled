<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = new mysqli('localhost', 'root', '', 'rail_inq');

    if ($conn->connect_error) {
        echo json_encode(['success' => false, 'message' => 'Database connection failed.']);
        exit;
    }

    $name  = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['ph'] ?? '';
    $pass  = $_POST['pass'] ?? '';

    if (empty($name) || empty($email) || empty($phone) || empty($pass)) {
        echo json_encode(['success' => false, 'message' => 'All fields are required.']);
        exit;
    }

    $hashed_password = password_hash($pass, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO user_info (name, email, phone_number, pass) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $phone, $hashed_password);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Sign-up successful.']);
        
    } else {
        echo json_encode(['success' => false, 'message' => 'Sign-up failed. Please try again.']);
    }

    $stmt->close();
    $conn->close();
}
?>
