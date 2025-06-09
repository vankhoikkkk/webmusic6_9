<?php
include_once '../Util/database.php';
$db = new Database();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tenBanner = $_POST['tenBanner'];
    $trangThai = $_POST['trangThai'];
    $linkImage = $_FILES['linkImage']['name'];
    $linkTrang = $_POST['linkTrang'];
    $banner = "../album_banner/"; //thư mục chứa ảnh

    // Đường dẫn tuyệt đối để di chuyển file lên
    $linkImagePath = $banner . basename($linkImage);
  
    $uploadSuccess = true;
    //kiểm tra xem người dùng có chọn file kh và di chuyển file tải lên từ thư mục tạm (tmp_name) sang vị trí đích trên server ($linkImagePath).
    if (!empty($linkImage) && !move_uploaded_file($_FILES['linkImage']['tmp_name'], $linkImagePath)) {
        echo "Lỗi khi tải lên file Ảnh."; //Nếu người dùng có chọn ảnh, nhưng di chuyển file thất bại
        $uploadSuccess = false;
    }
    // Đường dẫn lưu vào CSDL (tương đối)
    $linkImageDB = 'album_banner/' . basename($linkImage);

    // Cập nhật CSDL
    $query = "INSERT INTO banner (tenBanner, trangThai, linkImage,linkTrang)
              VALUES ('$tenBanner', '$trangThai', '$linkImageDB','$linkTrang ')";
             

    $result = $db->insert($query);

    if ($result) {
        header("Location: AdminBannerShow.php");
        exit();
    } else {
        echo "Cập nhật không thành công.";
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="CssAdmin/indexAdmin.css?v=<?= time(); ?>">
    <link rel="stylesheet" href="CssAdmin/AdminBanner.css">

    <link rel="stylesheet" href="style.css">
</head>

<body>
   
 <?php include 'headerAdmin.php'; ?>
    <div class="container-admin-left">
        <?php include 'sidebarAdmin.php'; ?>
        <div class="container-right">
                <div class="form-wrapper">
                    <form method="POST" enctype="multipart/form-data" class="form-box">
                        <h2>Thêm banner</h2>

                        <div>
                            <label>Tên banner:</label>
                            <input type="text" name="tenBanner" required>
                        </div>

                        <div>
                            <label>Trạng thái:</label>
                            <input type="text" name="trangThai" required>
                        </div>

                        <div >
                            <label>Link ảnh:</label>
                            <input type="file" name="linkImage" accept="image/*" required>
                        </div>
                        <div>
                            <label>Link Trang:</label>
                            <input type="text" name="linkTrang" accept="image/*" required>
                        </div>

                        <button type="submit">Thêm mới</button>
                    </form>
                </div>
        </div>
    </div>


</body>

</html>