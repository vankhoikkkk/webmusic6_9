<?php
$servername = "localhost";
$username = "root"; // Thay đổi nếu cần
$password = ""; // Thay đổi nếu cần
$dbname = "music_db";

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Lấy dữ liệu từ cơ sở dữ liệu
$sql = "SELECT * FROM user_submissions";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Trang Quản Trị</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <h1>Danh Sách Thông Tin Người Dùng</h1>
    <?php
    if ($result->num_rows > 0) {
        echo "<table><tr><th>ID</th><th>Tên</th><th>Email</th><th>Tin Nhắn</th><th>Thời Gian</th></tr>";
        while($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row["id"]. "</td><td>" . $row["name"]. "</td><td>" . $row["email"]. "</td><td>" . $row["message"]. "</td><td>" . $row["created_at"]. "</td></tr>";
        }
        echo "</table>";
    } else {
        echo "Không có dữ liệu nào.";
    }
    $conn->close();
    ?>
</body>
</html>
