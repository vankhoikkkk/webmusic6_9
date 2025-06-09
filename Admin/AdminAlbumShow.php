<?php
include 'config/config.php';

$limit = 15;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
$offset = ($page - 1) * $limit;

// Lọc
$where = "";
$filter_type = isset($_GET['filter_type']) ? $_GET['filter_type'] : 'all';
$keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';

if (!empty($keyword)) {
    $keyword = $conn->real_escape_string($keyword);
    if ($filter_type == 'casi') {
        $where = "WHERE albumcasi.idcasi LIKE '%$keyword%'";
    } elseif ($filter_type == 'album') {
        $where = "WHERE albumcasi.id_album LIKE '%$keyword%'";
    }
}

// Tổng bản ghi
$total_sql = "SELECT COUNT(*) as total FROM albumcasi 
              JOIN casi ON albumcasi.id_casi = casi.id_casi 
              $where";
$total_result = $conn->query($total_sql);
$total_row = $total_result->fetch_assoc();
$total_records = $total_row['total'];
$total_pages = ceil($total_records / $limit);

// Truy vấn
$sql = "SELECT albumcasi.id_album, casi.tenCaSi, albumcasi.linkAnh 
        FROM albumcasi 
        JOIN casi ON albumcasi.id_casi = casi.id_casi 
        $where
        LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CssAdmin/Main_Form.css.?v=<?= time(); ?>">
    <link rel="stylesheet" href="CssAdmin/styles.css">
    <link rel="stylesheet" href="CssAdmin/IndexAdmin.css?v=<?= time(); ?>">
    <title>Main Form</title>
</head>

<body>


    <?php include 'headerAdmin.php'; ?>
    <div class="container-admin-left">
        <?php include 'sidebarAdmin.php'; ?>

        <div class="body-container">
            <h2 style="text-align: center">Album ca sĩ</h2>
            <div>
                <a href="add.php">
                    <button id="add_button"> + Thêm album </button>
                </a>
            </div>
            <!-- Thanh lọc -->
            <form method="GET" class="filter-form">
                <label for="filter_type">Lọc theo:</label>
                <select name="filter_type" id="filter_type">
                    <option value="all" <?= (!isset($_GET['filter_type']) || $_GET['filter_type'] == 'all') ? 'selected' : '' ?>>Tất cả</option>
                    <option value="tenCaSi" <?= (isset($_GET['filter_type']) && $_GET['filter_type'] == 'tenCaSi') ? 'selected' : '' ?>>Tên ca sĩ</option>
                    <option value="idAlbum" <?= (isset($_GET['filter_type']) && $_GET['filter_type'] == 'idAlbum') ? 'selected' : '' ?>>ID Album</option>
                </select>

                <input type="text" name="keyword" placeholder="Từ khóa tìm kiếm..." value="<?= isset($_GET['keyword']) ? htmlspecialchars($_GET['keyword']) : '' ?>">

                <button type="submit">Lọc</button>
            </form>

            <table>
                <tr>
                    <th>Id album</th>
                    <th>Tên ca sĩ</th>
                    <th>Ảnh</th>
                    <th colspan="2">Edit</th>
                </tr>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['id_album'] ?></td>
                        <td><?= htmlspecialchars($row['tenCaSi']) ?></td>
                        <td><img src="<?php echo"../".$row['linkAnh']; ?>" width="100"></td>
                        <td><a class="aa" href="AdminAblumEdit.php?id=<?= $row['id_album'] ?>">Sửa</a></td>
                        <td><a class="aa" href="AdminAblumDelete.php?id=<?= $row['id_album'] ?>">Xóa</a></td>
                    </tr>
                <?php endwhile; ?>
            </table>

            <!-- phân trang -->
            <?php if ($total_records > $limit): ?>
                <div class="pagination" style="text-align: center; margin-top: 20px;">
                    <?php if ($page > 1): ?>
                        <a href="?page=<?= $page - 1 ?>">&laquo; < </a>
                            <?php endif; ?>

                            <?php
                            $range = 2;
                            if ($page > ($range + 2)) {
                                echo "<a href='?page=1'>1</a> ";
                                echo "<span>...</span> ";
                            }

                            for ($i = max(1, $page - $range); $i <= min($total_pages, $page + $range); $i++) {
                                if ($i == $page) {
                                    echo "<strong>$i</strong> ";
                                } else {
                                    echo "<a href='?page=$i'>$i</a> ";
                                }
                            }

                            if ($page < $total_pages - $range - 1) {
                                echo "<span>...</span> ";
                                echo "<a href='?page=$total_pages'>$total_pages</a> ";
                            }
                            ?>

                            <?php if ($page < $total_pages): ?>
                                <a href="?page=<?= $page + 1 ?>"> > &raquo;</a>
                            <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php include 'footerAdmin.php'; ?>
</body>

</html>