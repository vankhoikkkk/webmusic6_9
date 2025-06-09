<?php
include_once 'DAO/LSNhacNguoiDungDAO.php';
?>


<?php
session_start();
header('Content-Type: application/json');
if (!isset($_SESSION['id_nguoidung'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Vui lòng đăng nhập để lưu lịch sử nghe nhạc'
    ]);
    exit;
}
$id_nguoidung = $_SESSION['id_nguoidung'];

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_baihat = $_POST['id_baihat'];
    
    if (isset($id_baihat)) {
        $lsNhacNguoiDung = new LSNhacNguoiDungDAO();
        $result = $lsNhacNguoiDung->KiemTraBaiHatDaLuu($id_baihat, $id_nguoidung);
        
        if ($result && $result->num_rows > 0) {
            // Bài hát đã được lưu, xóa khỏi danh sách
            $lsNhacNguoiDung->xoaBaiHatDaLuu($id_baihat, $id_nguoidung);
            $lsNhacNguoiDung->luuMoiLS($id_baihat, $id_nguoidung);
            echo json_encode(['success' => true, 'message' => 'Đã chập nhập bài hát trong lịch sử nghe']);
        } else {
            // Bài hát chưa được lưu, thêm mới
            $lsNhacNguoiDung->luuMoiLS($id_baihat, $id_nguoidung);
            echo json_encode(['success' => true, 'message' => 'Đã lưu bài hát vào lịch sử nghe']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'ID bài hát không hợp lệ']);
    }
    exit;
}

?>