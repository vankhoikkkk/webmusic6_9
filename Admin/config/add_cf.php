<?php
require_once 'config/config.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_casi = filter_input(INPUT_POST, 'id_casi', FILTER_VALIDATE_INT);
    $linkAnh = '';

    if (!$id_casi) {
        $error = 'Vui lòng chọn ca sĩ hợp lệ';
    }

if (isset($_FILES['linkAnh']) && $_FILES['linkAnh']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = '../albumcasi/';

    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $originalFileName = basename($_FILES['linkAnh']['name']);
    $fileExtension = strtolower(pathinfo($originalFileName, PATHINFO_EXTENSION));
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

    if (!in_array($fileExtension, $allowedExtensions)) {
        $error = 'Chỉ chấp nhận file ảnh (JPG, JPEG, PNG, GIF)';
    } else {
        $uploadFile = $uploadDir . $originalFileName;

        if (file_exists($uploadFile)) {
            $error = 'File ảnh đã tồn tại!';
        } else {
            if (move_uploaded_file($_FILES['linkAnh']['tmp_name'], $uploadFile)) {
                $linkAnh = 'albumcasi/' . $originalFileName;
            } else {
                $error = 'Lỗi khi tải file ảnh';
            }
        }
    }
} else {
    $error = 'Vui lòng chọn file ảnh!';
}


    if (empty($error)) {
        try {
            $stmt = $conn->prepare("INSERT INTO albumcasi (id_casi, linkAnh) VALUES (?, ?)");
            $stmt->bind_param("is", $id_casi, $linkAnh);
            
            if ($stmt->execute()) {
                $success = 'Thêm album thành công!';
                header("Location: AdminAlbumShow.php");
                exit;
            } else {
                $error = "Lỗi khi thêm album: " . $stmt->error;
            }
        } catch (Exception $e) {
            $error = "Lỗi: " . $e->getMessage();
        }
    }
}

try {
    $sqlCaSi = "SELECT id_casi, tenCaSi FROM casi ORDER BY tenCaSi ASC";
    $resultCaSi = $conn->query($sqlCaSi);
} catch (Exception $e) {
    $error = "Lỗi khi lấy danh sách ca sĩ: " . $e->getMessage();
}
?>