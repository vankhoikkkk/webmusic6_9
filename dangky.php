<?php
    include_once "./DAO/AdminUserDao.php";
    $user = new AdminUserDao();
    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        $loginname = $_POST["loginname"];
        $username = $_POST["username"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $password_confirm = $_POST["confirm_password"];
        $result = $user->ExistsUser($loginname,$email);

        if ($result != false && $result->num_rows > 0){
            echo '<script>
                alert("Tài khoản đã tồn tại!!");
                </script>
            ';
        }
        else {
            if ($user->InsertSignin($loginname,$username,$email,$password)){
                echo '<script>
                    alert("Đăng kí tài khoản thành công!!");
                    </script>
                ';
            }
            else {
                echo '<script>
                    alert("Không thể đăng kí tài khoản!!");
                    </script>
                ';
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/dangky.css"/>
    <title>Register</title>
</head>
<body>
    <form method="post" class="form">
        <p id="heading">Đăng Ký</p>
        
        <div class="field">
            <input name="loginname" autocomplete="off" placeholder="Tên Tài khoản" class="input-field" type="text" required>
        </div>

        <div class="field">
            <input name="username" autocomplete="off" placeholder="Tên người dùng" class="input-field" type="text" required>
        </div>

        <div class="field">
            <input name="email" autocomplete="off" placeholder="Email" class="input-field" type="email" required>
        </div>

        <div class="field">
            <input name="password" placeholder="Mật khẩu" class="input-field" type="password" required>
        </div>

        <div class="field">
            <input name="confirm_password" placeholder="Nhập lại mật khẩu" class="input-field" type="password" required>
        </div>

        <div class="btn">
            <a class="button1" href="dangnhap.php">Đăng nhập</a>
            <button class="button2" type="submit">Đăng ký</button>
        </div>
    </form>

    <script src="dangky.js"></script>
</body>
</html>
