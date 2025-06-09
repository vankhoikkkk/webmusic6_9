<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Form Nhận Dữ Liệu</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <h1>Gửi Thông Tin</h1>
    <form action="submit.php" method="POST">
        <label for="name">Tên:</label>
        <input type="text" id="name" name="name" required><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br>

        <label for="message">Tin Nhắn:</label>
        <textarea id="message" name="message" required></textarea><br>

        <input type="submit" value="Gửi">
    </form>
</body>
</html>
