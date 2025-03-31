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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $schid = $_POST['schid'];
    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $birthday = $_POST['birthday'];
    $email = $_POST['email'];
    $address = $_POST['address'];

    $stmt = $conn->prepare("UPDATE student SET schid=?, name=?, gender=?, birthday=?, email=?, address=? WHERE id=?");
    $stmt->bind_param("ssssssi", $schid, $name, $gender, $birthday, $email, $address, $id);

    if ($stmt->execute()) {
        header("Location: student_list.php");
        exit();
    } else {
        echo "更新失敗: " . $stmt->error;
    }
    $stmt->close();
}

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
    <title>編輯學生</title>
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
        }
        label {
            font-weight: bold;
            display: block;
            margin-top: 10px;
        }
        input, select, textarea {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #555;
            border-radius: 4px;
            background-color: #333;
            color: white;
        }
        button {
            background-color: #ffc107;
            color: black;
            padding: 10px;
            border: none;
            border-radius: 4px;
            margin-top: 15px;
            cursor: pointer;
            width: 100%;
        }
        button:hover {
            background-color: #e0a800;
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
        <h2>編輯學生</h2>
        <form method="post">
            <label>學號:</label>
            <input type="text" name="schid" value="<?php echo htmlspecialchars($student['schid']); ?>" required>
            
            <label>姓名:</label>
            <input type="text" name="name" value="<?php echo htmlspecialchars($student['name']); ?>" required>
            
            <label>性別:</label>
            <select name="gender" required>
                <option value="M" <?php echo ($student['gender'] == 'M') ? 'selected' : ''; ?>>男</option>
                <option value="F" <?php echo ($student['gender'] == 'F') ? 'selected' : ''; ?>>女</option>
            </select>
            
            <label>生日:</label>
            <input type="date" name="birthday" value="<?php echo $student['birthday']; ?>" required>
            
            <label>Email:</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($student['email']); ?>" required>
            
            <label>地址:</label>
            <textarea name="address" rows="3" required><?php echo htmlspecialchars($student['address']); ?></textarea>
            
            <button type="submit">更新</button>
        </form>
        <a class="back-link" href="student_list.php">返回學生列表</a>
    </div>
</body>
</html>