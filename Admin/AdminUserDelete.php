<?php
    include '../DAO/AdminUserDao.php';
    $user = new AdminUserDao();
    if (isset($_GET['id_nguoidung'])){
        $id_nguoidung = $_GET['id_nguoidung'];
        $userDB = $user->GetUserId($id_nguoidung);
        if ($userDB){
            $deleteResult = $user->DeleteUserById($id_nguoidung);
            if ($deleteResult == 0){
                ?>
            <script>
                alert("Xoá thành công!!");
            </script>
                <?php
                header('Location: AdminUserShow.php');
                exit();
            }
            else {
                echo "Xoá người dùng không thành công!!";
            }
        }
        else {
            echo "Không tìm thấy người dùng!!";
        }
    }
?>