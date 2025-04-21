<?php
$servername = "localhost";
$username = "root"; // 根據你的資料庫設定修改
$password = ""; // 根據你的資料庫設定修改
$dbname = "school"; // 修改為你的資料庫名稱

// 建立連線
$conn = new mysqli($servername, $username, $password, $dbname);

// 檢查連線
if ($conn->connect_error) {
    die("連線失敗: " . $conn->connect_error);
}

// 設定編碼，確保中文顯示正常
$conn->set_charset("utf8mb4");

// 刪除書籍處理
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM book WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    header("Location: book_list.php");
    exit();
}

// 取得書籍列表
$result = $conn->query("SELECT * FROM book");
$conn->close();
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>書籍管理</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2>書籍管理</h2>
    <a href="book_add.php">新增書籍</a>
    <h3>書籍列表</h3>
    <table>
        <tr>
            <th>ID</th>
            <th>書名</th>
            <th>作者</th>
            <th>出版社</th>
            <th>出版日期</th>
            <th>定價</th>
            <th>內容說明</th>
            <th>操作</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row["id"]; ?></td>
            <td><?php echo $row["bookname"]; ?></td>
            <td><?php echo $row["author"]; ?></td>
            <td><?php echo $row["publisher"]; ?></td>
            <td><?php echo $row["pubdate"]; ?></td>
            <td><?php echo $row["price"]; ?></td>
            <td><?php echo nl2br($row["content"]); ?></td>
            <td>
                <a href="book_detail.php?id=<?php echo $row['id']; ?>">查看</a>
                <a href="book_edit.php?id=<?php echo $row['id']; ?>">修改</a>
                <a href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('確定刪除?');">刪除</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
