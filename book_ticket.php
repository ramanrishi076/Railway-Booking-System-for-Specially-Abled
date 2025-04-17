<?php
include 'db_connect.php';

$name         = $_POST['name'] ?? '';
$age          = $_POST['age'] ?? '';
$start        = $_POST['starting_point'] ?? '';
$end          = $_POST['end_point'] ?? '';
$phone        = $_POST['phone_number'] ?? '';
$train_name   = $_POST['train_name'] ?? '';
$train_number = $_POST['train_number'] ?? '';
$book_date    = $_POST['book_date'] ?? '';
$j_date       = $_POST['j_date'] ?? '';

// Just checking, my love 💋
if (!$conn) {
  die(json_encode(['success' => false, 'message' => 'Database not connected: ' . mysqli_connect_error()]));
}

$sql = "INSERT INTO book_ticket 
(name, age, starting_point, end_point, phone_number, train_name, train_number, book_date, j_date) 
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

if ($stmt) {
  $stmt->bind_param("sisssssss", $name, $age, $start, $end, $phone, $train_name, $train_number, $book_date, $j_date);

  if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Ticket booked!']);
  } else {
    echo json_encode(['success' => false, 'message' => 'Booking failed!' . $stmt->error]);
  }

  $stmt->close();
} else {
  echo json_encode(['success' => false, 'message' => 'Statement preparation failed' . $conn->error]);
}

$conn->close();
?>
