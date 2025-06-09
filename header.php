<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./CSS/header.css?v= <?=time(); ?>">
    <link rel="stylesheet" href="./CSS/footer.css?v= <?=time(); ?>">
    <title>Header</title>
</head>
<body>
<div class="Header">
      <!-- Logo -->
      <div class="Logo">
        <a href="index.php">
          <img src="./image/Icon/Icon_logo.png" alt="" />
        </a>
      </div>
      <!-- Main menu -->
      <div class="Menu">
        <ul>
          <li>
            <a href="TrangChu.php">Home</a>
          </li>
          <li>
            <a href="Category.php">Thể loại</a>
          </li>
          <li>
            <a href="nghesi.php">Album</a>
          </li>
        </ul>
      </div>
      <!-- Others option -->
      <div class="Other">
        <ul>
          <li>
            <div class="search-box">
              <form action="search.php" method="GET">
                <input type="text" name="query" placeholder="Tìm bài hát" autocomplete="off" id="box-form">
                <button type="submit">Tìm kiếm</button>
              </form>
                <div class="recent-searches">
                  <p><strong>Tìm kiếm gần đây:</strong></p>
                    <?php
                    $history = $_SESSION['search_history'] ?? [];
                    if ($history):
                      foreach ($history as $keyword): ?>
                        <a href="search.php?query=<?= urlencode($keyword) ?>" class="search-tag">
                        <?= htmlspecialchars($keyword) ?>
                          </a>
                        <?php endforeach;
                      else: ?>
                        <p>Chưa có tìm kiếm nào.</p>
                    <?php endif; ?>
            </div>
          </li>
          <?php include "./xuli_saulogin.php"; ?>
        </ul>
      </div>
    </div>
</body>
</html>