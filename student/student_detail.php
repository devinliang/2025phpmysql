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

$stmt = $conn->prepare("SELECT * FROM student WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("找不到該學生");
}

$student = $result->fetch_assoc();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>學生詳細資料</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #1e1e2f;
            color: #ffffff;
            margin: 20px;
        }
        .container {
            max-width: 500px;
            background: #252540;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 255, 255, 0.5);
            margin: auto;
            text-align: center;
        }
        h2 {
            color: #00ffff;
        }
        .info {
            text-align: left;
            margin: 10px 0;
            padding: 10px;
            background-color: #333;
            border-radius: 5px;
        }
        .back-link {
            display: block;
            text-align: center;
            margin-top: 10px;
            color: #00ffff;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>學生詳細資料</h2>
        <div class="info"><strong>學號:</strong> <?php echo htmlspecialchars($student['schid']); ?></div>
        <div class="info"><strong>姓名:</strong> <?php echo htmlspecialchars($student['name']); ?></div>
        <div class="info"><strong>性別:</strong> <?php echo ($student['gender'] == 'M') ? '男' : '女'; ?></div>
        <div class="info"><strong>生日:</strong> <?php echo $student['birthday']; ?></div>
        <div class="info"><strong>Email:</strong> <?php echo htmlspecialchars($student['email']); ?></div>
        <div class="info"><strong>地址:</strong> <?php echo htmlspecialchars($student['address']); ?></div>
        <a class="back-link" href="student_list.php">返回學生列表</a>
    </div>
</body>
</html>