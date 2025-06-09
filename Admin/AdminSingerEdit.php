<?php
include '../DAO/AdminSingerDao.php';
$singer = new AdminSingerDAO();
if (isset($_GET['id_casi'])) {
    $id = $_GET['id_casi'];
    $result_singer = $singer->GetSingerId($id);
    if (!$result_singer) {
        echo "Không tìm thấy ca sĩ...";
        exit();
    }
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tencasi = $_POST['casi_name'];
    $tieusu = $_POST['tieusu'];
    $update = $singer->UpdateSingerById($id, $tencasi, $tieusu);
    if ($update) { ?>
        <script>
            alert('Thêm ca sĩ thành công!');
        </script>";
<?php header("Location: AdminSingerShow.php");
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
            height: 550px;
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
    <!-- header -->
    <?php include 'headerAdmin.php'; ?>
    <div class="container-admin-left">
        <?php include 'sidebarAdmin.php'; ?>
        <!-- body -->
        <main>
            <div class="page_body_edit">
                <form method="POST" class="form_casi">
                    <h2>Chỉnh sửa Ca Sĩ</h2>
                    <br>
                    <label for=""><strong>Tên ca sĩ</strong></label>
                    <br>
                    <input type="text" name="casi_name" id="casi_name" value="<?= htmlspecialchars($result_singer['tenCaSi']) ?>" required>
                    <br>
                    <label for=""><strong>Tiểu sử</strong></label>
                    <br>
                    <textarea name="tieusu" id="tieusu"><?= htmlspecialchars($result_singer['tieusu']) ?></textarea>
                    <br>
                    <input type="submit" id="submit_btn" value="UPDATE">
                </form>
            </div>
        </main>
    </div>
    <!-- footer -->
    <?php include 'footerAdmin.php'; ?>
</body>

</html>