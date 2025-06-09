<?php
include '../DAO/AdsDAO.php';

$adsDAO = new AdsDAO();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $adData = $adsDAO->getAdById($id);

    if ($adData) {
        // Xóa file ảnh quảng cáo nếu tồn tại
        if (!empty($adData['image_url'])) {
            $imagePath = '../' . $adData['image_url'];
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        // Xóa dữ liệu quảng cáo trong database
        $deleteResult = $adsDAO->deleteAdById($id);

        if ($deleteResult) {
            header("Location: AdminAdsShow.php");
            exit();
        } else {
            echo "Xóa quảng cáo không thành công.";
        }
    } else {
        echo "Không tìm thấy dữ liệu quảng cáo.";
    }
} else {
    echo "Không tìm thấy ID quảng cáo để xóa.";
}
?>