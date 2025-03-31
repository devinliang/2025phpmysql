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

$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$total_result = $conn->query("SELECT COUNT(*) AS total FROM student");
$total_row = $total_result->fetch_assoc();
$total_pages = ceil($total_row['total'] / $limit);

$result = $conn->query("SELECT * FROM student LIMIT $limit OFFSET $offset");
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
            background: #252540;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 255, 255, 0.5);
            margin: auto;
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #555;
            text-align: center;
        }
        th {
            background-color: #00ffff;
            color: black;
        }
        a {
            color: #00ffff;
            text-decoration: none;
        }
        .pagination a {
            margin: 5px;
            color: #ffc107;
        }
        .btn {
            display: inline-block;
            padding: 5px 10px;
            background: #ffc107;
            color: black;
            border-radius: 5px;
            text-decoration: none;
        }
        .btn:hover {
            background: #e0a800;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>學生列表</h2>
        <a class="btn" href="student_add.php">新增學生</a>
        <table>
            <tr>
                <th>學號</th>
                <th>姓名</th>
                <th>性別</th>
                <th>操作</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['schid']); ?></td>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td><?php echo ($row['gender'] == 'M') ? '男' : '女'; ?></td>
                <td>
                    <a class="btn" href="student_detail.php?id=<?php echo $row['id']; ?>">查看</a>
                    <a class="btn" href="student_edit.php?id=<?php echo $row['id']; ?>">編輯</a>
                    <a class="btn" href="student_delete.php?id=<?php echo $row['id']; ?>" onclick="return confirm('確定要刪除嗎？');">刪除</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
        <div class="pagination">
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <a href="?page=<?php echo $i; ?>">第 <?php echo $i; ?> 頁</a>
            <?php endfor; ?>
        </div>
    </div>
</body>
</html>

<?php $conn->close(); ?>
