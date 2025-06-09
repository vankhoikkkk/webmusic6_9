<?php
session_start();
include '../DAO/AdsDAO.php';
$adsDAO = new AdsDAO();

if (!isset($_GET['id'])) {
    header('Location: AdminAdsShow.php');
    exit();
}
$id = intval($_GET['id']);
$ad = $adsDAO->getAdById($id);
if (!$ad) {
    echo "Không tìm thấy quảng cáo.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $target_url = $_POST['target_url'];
    $image_url = $ad['image_url'];
    $active = isset($_POST['active']) ? 1 : 0;

    // Nếu có upload ảnh mới
    if (!empty($_FILES['image_file']['name'])) {
        $uploadDir = "../Ads/";
        $fileName = time() . '_' . basename($_FILES['image_file']['name']);
        $uploadFile = $uploadDir . $fileName;
        if (move_uploaded_file($_FILES['image_file']['tmp_name'], $uploadFile)) {
            $image_url = 'Ads/' . $fileName;
        } else {
            echo "Lỗi khi tải lên ảnh mới.";
        }
    }

    if ($title && $target_url && $image_url) {
        $result = $adsDAO->updateAd($id, $title, $image_url, $target_url, $active);
        if ($result) {
            header("Location: AdminAdsShow.php");
            exit();
        } else {
            echo "Cập nhật quảng cáo thất bại.";
        }
    } else {
        echo "Vui lòng nhập đầy đủ thông tin!";
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sửa Quảng Cáo</title>
    <link rel="stylesheet" href="CssAdmin/formSong.css?v=<?= time(); ?>">
    <link rel="stylesheet" href="CssAdmin/IndexAdmin.css?v=<?= time(); ?>">
</head>
<body>
    <?php include 'headerAdmin.php'; ?>
    <div class="container-admin-left">
        <?php include 'sidebarAdmin.php'; ?>
        <main>
            <h2>Sửa Quảng Cáo</h2>
            <form method="POST" enctype="multipart/form-data">
                <label>Tiêu đề:</label>
                <input type="text" name="title" value="<?= htmlspecialchars($ad['title']) ?>" required>

                <label>Ảnh hiện tại:</label><br>
                <img src="../<?= htmlspecialchars($ad['image_url']) ?>" alt="Ảnh quảng cáo" style="max-width:150px;"><br>
                <label>Chọn ảnh mới (nếu muốn thay):</label>
                <input type="file" name="image_file" accept="image/*">

                <label>Link đích (target_url):</label>
                <input type="text" name="target_url" value="<?= htmlspecialchars($ad['target_url']) ?>" required>

                <label>Trạng thái:</label>
                <input type="checkbox" name="active" value="1" <?= $ad['active'] ? 'checked' : '' ?>> Hiển thị

                <input type="submit" value="Cập Nhật">
            </form>
        </main>
    </div>
    <?php include 'footerAdmin.php'; ?>
</body>
</html>