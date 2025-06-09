<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "musicdemo";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

$sqlCaSi = "SELECT id_casi, tenCaSi FROM casi";
$resultCaSi = $conn->query($sqlCaSi);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_casi = $_POST['id_casi'];

    if (!empty($id_casi) && isset($_FILES['linkAnh'])) {
        $file = $_FILES['linkAnh'];
        $file_name = basename($file['name']);
        $file_tmp = $file['tmp_name'];

        $upload_dir = 'images/album/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        $ext = pathinfo($file_name, PATHINFO_EXTENSION);
        $unique_name = $originalFileName;
        $target_path = $upload_dir . $unique_name;

        if (move_uploaded_file($file_tmp, $target_path)) {
            $stmt = $conn->prepare("INSERT INTO albumcasi (id_casi, linkAnh) VALUES (?, ?)");
            $stmt->bind_param("is", $id_casi, $target_path);

            if ($stmt->execute()) {
                echo "<script>alert('Thêm album thành công!'); window.location.href='index.php';</script>";
                exit;
            } else {
                echo "Lỗi khi thêm album: " . $stmt->error;
            }
        } else {
            echo "<script>alert('Lỗi khi tải ảnh lên máy chủ!');</script>";
        }
    } else {
        echo "<script>alert('Vui lòng chọn ca sĩ và ảnh!');</script>";
    }
}
?>
