<?php 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);



include_once 'DAO/LuuBaihatNguoiDungDAO.php';
session_start();


// Kiểm tra đăng nhập
if (!isset($_SESSION['id_nguoidung'])) {
    header('Content-Type: application/json');
    echo json_encode([
        'success' => false,
        'message' => 'Vui lòng đăng nhập để lưu bài hát'
    ]);
    exit;
}

// Lấy ID người dùng từ session
$id_nguoidung = $_SESSION['id_nguoidung'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_baihat = $_POST['id_baihat'];
    
    if (isset($id_baihat)) {
        $luuBaiHat = new LuuBaihatNguoiDung();
        $result = $luuBaiHat->KiemTraBaiHatDaLuu($id_baihat, $id_nguoidung);
        
        if ($result && $result->num_rows > 0) {
            // Bài hát đã được lưu, xóa khỏi danh sách
            $luuBaiHat->DeleteHatDaLuu($id_baihat, $id_nguoidung);
            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'message' => 'Đã xoá bài hát khỏi danh sách lưu']);
        } else {
            // Bài hát chưa được lưu, thêm mới
            $luuBaiHat->LuuBaiHat($id_baihat, $id_nguoidung);
            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'message' => 'Đã lưu bài hát vào danh sách']);
        }
    } else {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'ID bài hát không hợp lệ']);
    }
    exit;
}
?>
