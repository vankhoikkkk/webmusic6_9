<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "musicdemo";
$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

$id_album = $_GET['id'] ?? null;
if (!$id_album) {
    die("Thiếu ID album để xóa!");
}

$sql = "SELECT linkAnh FROM albumcasi WHERE id_album = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_album);
$stmt->execute();
$result = $stmt->get_result();
$album = $result->fetch_assoc();

if (!$album) {
    die("Không tìm thấy album cần xóa!");
}

if (file_exists($album['linkAnh'])) {
    unlink($album['linkAnh']);
}

$deleteStmt = $conn->prepare("DELETE FROM albumcasi WHERE id_album = ?");
$deleteStmt->bind_param("i", $id_album);

if ($deleteStmt->execute()) {
    echo "<script>alert('Xóa album thành công!'); window.location.href='index.php';</script>";
    exit;
} else {
    echo "Lỗi khi xóa album: " . $deleteStmt->error;
}
?>
