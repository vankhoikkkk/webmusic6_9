   // Khai báo biến
        const audioPlayer = document.getElementById('audio');
        const songCards = document.querySelectorAll('.song-card');
        const imgScrThanhNhac = document.querySelector('.cover > img');
        const containerPlay = document.querySelector('.container-play');
        const playButton = document.getElementById("play");
        const duration = document.getElementById("duration");
        const current = document.getElementById("current");
        const progress = document.getElementById("progress");
        const volume = document.getElementById("volume");
        const volumeIcon = document.getElementById("volume-icon");

        let currentAudioSrc = '';
        let currentTime = 0;
        let currentCard = null;
        let currentIndex = 0;

        // Hàm phát nhạc chính
        function playMusic(card) {
            // console.log(card);
            // Xóa class playing từ tất cả card 
            document.querySelectorAll('.song-card').forEach(c => {
                c.classList.remove('playing');
            });

            const audioSrc = card.getAttribute('data-audio');
            const currentImg = card.querySelector('img');
            const playButtonCard = card.querySelector('.play-overlay i');
            const mainPlayOverlay = document.querySelector('.main-song .play-overlay i');
            const songTitle = card.querySelector(".baihat").textContent;
            const artistName = card.querySelector(".casi").textContent;

            // Thêm class playing vào card được chọn
            card.classList.add('playing');

            // Cập nhật UI
            document.getElementById('song-name').textContent = songTitle;
            document.getElementById('artist-name').textContent = artistName;
            containerPlay.classList.add('show');
            imgScrThanhNhac.src = currentImg.src;

            if (card.closest('.song-list')) {
                updateMainSong(card);
            }


            // Phát nhạc
            currentCard = card;
            audioPlayer.src = audioSrc;
            audioPlayer.currentTime = 0;
            audioPlayer.play();

            // Cập nhật icon
            document.querySelectorAll('.play-overlay i').forEach(icon => {
                icon.className = 'bx bx-play-circle';
            });
            mainPlayOverlay.className = 'bx bx-pause-circle';
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

        // Event listeners cho card
        songCards.forEach((card, index) => {
            const playOverlay = card.querySelector('.play-overlay');
            const mainPlayOverlay = document.querySelector('.main-song .play-overlay');

            // Click vào nút play trên card
            playOverlay.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                // Kiểm tra nếu card này đang phát nhạc
                if (currentCard !== null) {
                    if (currentCard.dataset.audio === card.dataset.audio) {
                        console.log('Đang phát bài này');
                        // Toggle play/pause mà không xóa class playing 
                        if (!audioPlayer.paused) {
                            console.log('dừng lại');
                            audioPlayer.pause();
                            playOverlay.querySelector('i').className = 'bx bx-play-circle';
                            mainPlayOverlay.querySelector('i').className = 'bx bx-play-circle';
                            playButton.innerHTML = "<i class='bx bx-play-circle'></i>";
                            card.classList.add('playing');
                        } else {
                            console.log('phat lại');
                            audioPlayer.play();
                            playOverlay.querySelector('i').className = 'bx bx-pause-circle';
                            mainPlayOverlay.querySelector('i').className = 'bx bx-pause-circle';
                            playButton.innerHTML = "<i class='bx bx-pause-circle'></i>";
                            card.classList.add('playing');
                        }
                        return;
                    }
                }
                currentIndex = index;
                playMusic(card);
            });
        });

        // Xử lý điều khiển phát nhạc
        playButton.addEventListener('click', () => {
            if (!currentCard) return;
            const playButtonCard = currentCard.querySelector('.play-overlay i');
            const mainPlayOverlay = document.querySelector('.main-song .play-overlay i');

            if (audioPlayer.paused) {
                audioPlayer.play();
                playButtonCard.className = 'bx bx-pause-circle';
                mainPlayOverlay.className = 'bx bx-pause-circle';
                playButton.innerHTML = "<i class='bx bx-pause-circle'></i>";
            } else {
                audioPlayer.pause();
                mainPlayOverlay.className = 'bx bx-play-circle';
                playButtonCard.className = 'bx bx-play-circle';
                playButton.innerHTML = "<i class='bx bx-play-circle'></i>";
            }
        });

        // Xử lý next/prev
        document.getElementById('prev').addEventListener('click', () => {
            // chuyển list songCard thành mảng
            const cards = Array.from(songCards);
            // kiểm tra nếu không có bài hát nào đang phát thì không làm gì cả
            if (!currentCard) return;
            // nếu có thì chuyển index về bài trước đó
            currentIndex = (currentIndex - 1 + cards.length) % cards.length;
            playMusic(cards[currentIndex]);
        });

        document.getElementById('next').addEventListener('click', () => {
            const cards = Array.from(songCards);
            if (!currentCard) return;
            currentIndex = (currentIndex + 1) % cards.length;
            playMusic(cards[currentIndex]);
        });


        // Xử lý audio events
        // 6. Khởi tạo player
        function initPlayer() {
            audioPlayer.addEventListener('ended', () => {
                const cards = Array.from(songCards);
                if (!currentCard) return;
                currentIndex = (currentIndex + 1) % cards.length;
                playMusic(cards[currentIndex]);
            });

            audioPlayer.addEventListener('loadedmetadata', () => {
                duration.textContent = formatTime(audioPlayer.duration);
            });

            audioPlayer.addEventListener('timeupdate', () => {
                current.textContent = formatTime(audioPlayer.currentTime);
                progress.value = (audioPlayer.currentTime / audioPlayer.duration) * 100;
            });

            // Xử lý thanh progress và volume
            progress.addEventListener("input", () => {
                audioPlayer.currentTime = (progress.value / 100) * audioPlayer.duration;
            });

            volume.addEventListener("input", () => {
                audioPlayer.volume = volume.value;
            });
        }


        // Helper functions
        function formatTime(seconds) {
            const minutes = Math.floor(seconds / 60);
            const secs = Math.floor(seconds % 60);
            return `${minutes < 10 ? '0' + minutes : minutes}:${secs < 10 ? '0' + secs : secs}`;
        }

        function updateMainSong(card) {
            const mainSong = document.querySelector('.main-song .song-card');
            const mainSongInfo = document.querySelector('.song-info.show-main');
            const mainSongInfoMota = document.querySelector('.info-song');

            // Cập nhật thông tin cho main-song card
            mainSong.setAttribute('data-audio', card.getAttribute('data-audio'));
            mainSong.querySelector('img').src = card.querySelector('img').src;
            mainSong.querySelector('.baihat').textContent = card.querySelector('.baihat').textContent;
            mainSong.querySelector('.casi').textContent = card.querySelector('.casi').textContent;
            mainSongInfo.setAttribute('data-id_casi', card.querySelector('.info-song-hidden-list').getAttribute('data-id_casi'));


            // Cập nhật thông tin hiển thị bên dưới
            mainSongInfo.querySelector('.show-main-text').textContent = card.querySelector('.baihat').textContent;
            mainSongInfo.querySelector('.show-main-text.casi').textContent = card.querySelector('.casi').textContent;

            // thông tin mô tả
            mainSongInfoMota.querySelector('.nghesi').textContent = card.querySelector('.nghesi-list').textContent;
            mainSongInfoMota.querySelector('.mota').textContent = card.querySelector('.mota-list').textContent;
        }
        initPlayer();