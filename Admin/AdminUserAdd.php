<?php
    include '../DAO/AdminUserDao.php';
    $user = new AdminUserDAO();
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
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
        $upLoad = $user->AddUser($tenDangNhap,$tenDayDu, $gioiTinh, 
        $email, $matkhau, $laAdmin, $avatar);
        if ($upLoad){?>
            <script>
                    alert('Thêm người dùng thành công!');
            </script>
            <?php
            header("Location: AdminUserShow.php");
            exit();
        }
        else {
            echo "Thêm người dùng không thành công!!";
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
        .page_body_add {
        padding-top: 120px;
        display: flex;
        justify-content: center;
        padding-bottom: 170px;
        }

        #casi_name{
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

        .form_add h2 {
        text-align: center;
        text-transform: uppercase;
        color: white;
        padding-bottom: 10px;
        }

        .form_add {
        background: linear-gradient(135deg, deepskyblue, #161b81);
        border-radius: 8px;
        padding: 40px;
        width: 600px;
        height: 500px;
        box-shadow: 0 8px 20px black;
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
        #is_admin{
            size: 10px;
        }
    </style>
</head>
<body>
    <?php include 'headerAdmin.php'; ?>
    <div class="container-admin-left">
        <?php include 'sidebarAdmin.php'; ?>
        <!-- Body -->
         <main> 
    <div class="page_body_add">
        <form method="POST" class="form_add" enctype="multipart/form-data">
            <h2>Thêm Ca Sĩ</h2>
            <input type="text" name="tenDangNhap" id="casi_name" placeholder="Tên đăng nhập">
            <br>
            <input type="text" name="tenDayDu" id="casi_name" placeholder="Tên đầy đủ">
            <br>
            <input type="text" name="gioiTinh" id="casi_name" placeholder="Giới tính">
            <br>
            <input type="text" name="email" id="casi_name" placeholder="Email">
            <br>
            <input type="text" name="matkhau" id="casi_name" placeholder="Mật khẩu">
            <br>
            <input type="checkbox" name="laAdmin" id="is_admin" placeholder="Quyền">
            <label for="">Là Admin</label>
            <br>
            <input type="file" name="avatar" id="casi_name" placeholder="ảnh">
            <br>
            <input type="submit" id="submit_btn" value="ADD" onclick = "return confirm('Bạn có chắc chắn muốn thêm người dùng này?');">
        </form>
    </div>
    </main>
    </div>
    <!-- footer -->
     <?php include('footerAdmin.php') ?>
</body>
</html>