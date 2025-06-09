<?php
include '../DAO/AdsDAO.php';
$adsDAO = new AdsDAO();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $target_url = $_POST['target_url'];
    $image_url = '';

    $uploadDir = "../Ads/";
    $imageName = $_FILES['image_file']['name'];
    $imagePath = $uploadDir . basename($imageName);

    $uploadSuccess = true;

    // Xử lý upload ảnh quảng cáo
    if (!empty($imageName) && !move_uploaded_file($_FILES['image_file']['tmp_name'], $imagePath)) {
        echo "Lỗi khi tải lên file ảnh quảng cáo.";
        $uploadSuccess = false;
    }

    if ($uploadSuccess) {
        $imageDB = 'Ads/' . basename($imageName);

        $addAd = $adsDAO->addAd($title, $imageDB, $target_url);

        if ($addAd) {
            header("Location: AdminAdsShow.php");
            exit();
        } else {
            echo "Thêm quảng cáo không thành công.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm Quảng Cáo Mới</title>
    <link rel="stylesheet" href="CssAdmin/formSong.css?v=<?= time(); ?>">
    <link rel="stylesheet" href="CssAdmin/IndexAdmin.css?v=<?= time(); ?>">
</head>
<body>
    <?php include 'headerAdmin.php'; ?>
    <div class="container-admin-left">
        <?php include 'sidebarAdmin.php'; ?>
        <main>
            <h2>Thêm Quảng Cáo Mới</h2>
            <form method="POST" enctype="multipart/form-data">
                <label>Tiêu đề:</label>
                <input type="text" name="title" required>

                <label>Ảnh quảng cáo:</label>
                <input type="file" name="image_file" accept="image/*" required>

                <label>Link đích:</label>
                <input type="text" name="target_url" required>

                <input type="submit" value="Thêm Quảng Cáo">
            </form>
        </main>
    </div>
    <?php include 'footerAdmin.php'; ?>
</body>
</html>