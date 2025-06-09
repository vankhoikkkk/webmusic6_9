<?php
session_start();
include 'DAO/CategoryDAO.php';
include 'DAO/LuuBaiHatNguoiDungDAO.php';
?>


<?php

// Kiểm tra và khởi tạo biến
$id_nguoidung = $_SESSION['id_nguoidung'] ?? null;
$ds_baihat_nguoidung = [];

// Chỉ lấy danh sách bài hát đã lưu nếu user đã đăng nhập
if ($id_nguoidung) {
    $luuBaiHat = new LuuBaiHatNguoiDung();
    $result_nguoidung = $luuBaiHat->BaiHatDaLuuOfID($id_nguoidung);
    
    if ($result_nguoidung) {
        while ($row1 = $result_nguoidung->fetch_assoc()) {
            $ds_baihat_nguoidung[] = $row1['id_baihat'];
        }
    }
}


$listMusic = new CategoryDAO();
$result_tre = $listMusic->getAllMusicOfGengerTOP('Nhạc Trẻ');
$result_Rap = $listMusic->getAllMusicOfGengerTOP('Nhạc Rap');
$result_Au = $listMusic->getAllMusicOfGengerTOP('Nhạc Âu');
$result_Trung = $listMusic->getAllMusicOfGengerTOP('Nhạc Trung');
$result_Do = $listMusic->getAllMusicOfGengerTOP('Nhạc Đỏ');

?>


<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Thư Viện Nhạc</title>
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="CSS/Category.css">
  <link rel="stylesheet" href="CSS/playMusic.css">
  <link rel="stylesheet" href="CSS/songCard.css">
  <link rel="stylesheet" href="CSS/search.css">
  <link rel="stylesheet" href="CSS/header.css">
  <link rel="stylesheet" href="CSS/footer.css">
</head>
<style>
  .save-song {
    position: relative;
    bottom: 10px;
    right: 10px;
    color: #fff;
    cursor: pointer;
    transition: color 0.3s ease;
    width: 30px;
    height: 30px;

  }

  .save-song>i {
    font-size: 24px;
    color: aqua;
  }

  .save-song>i.active {
    color: red;
  }
</style>



<!----------------------------------- danh sách nhạc --------------------------------------------->

