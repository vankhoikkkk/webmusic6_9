<?php
include '../DAO/AdminSingerDao.php';
$singer = new AdminSingerDAO();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tencasi = $_POST['casi_name'];
    $tieusu = $_POST['tieusu'];
    $upLoad = $singer->AddSinger($tencasi, $tieusu);
    if ($upLoad) { ?>
        <script>
            alert('Thêm ca sĩ thành công!');
        </script>
<?php
        header("Location: AdminSingerShow.php");
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
    <link rel="stylesheet" href="CssAdmin/formSong.css?v=<?= time(); ?>">
    <link rel="stylesheet" href="CssAdmin/IndexAdmin.css?v=<?= time(); ?>">
    <title>Thêm Ca Sĩ</title>
    <style>
        .page_body_add {
            padding-top: 120px;
            display: flex;
            justify-content: center;
            padding-bottom: 170px;
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
    </style>

</head>

<body>
    <?php include 'headerAdmin.php'; ?>
    <div class="container-admin-left">
        <?php include 'sidebarAdmin.php'; ?>
        <!-- body -->
        <main>
            <div class="page_body_add">
                <form method="POST" class="form_add">
                    <h2>Thêm Ca Sĩ</h2>
                    <input type="text" name="casi_name" id="casi_name" placeholder="Tên ca sĩ">
                    <br>
                    <textarea name="tieusu" id="tieusu" placeholder="Tiểu sử"></textarea>
                    <br>
                    <input type="submit" id="submit_btn" value="ADD" onclick="return confirm('Bạn có chắc chắn muốn ca sĩ này?');">
                </form>
            </div>
        </main>
    </div>
    <!-- footer -->
    <?php include 'footerAdmin.php'; ?>
</body>

</html>