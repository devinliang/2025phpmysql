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

$sql = "SELECT * FROM student ORDER BY id DESC";
$result = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>學生列表</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #1e1e2f;
            color: #ffffff;
            margin: 20px;
        }
        .container {
            max-width: 800px;
            margin: auto;
            background: #252540;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 255, 255, 0.5);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #444;
        }
        th {
            background-color: #007bff;
        }
        a {
            color: #00ffff;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        .add-button {
            display: block;
            text-align: center;
            background-color: #28a745;
            color: white;
            padding: 10px;
            border-radius: 4px;
            margin-top: 10px;
            text-decoration: none;
        }
        .add-button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>學生列表</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>學號</th>
                <th>姓名</th>
                <th>操作</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo htmlspecialchars($row['schid']); ?></td>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td>
                    <a href="student_detail.php?id=<?php echo $row['id'];?>">查看</a> |
                    <a href="student_edit.php?id=<?php echo $row['id']; ?>">編輯</a> |
                    <a href="student_delete.php?id=<?php echo $row['id']; ?>" onclick="return confirm('確定刪除?');">刪除</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
        <a class="add-button" href="student_add.php">新增學生</a>
    </div>
</body>
</html>
