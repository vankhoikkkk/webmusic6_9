<?php 
include 'DAO/LuotNgheDAO.php';

?>

<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_baihat = $_POST['id_baihat'];
    
    if (isset($id_baihat) && is_numeric($id_baihat)) {
        $luotNghe = new LuotNgheDAO();
       

        $result = $luotNghe->UpdateLuotNgheBaiHat($id_baihat);
      
        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'message' => 'Đã tăng lượt nghe']);
    } else {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'ID bài hát không hợp lệ']);
    }
    exit;
}   
?>
