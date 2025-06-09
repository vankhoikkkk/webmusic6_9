<?php
include 'DAO/DetailCategoryDAO.php';
include 'DAO/SingerDAO.php';
?>


<?php

$detaiCategory = new DetailCategoryDAO();
$singer = new SingerDAO();
$result_singer = null;
$result_idbaihat = null;

if (isset($_GET['id_baihat'])) {
    $id_baihat = $_GET['id_baihat'];
    $result_idbaihat = $detaiCategory->getMusicOfId($id_baihat);
    $result_singer = $singer->getSingerBySongId($id_baihat);
} else {
    echo "ID bài hát không được cung cấp.";
}
$singerInfo = $result_singer->fetch_assoc();

$row_idbaihat = $result_idbaihat->fetch_assoc();
$result = $detaiCategory->getAllMusicOfGenger($row_idbaihat['theloai'], $row_idbaihat['id_baihat']);


?>


<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bolero Hay Nhất</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="CSS/playMusic.css">
    <link rel="stylesheet" href="CSS/songCard.css">
    <link rel="stylesheet" href="CSS/DetailCategory.css">
    <link rel="stylesheet" href="CSS/header.css">
    <link rel="stylesheet" href="CSS/footer.css">
</head>
<style>
    .song-card.list-card {
        height: 80px;
    }

    .container {
        padding-top: 100px;
    }
</style>

<body>
    <?php include 'header.php'; ?>
    <div class="container">
        <!-- Bên trái: Bài nhạc chính -->
        <div class="main-song">
            <div class="song-card playingg" data-audio="<?php echo $row_idbaihat['linknhac']; ?> " data-id="<?php echo $row_idbaihat['id_baihat']; ?>">
                <div class="play-overlay">
                    <i class='bx bx-play-circle'></i>
                </div>
                <img src="<?php echo $row_idbaihat['album']; ?>" alt="Song">
                <!-- chỗ này viết để cho thanh nhạc có thể lấy và hiện thông tin -->
                <div style="display:  none;" class="song-info">
                    <p class="baihat"><?php echo $row_idbaihat['tenbaihat']; ?></p>
                    <p class="casi"> <?php echo $row_idbaihat['tenCaSi']; ?></p>
                </div>
            </div>
            <!-- chỗ này viết để show ra người dùng thấy -->
            <div class="song-info show-main" data-id_casi="<?php echo $row_idbaihat['id_casi']; ?>">
                <p class="show-main-text "> <?php echo $row_idbaihat['tenbaihat']; ?></p>
                <p class="show-main-text casi"> (<?php echo $row_idbaihat['tenCaSi']; ?>)</p>
                <br>
                <p>lượt nghe: <?php echo $row_idbaihat['luotnghe']; ?> </p>
            </div>
            <div class="info-song">
                <strong>Nghệ sĩ : </strong>
                <p class="nghesi"> <?php echo $row_idbaihat['ngheSi']; ?> </p>
                <strong>Mô Tả Bài Hát : </strong>
                <p class="mota"> <?php echo $row_idbaihat['moTa']; ?></p>
            </div>

        </div>

        <!-- Bên phải: Danh sách nhạc và nghệ sĩ -->
        <div class="right-panel">
            <div class="song-list">
                <h3>Danh sách bài hát</h3>
                <?php
                if ($result) {
                    while ($row = $result->fetch_assoc()) {
                ?>
                        <div class="song-item">
                            <div class="song-card list-card" data-audio="<?php echo $row['linknhac']; ?>" data-id="<?php echo $row['id_baihat']; ?>">
                                <div class="play-overlay list-card">
                                    <i class='bx bx-play-circle'></i>
                                </div>
                                <img src="<?php echo $row['album']; ?>" alt="Song">
                                <div class="song-info">
                                    <p class="baihat"><?php echo $row['tenbaihat']; ?></p>
                                    <br>
                                    <p class="casi">(<?php echo $row['tenCaSi']; ?>)</p>
                                </div>
                                <!-- Ẩn để tiện cho việt lấy nội sung thay cho main song -->
                                <div class="info-song-hidden-list" data-id_casi="<?php echo $row['id_casi']; ?>">
                                    <p class="nghesi-list"> <?php echo $row['ngheSi']; ?> </p>
                                    <p class="mota-list"> <?php echo $row['moTa']; ?></p>
                                </div>
                            </div>
                        </div>
                <?php
                    }
                }
                ?>

            </div>
        </div>
    </div>

    <div class="container-singer">
        <?php if ($singerInfo) { ?>
            <img src="<?php echo $singerInfo['linkAnh']; ?>" alt="<?php echo $singerInfo['tenCaSi']; ?>">
            <div class="container-singer-info">
                <h3>Thông tin ca sĩ</h3>
                <p><?php echo $singerInfo['tenCaSi']; ?></p>
            </div>
        <?php } else { ?>
            <p>Không có thông tin ca sĩ.</p>
        <?php }; ?>
    </div>

    <?php include 'player.php'; ?>
    <?php include 'footer.php'; ?>



    <script src="js/jsDetail.js"></script>

</body>

</html>