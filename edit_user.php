
<?php 

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include('Util/database1.php');
include('DAO/UsersDAO.php');

$db = new Database();
$conn = $db;
$dao = new UsersDAO($conn);

$id_nguoidung = $_SESSION['id_nguoidung'] ?? 1;
$user = $dao->getUserById($id_nguoidung);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id_nguoidung']);
    $tenDayDu = $_POST['tenDayDu'];
    $gioiTinh = $_POST['gioiTinh'];

    $avatar = !empty($_FILES['avatar']['name']) ? $_FILES['avatar']['name'] : basename($user['avatar']);
    // Thư mục để lưu ảnh đại diện
    $targetDir = "Avatar_User/";
    $albumPath = $targetDir . basename($avatar);

    $uploadSuccess = true;
    if (!empty($_FILES['avatar']['name']) && !move_uploaded_file($_FILES['avatar']['tmp_name'], $albumPath)) {
        $uploadSuccess = false;
    }

    if ($uploadSuccess) {

        $avatarPath = 'Avatar_User/' . basename($avatar);
        $success = $dao->updateUser($id, $tenDayDu, $gioiTinh, $avatarPath);
        if ($success) {
            header("Location: user_management.php");
            exit();
        } else {
            echo "Cập nhật không thành công.";
        }
    } else {
        echo "Đã xảy ra lỗi khi tải file lên.";
    }

}


?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Chỉnh sửa thông tin</title>
  <style>
    form { max-width: 400px; margin: auto; background: #fff; padding: 20px; border-radius: 8px; }
    input, select { width: 100%; padding: 8px; margin-bottom: 12px; }
    input[type="submit"] { background: #00aeef; color: white; border: none; cursor: pointer; }
  </style>
</head>
<body>

<h2 style="text-align:center">Cập nhật thông tin</h2>
<form method="POST" enctype="multipart/form-data">

  <?php 
    $avatar = $user['avatar'] ?? 'image/default_avatar.png';
  ?>

  <img src="<?= htmlspecialchars($avatar) ?>" alt="current avatar" width="100" height="100" style="display:block; margin-bottom:10px;">
  <input type="file" name="avatar" accept="image/*">  

  <input type="hidden" name="id_nguoidung" value="<?= $user['id_nguoidung'] ?>">
  <label>Họ và tên:</label>
  <input type="text" name="tenDayDu" value="<?= htmlspecialchars($user['tenDayDu']) ?>" required>

  <label>Giới tính:</label>
  <select name="gioiTinh">
    <option value="Nam" <?= $user['gioiTinh'] == 'Nam' ? 'selected' : '' ?>>Nam</option>
    <option value="Nữ" <?= $user['gioiTinh'] == 'Nữ' ? 'selected' : '' ?>>Nữ</option>
  </select>

  <input type="submit" value="Cập nhật">
</form>

</body>
</html>
