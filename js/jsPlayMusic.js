 // 1. Khai báo biến
  const audioPlayer = document.getElementById('audio');
  const songCards = document.querySelectorAll('.song-card');
  const imgScrThanhNhac = document.querySelector('.cover > img');
  const containerPlay = document.querySelector('.container-play');
  const playButton = document.getElementById("play");
  const duration = document.getElementById("duration");
  const current = document.getElementById("current");
  const progress = document.getElementById("progress");
  const volume = document.getElementById("volume");

  let currentCard = null;
  let currentIndex = 0;



  // 3. Xử lý phát/dừng nhạc
  function togglePlay(card, playButtonCard) {
    if (!audioPlayer.paused) {
      audioPlayer.pause();
      playButtonCard.className = 'bx bx-play-circle';
      playButton.innerHTML = "<i class='bx bx-play-circle'></i>";
    } else {
      audioPlayer.play();
      playButtonCard.className = 'bx bx-pause-circle';
      playButton.innerHTML = "<i class='bx bx-pause-circle'></i>";

    }
  }

  // 4. Hàm phát nhạc chính
  function playMusic(card) {
    // Reset trạng thái
    document.querySelectorAll('.song-card').forEach(c => c.classList.remove('playing'));

    // Lấy thông tin bài hát
    const audioSrc = card.getAttribute('data-audio');
    const currentImg = card.querySelector('img');
    const playButtonCard = card.querySelector('.play-overlay i');
    const songTitle = card.querySelector(".baihat").textContent;
    const artistName = card.querySelector(".casi").textContent;

    // Thêm class playing vào card được chọn
    card.classList.add('playing');
    // Cập nhật UI
    document.getElementById('song-name').textContent = songTitle;
    document.getElementById('artist-name').textContent = artistName;
    containerPlay.classList.add('show');
    imgScrThanhNhac.src = currentImg.src;

    // Phát nhạc
    currentCard = card;
    audioPlayer.src = audioSrc;
    audioPlayer.currentTime = 0;
    audioPlayer.play();

    // Cập nhật icon
    document.querySelectorAll('.play-overlay i')
      .forEach(icon => icon.className = 'bx bx-play-circle');
    playButtonCard.className = 'bx bx-pause-circle';
    playButton.innerHTML = "<i class='bx bx-pause-circle'></i>";

    // tăng lượt nghe
    const baihatid = card.getAttribute('data-id');
    fetch('json_tang_luot_nghe.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'id_baihat=' + baihatid
      })
      .then(response => response.json()) // Thay đổi từ .text() thành .json()
      .then(data => {
        if (data.success) {
          console.log("Tăng lượt nghe thành công:", data.message);
        } else {
          console.error("Lỗi:", data.message);
        }
      })
      .catch(error => {
        console.error("Lỗi khi tăng lượt nghe:", error);
      });

    // Lưu lịch sử nghe nhạc
    fetch('json_check_login.php', {
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded',
        }
      }).then(response => response.json())
      .then(data => {
        if (!data.isLoggedIn) {
          alert('Vui lòng đăng nhập để lưu lịch sử nghe nhạc');
          return;
        } else {
          fetch('json_su_ly_luu_ls.php', {
              method: 'POST',
              headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
              },
              body: 'id_baihat=' + baihatid
            }).then(res => res.json())
            .then(data => {
              if (data.success) {
                console.log("Lưu lịch sử nghe nhạc thành công:", data.message);
              } else {
                console.error("Lỗi khi lưu lịch sử nghe nhạc:", data.message);
              }
            }).catch(error => {
              console.error("Lỗi khi lưu lịch sử nghe nhạc:", error);
            });

        }
      }).catch(error => {
        console.error("Lỗi khi kiểm tra đăng nhập:", error);
      });
  }

  // 5. Xử lý sự kiện
  function initEventListeners() {
    // Click vào card
    songCards.forEach((card, index) => {
      const playOverlay = card.querySelector('.play-overlay');
      const saveButton = card.querySelector('.save-song');
      saveButton.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopPropagation();

        fetch('json_check_login.php')
          .then(response => response.json())
          .then(data => {
            if (!data.isLoggedIn) {
              alert('Vui lòng đăng nhập để lưu bài hát');
              return;
            }

            const baihatid = card.getAttribute('data-id');
            const icon = saveButton.querySelector('i');
            if (icon.classList.contains('active')) {
              icon.classList.remove('active');
              console.log("đã xoá nút lưu.");
            } else {
              icon.classList.add('active');
              console.log("đã thêm nút lưu lưu.");
            }

            fetch('json_su_ly_luu_nhac.php', {
                method: 'POST',
                headers: {
                  'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'id_baihat=' + baihatid
              })
              .then(response => response.json()) // Thay đổi từ .text() thành .json()
              .then(data => {
                if (data.success) {
                  console.log("kết quả:", data.message);

                } else {
                  console.error("Lỗi:", data.message);
                }
              })
              .catch(error => {
                console.error("Lỗi khi luu bai hat:", error);
              });
          });

      });



      playOverlay.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopPropagation();

        if (currentCard === card) {
          togglePlay(card, playOverlay.querySelector('i'));
          return;
        }
        currentIndex = index;
        playMusic(card);
      });

      card.addEventListener('click', () => {
        window.location.href = `DetailCategory.php?id_baihat=${card.getAttribute('data-id')}`;
      });
    });

    // Điều khiển phát nhạc
    playButton.addEventListener('click', () => {
      if (!currentCard) return;
      togglePlay(currentCard, currentCard.querySelector('.play-overlay i'));
    });

    // Next/Prev
    document.getElementById('prev').addEventListener('click', () => {
      if (!currentCard) return;
      currentIndex = (currentIndex - 1 + songCards.length) % songCards.length;
      playMusic(Array.from(songCards)[currentIndex]);
    });

    document.getElementById('next').addEventListener('click', () => {
      if (!currentCard) return;
      currentIndex = (currentIndex + 1) % songCards.length;
      playMusic(Array.from(songCards)[currentIndex]);
    });
  }

  // 6. Khởi tạo player
  function initPlayer() {
    audioPlayer.addEventListener('ended', () => {
      currentIndex = (currentIndex + 1) % songCards.length;
      playMusic(Array.from(songCards)[currentIndex]);
    });

    audioPlayer.addEventListener('loadedmetadata', () => {
      duration.textContent = formatTime(audioPlayer.duration);
    });

    audioPlayer.addEventListener('timeupdate', () => {
      current.textContent = formatTime(audioPlayer.currentTime);
      progress.value = (audioPlayer.currentTime / audioPlayer.duration) * 100;
    });

    progress.addEventListener("input", () => {
      audioPlayer.currentTime = (progress.value / 100) * audioPlayer.duration;
    });

    volume.addEventListener("input", () => {
      audioPlayer.volume = volume.value;
    });
  }

  // 7. Helpers
  function formatTime(seconds) {
    const minutes = Math.floor(seconds / 60);
    const secs = Math.floor(seconds % 60);
    return `${minutes < 10 ? '0' + minutes : minutes}:${secs < 10 ? '0' + secs : secs}`;
  }

  // 8. Khởi tạo
  initEventListeners();
  initPlayer();