<body>
  <?php include 'header.php' ?>
  <?php include 'slide.php' ?>
  <?php include 'V_headerCategory.php' ?>
  <div class="container-list-hot">

    <!-- NHẠC TRẺ VIỆT NAM -->
    <div class="list-music-top">
      <div class="hot-title">🎧 Top Nhạc Trẻ</div>
      <div class="hot-songs">
        <?php
        if ($result_tre) {
          while ($row = $result_tre->fetch_assoc()) {
            // var_dump($_SESSION['id_nguoidung']);
        ?>
            <div class="song-card" data-audio="<?php echo $row['linknhac']; ?>" data-id="<?php echo $row['id_baihat']; ?>">
              <div class="play-overlay">
                <i class='bx bx-play-circle'></i>
              </div>
              <img src="<?php echo $row['album']; ?>" alt="Song">
              <div class="song-info">
                <p class="baihat"><?php echo $row['tenbaihat']; ?></p>
                <p class="casi">(<?php echo $row['tenCaSi']; ?>)</p>
              </div>
              <div class="save-song" data-id="<?php echo $row['id_baihat']; ?>">
                <i class='<?php if (in_array($row['id_baihat'], $ds_baihat_nguoidung)) {
                            echo "active";
                          } else {
                            echo "";
                          }
                          ?>  bx bx-heart'></i>
              </div>
            </div>
        <?php
          }
        } else {
          echo "<p>Không có bài hát nào.</p>";
        }
        ?>
      </div>
    </div>

    <!-- NHẠC RAP VIỆT -->
    <div class="list-music-top">
      <div class="hot-title"><i class='bx bxl-unity'></i> Top Nhạc Rap</div>
      <div class="hot-songs">
        <?php
        if ($result_Rap) {
          while ($row = $result_Rap->fetch_assoc()) {
        ?>
            <div class="song-card" data-audio="<?php echo $row['linknhac']; ?>" data-id="<?php echo $row['id_baihat']; ?>">
              <div class="play-overlay">
                <i class='bx bx-play-circle'></i>
              </div>
              <img src="<?php echo $row['album']; ?>" alt="Song">
              <div class="song-info">
                <p class="baihat"><?php echo $row['tenbaihat']; ?></p>
                <p class="casi">(<?php echo $row['tenCaSi']; ?>)</p>
              </div>
                <div class="save-song" data-id="<?php echo $row['id_baihat']; ?>">
                <i class='<?php if (in_array($row['id_baihat'], $ds_baihat_nguoidung)) {
                            echo "active";
                          } else {
                            echo "";
                          }
                          ?>  bx bx-heart'></i>
              </div>
            </div>
        <?php
          }
        } else {
          echo "<p>Không có bài hát nào.</p>";
        }
        ?>
      </div>
    </div>

    <!-- NHẠC ÂU -->
    <div class="list-music-top">
      <div class="hot-title">🎧 Top Nhạc Âu</div>
      <div class="hot-songs">
        <?php
        if ($result_Au) {
          while ($row = $result_Au->fetch_assoc()) {
        ?>
            <div class="song-card" data-audio="<?php echo $row['linknhac']; ?>" data-id="<?php echo $row['id_baihat']; ?>">
              <div class="play-overlay">
                <i class='bx bx-play-circle'></i>
              </div>
              <img src="<?php echo $row['album']; ?>" alt="Song">
              <div class="song-info">
                <p class="baihat"><?php echo $row['tenbaihat']; ?></p>
                <p class="casi">(<?php echo $row['tenCaSi']; ?>)</p>
              </div>
                <div class="save-song" data-id="<?php echo $row['id_baihat']; ?>">
                <i class='<?php if (in_array($row['id_baihat'], $ds_baihat_nguoidung)) {
                            echo "active";
                          } else {
                            echo "";
                          }
                          ?>  bx bx-heart'></i>
              </div>
            </div>
        <?php
          }
        } else {
          echo "<p>Không có bài hát nào.</p>";
        }
        ?>
      </div>
    </div>

    <!-- NHẠC TRUNG QUỐC -->
    <div class="list-music-top">
      <div class="hot-title">🎧 Top Nhạc Trung</div>
      <div class="hot-songs">
        <?php
        if ($result_Trung) {
          while ($row = $result_Trung->fetch_assoc()) {
        ?>
            <div class="song-card" data-audio="<?php echo $row['linknhac']; ?>" data-id="<?php echo $row['id_baihat']; ?>">
              <div class="play-overlay">
                <i class='bx bx-play-circle'></i>
              </div>
              <img src="<?php echo $row['album']; ?>" alt="Song">
              <div class="song-info">
                <p class="baihat"><?php echo $row['tenbaihat']; ?></p>
                <p class="casi">(<?php echo $row['tenCaSi']; ?>)</p>
              </div>
                 <div class="save-song" data-id="<?php echo $row['id_baihat']; ?>">
                <i class='<?php if (in_array($row['id_baihat'], $ds_baihat_nguoidung)) {
                            echo "active";
                          } else {
                            echo "";
                          }
                          ?>  bx bx-heart'></i>
              </div>
            </div>
        <?php
          }
        } else {
          echo "<p>Không có bài hát nào.</p>";
        }
        ?>
      </div>
    </div>
    <!-- NHẠC ĐỎ VIỆT NAM -->
    <div class="list-music-top">
      <div class="hot-title">🎧 Top Nhạc Đỏ</div>
      <div class="hot-songs">
        <?php
        if ($result_Do) {
          while ($row = $result_Do->fetch_assoc()) {
        ?>
            <div class="song-card" data-audio="<?php echo $row['linknhac']; ?>" data-id="<?php echo $row['id_baihat']; ?>">
              <div class="play-overlay">
                <i class='bx bx-play-circle'></i>
              </div>
              <img src="<?php echo $row['album']; ?>" alt="Song">
              <div class="song-info">
                <p class="baihat"><?php echo $row['tenbaihat']; ?></p>
                <p class="casi">(<?php echo $row['tenCaSi']; ?>)</p>
              </div>
                <div class="save-song" data-id="<?php echo $row['id_baihat']; ?>">
                <i class='<?php if (in_array($row['id_baihat'], $ds_baihat_nguoidung)) {
                            echo "active";
                          } else {
                            echo "";
                          }
                          ?>  bx bx-heart'></i>
              </div>
            </div>
        <?php
          }
        } else {
          echo "<p>Không có bài hát nào.</p>";
        }
        ?>
      </div>
    </div>

  </div>

  <?php include 'player.php' ?>
  <?php include 'footer.php' ?>
