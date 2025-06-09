<?php
include '../DAO/AdminUserDao.php';
$user = new AdminUserDAO();
if (isset($_GET['id_nguoidung'])) {
    $id_nguoidung = $_GET['id_nguoidung'];
    $result_user = $user->GetUserId($id_nguoidung);
    if (!$result_user) {
        echo "Không tìm thấy người dùng...";
        exit();
    }
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tenDangNhap = $_POST['tenDangNhap'];
    $tenDayDu = $_POST['tenDayDu'];
    $gioiTinh = $_POST['gioiTinh'];
    $email = $_POST['email'];
    $matkhau = $_POST['matkhau'];
    $laAdmin = isset($_POST['laAdmin']) ? 1 : 0;
    $target_dir1 = "./Avatar_User/";
    $target_dir2 = "/Avatar_User";
    $link = basename($_FILES["avatar"]["name"]);
    $target_file = $target_dir2 . $link;
    move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file);
    $avatar = $target_dir1 . $link;
    $update = $user->UpdateUserById(
        $id_nguoidung,
        $tenDangNhap,
        $tenDayDu,
        $gioiTinh,
        $email,
        $matkhau,
        $laAdmin,
        $avatar
    );
    if ($update) { ?>
        <script>
            alert('Thêm ca sĩ thành công!');
        </script>";
<?php header("Location: AdminUserShow.php");
        exit();
    } else {
        echo "Thêm bài hát không thành công!!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CssAdmin/adminSong.css?v=<?= time(); ?>">
    <link rel="stylesheet" href="CssAdmin/IndexAdmin.css?v=<?= time(); ?>">
    <title>Thêm Ca Sĩ</title>
    <style>
        .page_body_edit {
            padding-top: 120px;
            display: flex;
            justify-content: center;
            padding-bottom: 170px;
        }

        .form_casi {
            background: linear-gradient(135deg, deepskyblue, #161b81);
            border-radius: 8px;
            padding: 20px;
            width: 600px;
            height: 650px;
            box-shadow: 0 8px 20px black;
        }

        #casi_name {
            margin-top: 10px;
            border-radius: 4px;
            width: 450px;
            font-size: 23px;
        }

        #tieusu {
            margin-top: 10px;
            border-radius: 4px;
            width: 450px;
            height: 300px;
            font-size: 23px;
        }

        .form_casi h2 {
            text-align: center;
            text-transform: uppercase;
            color: white;
        }

        .form_casi input {
            margin-bottom: 10px;
        }

        #submit_btn {
            float: right;
            padding: 10px 20px;
            background-color: rgb(142, 210, 41);
            border-radius: 5px;
            color: white;
            cursor: pointer;
            margin-top: 10px;
            margin-bottom: 10px;
            font-size: 23px;
        }
    </style>
</head>

<body>
    <?php include 'headerAdmin.php'; ?>
    <div class="container-admin-left">
        <?php include 'sidebarAdmin.php'; ?>
        <!-- Body -->
        <main>
            <div class="page_body_edit">
                <form method="POST" class="form_casi" enctype="multipart/form-data">
                    <h2>Chỉnh sửa Ca Sĩ</h2>
                    <br>
                    <label for=""><strong>Tên đăng nhập</strong></label>
                    <br>
                    <input type="text" name="tenDangNhap" id="casi_name" value="<?= htmlspecialchars($result_user['tenDangNhap']) ?>" required>
                    <br>
                    <label for=""><strong>Tên đầy đủ</strong></label>
                    <br>
                    <input type="text" name="tenDayDu" id="casi_name" value="<?= htmlspecialchars($result_user['tenDayDu']) ?>" required>
                    <br>
                    <label for=""><strong>Giới tính</strong></label>
                    <br>
                    <input type="text" name="gioiTinh" id="casi_name" value="<?= htmlspecialchars($result_user['gioiTinh']) ?>" required>
                    <br>
                    <label for=""><strong>Email</strong></label>
                    <br>
                    <input type="text" name="email" id="casi_name" value="<?= htmlspecialchars($result_user['email']) ?>" required>
                    <br>
                    <label for=""><strong>Mật Khẩu</strong></label>
                    <br>
                    <input type="text" name="matkhau" id="casi_name" value="<?= htmlspecialchars($result_user['matkhau']) ?>" required>
                    <br>
                    <label for=""><strong>Là Admin</strong></label>
                    <br>
                    <input type="checkbox" name="laAdmin" id="casi_name" value="1" <?= $result_user['laAdmin'] ? 'checked' : '' ?>>
                    <br>
                    <label for=""><strong>Avatar cũ</strong></label>
                    <img src="<?php echo $result_user['avatar'] ?>" alt="anh" width="50">
                    <br>
                    <label for=""><strong>Avatar</strong></label>
                    <br>
                    <input type="file" name="avatar" id="casi_name" value="<?= htmlspecialchars($result_user['avatar']) ?>" required>
                    <br>
                    <input type="submit" id="submit_btn" value="UPDATE">
                </form>
            </div>
        </main>
    </div>
    <!-- footer -->
    <?php include('footerAdmin.php') ?>
</body>

</html>