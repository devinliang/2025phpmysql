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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $schid = $_POST['schid'];
    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $birthday = $_POST['birthday'];
    $email = $_POST['email'];
    $address = $_POST['address'];

    $stmt = $conn->prepare("INSERT INTO student (schid, name, gender, birthday, email, address) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $schid, $name, $gender, $birthday, $email, $address);

    if ($stmt->execute()) {
        header("Location: student_list.php");
        exit();
    } else {
        echo "新增失敗: " . $stmt->error;
    }
    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>新增學生</title>
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
            background-color: #28a745;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            margin-top: 15px;
            cursor: pointer;
            width: 100%;
        }
        button:hover {
            background-color: #218838;
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
        <h2>新增學生</h2>
        <form method="post">
            <label>學號:</label>
            <input type="text" name="schid" required>
            
            <label>姓名:</label>
            <input type="text" name="name" required>
            
            <label>性別:</label>
            <select name="gender" required>
                <option value="M">男</option>
                <option value="F">女</option>
            </select>
            
            <label>生日:</label>
            <input type="date" name="birthday" required>
            
            <label>Email:</label>
            <input type="email" name="email" required>
            
            <label>地址:</label>
            <textarea name="address" rows="3" required></textarea>
            
            <button type="submit">新增</button>
        </form>
        <a class="back-link" href="student_list.php">返回學生列表</a>
    </div>
</body>
</html>