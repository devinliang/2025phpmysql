<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "school";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("連線失敗: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("未提供學生 ID");
}

$id = $_GET['id'];

$stmt = $conn->prepare("DELETE FROM student WHERE id=?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: student_list.php");
    exit();
} else {
    echo "刪除失敗: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
