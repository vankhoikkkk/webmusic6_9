<?php
require_once __DIR__ . '/../DAO/AdsDAO.php';
$adsDAO = new AdsDAO();

// Lấy tổng số quảng cáo
$totalAdsResult = $adsDAO->getAllAds();
$totalAds = $adsDAO->getTotalAds();

$limit = 12;
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$total_page = ceil($totalAds / $limit);

if ($current_page > $total_page) {
    $current_page = $total_page;
} elseif ($current_page < 1) {
    $current_page = 1;
}
$start = ($current_page - 1) * $limit;
$ads = $adsDAO->getAdsByPage($start, $limit);
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Quản lý Quảng cáo</title>
    <link rel="stylesheet" href="CssAdmin/IndexAdmin.css?v=<?= time(); ?>">
    <link rel="stylesheet" href="CssAdmin/adminAds.css?v= <?=time(); ?>">
</head>

<body>
    <?php include 'headerAdmin.php'; ?>
    <div class="container-admin-left">
        <?php include 'sidebarAdmin.php'; ?>
        <main>
            <div class="ads-list">
                <?php
                if ($ads && $ads->num_rows > 0) {
                    while ($row = $ads->fetch_assoc()) {
                ?>
                        <div class="ad-card">
                            <div class="ad-title">Tên quảng cáo:<?= htmlspecialchars($row['title']) ?></div>
                            <img src="<?= "../" . $row['image_url'] ?>" alt="Ảnh QC">
                            <div class="ad-link">
                                <a href="<?= htmlspecialchars($row['target_url']) ?>" target="_blank"><?= htmlspecialchars($row['target_url']) ?></a>
                            </div>
                            <div class="ad-status">
                                Trạng thái: <strong><?= $row['active'] ? 'Hiện' : 'Ẩn' ?></strong>
                            </div>
                            <div class="ad-status">
                                Ngày tạo: <?= htmlspecialchars($row['created_at'] ?? '') ?>
                            </div>
                            <div class="ad-actions">
                                <a href="AdminAdsEdit.php?id=<?= $row['id'] ?>">Sửa</a>
                                <a href="AdminAdsDelete.php?id=<?= $row['id'] ?>" class="delete"
                                    onclick="return confirm('Bạn có chắc muốn xóa?')">Xóa</a>
                            </div>
                        </div>
                <?php
                    }
                } else {
                    echo "<p>Không có quảng cáo nào.</p>";
                }
                ?>
            </div>
            <div class="list-buttom">
                <ul class="pagination">
                    <?php
                    if ($current_page > 1 && $total_page > 1) {
                        echo '<a href="AdminAdsShow.php?page=' . ($current_page - 1) . '">Prev</a> | ';
                    }
                    for ($i = 1; $i <= $total_page; $i++) {
                        if ($i == $current_page) {
                            echo '<span>' . $i . '</span> | ';
                        } else {
                            echo '<a href="AdminAdsShow.php?page=' . $i . '">' . $i . '</a> | ';
                        }
                    }
                    if ($current_page < $total_page && $total_page > 1) {
                        echo '<a href="AdminAdsShow.php?page=' . ($current_page + 1) . '">Next</a>';
                    }
                    ?>
                </ul>
            </div>
        </main>
    </div>
    <?php include 'footerAdmin.php'; ?>
</body>

</html>