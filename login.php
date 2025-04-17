<?php
header('Content-Type: application/json');
require_once 'db_connect.php'; // Make sure this file exists with correct DB creds

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $phone = $_POST['ph'] ?? '';
    $pass  = $_POST['pass'] ?? '';

    if (empty($phone) || empty($pass)) {
        echo json_encode(['success' => false, 'message' => 'Phone and password are required.']);
        exit;
    }

    // Prepare statement to avoid SQL injection
    $stmt = $conn->prepare("SELECT pass FROM user_info WHERE phone_number = ?");
    $stmt->bind_param("s", $phone);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($hashed_pass);
        $stmt->fetch();

        if (password_verify($pass, $hashed_pass)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Incorrect password!']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'User does not exist… please Sign Up first!']);
    }

    $stmt->close();
    $conn->close();
}
?>
