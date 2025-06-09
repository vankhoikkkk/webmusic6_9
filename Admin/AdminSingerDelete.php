<?php
    include '../DAO/AdminSingerDao.php';
    $singer = new AdminSingerDao();
    if (isset($_GET['id_casi'])){
        $id = $_GET['id_casi'];
        $casiDB = $singer->GetSingerId($id);
        if ($casiDB){
            $deleteResult = $singer->DeleteSingerById($id);
            if ($deleteResult == 0){
                ?>
            <script>
                alert("");
            </script>
                <?php
                header('Location: AdminSingerShow.php');
                exit();
            }
            else {
                echo "Xoá bài hát không thành công!!";
            }
        }
        else {
            echo "Không tìm thấy ca sĩ!!";
        }
    }
?>