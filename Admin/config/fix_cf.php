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

$id_album = $_GET['id'] ?? null;
if (!$id_album) {
    die("Thiếu ID album!");
}

$sqlAlbum = "SELECT * FROM albumcasi WHERE id_album = ?";
$stmt = $conn->prepare($sqlAlbum);
$stmt->bind_param("i", $id_album);
$stmt->execute();
$result = $stmt->get_result();
$album = $result->fetch_assoc();

if (!$album) {
    die("Không tìm thấy album!");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_casi = $_POST['id_casi'];
    $linkAnh = $album['linkAnh'];

    if (isset($_FILES['linkAnh']) && $_FILES['linkAnh']['error'] == 0) {
        $file = $_FILES['linkAnh'];
        $file_name = basename($file['name']);
        $file_tmp = $file['tmp_name'];

        $upload_dir = 'images/album/';
        if (!is_dir($upload_dir)) mkdir($upload_dir, 0755, true);

        $ext = pathinfo($file_name, PATHINFO_EXTENSION);
        $unique_name = uniqid('img_', true) . '.' . $ext;
        $target_path = $upload_dir . $unique_name;

        if (move_uploaded_file($file_tmp, $target_path)) {
            $linkAnh = $target_path;
        } else {
            echo "<script>alert('Lỗi upload ảnh mới!');</script>";
        }
    }

    $updateStmt = $conn->prepare("UPDATE albumcasi SET id_casi = ?, linkAnh = ? WHERE id_album = ?");
    $updateStmt->bind_param("isi", $id_casi, $linkAnh, $id_album);
    if ($updateStmt->execute()) {
        echo "<script>alert('Cập nhật thành công!'); window.location.href='index.php';</script>";
        exit;
    } else {
        echo "Lỗi khi cập nhật: " . $updateStmt->error;
    }
}
?>