</body>

<script src="js/jsPlayMusic.js">
  // 1. Khai báo biến
  // const audioPlayer = document.getElementById('audio');
  // const songCards = document.querySelectorAll('.song-card');
  // const imgScrThanhNhac = document.querySelector('.cover > img');
  // const containerPlay = document.querySelector('.container-play');
  // const playButton = document.getElementById("play");
  // const duration = document.getElementById("duration");
  // const current = document.getElementById("current");
  // const progress = document.getElementById("progress");
  // const volume = document.getElementById("volume");

  // let currentCard = null;
  // let currentIndex = 0;



  // // 3. Xử lý phát/dừng nhạc
  // function togglePlay(card, playButtonCard) {
  //   if (!audioPlayer.paused) {
  //     audioPlayer.pause();
  //     playButtonCard.className = 'bx bx-play-circle';
  //     playButton.innerHTML = "<i class='bx bx-play-circle'></i>";
  //   } else {
  //     audioPlayer.play();
  //     playButtonCard.className = 'bx bx-pause-circle';
  //     playButton.innerHTML = "<i class='bx bx-pause-circle'></i>";

  //   }
  // }

  // // 4. Hàm phát nhạc chính
  // function playMusic(card) {
  //   // Reset trạng thái
  //   document.querySelectorAll('.song-card').forEach(c => c.classList.remove('playing'));

  //   // Lấy thông tin bài hát
  //   const audioSrc = card.getAttribute('data-audio');
  //   const currentImg = card.querySelector('img');
  //   const playButtonCard = card.querySelector('.play-overlay i');
  //   const songTitle = card.querySelector(".baihat").textContent;
  //   const artistName = card.querySelector(".casi").textContent;

  //   // Thêm class playing vào card được chọn
  //   card.classList.add('playing');
  //   // Cập nhật UI
  //   document.getElementById('song-name').textContent = songTitle;
  //   document.getElementById('artist-name').textContent = artistName;
  //   containerPlay.classList.add('show');
  //   imgScrThanhNhac.src = currentImg.src;

  //   // Phát nhạc
  //   currentCard = card;
  //   audioPlayer.src = audioSrc;
  //   audioPlayer.currentTime = 0;
  //   audioPlayer.play();

  //   // Cập nhật icon
  //   document.querySelectorAll('.play-overlay i')
  //     .forEach(icon => icon.className = 'bx bx-play-circle');
  //   playButtonCard.className = 'bx bx-pause-circle';
  //   playButton.innerHTML = "<i class='bx bx-pause-circle'></i>";

  //   // tăng lượt nghe
  //   const baihatid = card.getAttribute('data-id');
  //   fetch('json_tang_luot_nghe.php', {
  //       method: 'POST',
  //       headers: {
  //         'Content-Type': 'application/x-www-form-urlencoded',
  //       },
  //       body: 'id_baihat=' + baihatid
  //     })
  //     .then(response => response.json()) // Thay đổi từ .text() thành .json()
  //     .then(data => {
  //       if (data.success) {
  //         console.log("Tăng lượt nghe thành công:", data.message);
  //       } else {
  //         console.error("Lỗi:", data.message);
  //       }
  //     })
  //     .catch(error => {
  //       console.error("Lỗi khi tăng lượt nghe:", error);
  //     });

  //   // Lưu lịch sử nghe nhạc
  //   fetch('json_check_login.php', {
  //       headers: {
  //         'Content-Type': 'application/x-www-form-urlencoded',
  //       }
  //     }).then(response => response.json())
  //     .then(data => {
  //       if (!data.isLoggedIn) {
  //         alert('Vui lòng đăng nhập để lưu lịch sử nghe nhạc');
  //         return;
  //       } else {
  //         fetch('json_su_ly_luu_ls.php', {
  //             method: 'POST',
  //             headers: {
  //               'Content-Type': 'application/x-www-form-urlencoded',
  //             },
  //             body: 'id_baihat=' + baihatid
  //           }).then(res => res.json())
  //           .then(data => {
  //             if (data.success) {
  //               console.log("Lưu lịch sử nghe nhạc thành công:", data.message);
  //             } else {
  //               console.error("Lỗi khi lưu lịch sử nghe nhạc:", data.message);
  //             }
  //           }).catch(error => {
  //             console.error("Lỗi khi lưu lịch sử nghe nhạc:", error);
  //           });

  //       }
  //     }).catch(error => {
  //       console.error("Lỗi khi kiểm tra đăng nhập:", error);
  //     });
  // }

  // // 5. Xử lý sự kiện
  // function initEventListeners() {
  //   // Click vào card
  //   songCards.forEach((card, index) => {
  //     const playOverlay = card.querySelector('.play-overlay');
  //     const saveButton = card.querySelector('.save-song');
  //     saveButton.addEventListener('click', (e) => {
  //       e.preventDefault();
  //       e.stopPropagation();

  //       fetch('json_check_login.php')
  //         .then(response => response.json())
  //         .then(data => {
  //           if (!data.isLoggedIn) {
  //             alert('Vui lòng đăng nhập để lưu bài hát');
  //             return;
  //           }

  //           const baihatid = card.getAttribute('data-id');
  //           const icon = saveButton.querySelector('i');
  //           if (icon.classList.contains('active')) {
  //             icon.classList.remove('active');
  //             console.log("đã xoá nút lưu.");
  //           } else {
  //             icon.classList.add('active');
  //             console.log("đã thêm nút lưu lưu.");
  //           }

  //           fetch('json_su_ly_luu_nhac.php', {
  //               method: 'POST',
  //               headers: {
  //                 'Content-Type': 'application/x-www-form-urlencoded',
  //               },
  //               body: 'id_baihat=' + baihatid
  //             })
  //             .then(response => response.json()) // Thay đổi từ .text() thành .json()
  //             .then(data => {
  //               if (data.success) {
  //                 console.log("kết quả:", data.message);

  //               } else {
  //                 console.error("Lỗi:", data.message);
  //               }
  //             })
  //             .catch(error => {
  //               console.error("Lỗi khi luu bai hat:", error);
  //             });
  //         });

  //     });



  //     playOverlay.addEventListener('click', (e) => {
  //       e.preventDefault();
  //       e.stopPropagation();

  //       if (currentCard === card) {
  //         togglePlay(card, playOverlay.querySelector('i'));
  //         return;
  //       }
  //       currentIndex = index;
  //       playMusic(card);
  //     });

  //     card.addEventListener('click', () => {
  //       window.location.href = `DetailCategory copy.php?id_baihat=${card.getAttribute('data-id')}`;
  //     });
  //   });

  //   // Điều khiển phát nhạc
  //   playButton.addEventListener('click', () => {
  //     if (!currentCard) return;
  //     togglePlay(currentCard, currentCard.querySelector('.play-overlay i'));
  //   });

  //   // Next/Prev
  //   document.getElementById('prev').addEventListener('click', () => {
  //     if (!currentCard) return;
  //     currentIndex = (currentIndex - 1 + songCards.length) % songCards.length;
  //     playMusic(Array.from(songCards)[currentIndex]);
  //   });

  //   document.getElementById('next').addEventListener('click', () => {
  //     if (!currentCard) return;
  //     currentIndex = (currentIndex + 1) % songCards.length;
  //     playMusic(Array.from(songCards)[currentIndex]);
  //   });
  // }

  // // 6. Khởi tạo player
  // function initPlayer() {
  //   audioPlayer.addEventListener('ended', () => {
  //     currentIndex = (currentIndex + 1) % songCards.length;
  //     playMusic(Array.from(songCards)[currentIndex]);
  //   });

  //   audioPlayer.addEventListener('loadedmetadata', () => {
  //     duration.textContent = formatTime(audioPlayer.duration);
  //   });

  //   audioPlayer.addEventListener('timeupdate', () => {
  //     current.textContent = formatTime(audioPlayer.currentTime);
  //     progress.value = (audioPlayer.currentTime / audioPlayer.duration) * 100;
  //   });

  //   progress.addEventListener("input", () => {
  //     audioPlayer.currentTime = (progress.value / 100) * audioPlayer.duration;
  //   });

  //   volume.addEventListener("input", () => {
  //     audioPlayer.volume = volume.value;
  //   });
  // }

  // // 7. Helpers
  // function formatTime(seconds) {
  //   const minutes = Math.floor(seconds / 60);
  //   const secs = Math.floor(seconds % 60);
  //   return `${minutes < 10 ? '0' + minutes : minutes}:${secs < 10 ? '0' + secs : secs}`;
  // }

  // // 8. Khởi tạo
  // initEventListeners();
  // initPlayer();
</script>


</html>