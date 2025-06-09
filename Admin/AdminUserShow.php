<?php
// Kết nối DB
include '../DAO/AdminUserDao.php';
$user = new AdminUserDao();
$limit = 10;
$totalUser = $user->GetTotalUser();
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$total_page = ceil($totalUser / $limit);
if ($current_page > $total_page) {
    $current_page = $total_page;
} elseif ($current_page < 1) {
    $current_page = 1;
}
$start = ($current_page - 1) * $limit;
$result = $user->GetAllUser($start, $limit);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" href="CssAdmin/adminSong.css?v=<?= time(); ?>">
    <link rel="stylesheet" href="CssAdmin/IndexAdmin.css?v=<?= time(); ?>">
    <title>Music</title>
    <style>
        .page_singershow {
            padding-top: 70px;
        }

        .ds_casi {
            width: 1500px;
            table-layout: fixed;
            border-radius: 4px;
            border-collapse: collapse;
            margin: 10px auto;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 8px 12px;
            text-align: left;
            word-wrap: break-word;
        }

        td {
            width: 100px;
        }

        tr td a {
            color: white;
            background-color: rgb(142, 210, 41);
            font-size: 23px;
            padding: 5px 10px;
            border-radius: 4px;
            display: flex;
            justify-content: center;
        }

        .add_btn {
            position: fixed;
        }

        .add_btn a {
            float: right;
            background-color: rgb(142, 210, 41);
            padding: 10px 20px;
            border-radius: 5px;
            color: white;
            font-size: 40px;
        }

        .add_btn a:hover {
            background-color: green;
        }

        .page_body {
            padding: 70px;
        }

        .pagination {
            display: flex;
            justify-content: center;
            margin: 20px;
        }

        .pagination a {
            color: white;
            margin: 0 5px;
            padding: 8px 12px;
            background-color: rgb(102, 102, 102);
            border-radius: 5px;
        }

        .pagination span {
            margin: 0 5px;
            padding: 8px 12px;
            background-color: rgb(202, 202, 202);
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <?php include 'headerAdmin.php'; ?>
    <div class="container-admin-left">
        <?php include 'sidebarAdmin.php'; ?>
        <!-- Body -->
        <main>
            <div class="page_singershow">
                <div class="table_body">
                    <div class="add_btn">
                        <a href="../Admin/AdminUserAdd.php">ADD</a>
                    </div>
                    <table class="ds_casi">
                        <thead>
                            <tr>
                                <th>id_nguoidung</th>
                                <th>tenDangNhap</th>
                                <th>tenDayDu</th>
                                <th>gioiTinh</th>
                                <th>Email</th>
                                <th>matkhau</th>
                                <th>laAdmin</th>
                                <th>avatar</th>
                                <th>last_update_name</th>
                                <th colspan="2" style="text-align: center;">Tool</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($result && $result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "
                                    <tr>
                                        <td>" . $row['id_nguoidung'] . "</td>
                                        <td>" . $row['tenDangNhap'] . "</td>
                                        <td>" . $row['tenDayDu'] . "</td>
                                        <td>" . $row['gioiTinh'] . "</td>
                                        <td>" . $row['email'] . "</td>
                                        <td>" . $row['matkhau'] . "</td>
                                        <td>" . $row['laAdmin'] . "</td>
                                        <td><img src=" . $row['avatar'] . " width='50'></td>
                                        <td>" . $row['last_update_name'] . "</td>
                                        <td>
                                            <a href='AdminUserDelete.php?id_nguoidung=" . $row['id_nguoidung'] . "' onclick=\"return confirm('Bạn có chắc chắn muốn xóa ca sĩ này?');\">Delete</a>
                                        </td>
                                        <td>
                                            <a href='AdminUserEdit.php?id_nguoidung=" . $row['id_nguoidung'] . "'>Edit</a>
                                        </td>
                                    </tr>
                                ";
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="list_buttom">
                    <ul class="pagination">
                        <?php
                        if ($current_page > 1 && $total_page > 1) {
                            echo '<a href="AdminUserShow.php?page=' . ($current_page - 1) . '">Prev </a>';
                        }
                        for ($i = 1; $i <= $total_page; $i++) {
                            if ($i == $current_page) {
                                echo '<span>' . $i . '</span>';
                            } else {
                                echo '<a href="AdminUserShow.php?page=' . $i . '">' . $i . '</a>';
                            }
                        }
                        if ($current_page < $total_page && $total_page > 1) {
                            echo '<a href="AdminUserShow.php?page=' . ($current_page + 1) . '">Next </a>';
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </main>
    </div>
    <!-- Footer -->
    <?php include 'footerAdmin.php'; ?>
</body>

</html>