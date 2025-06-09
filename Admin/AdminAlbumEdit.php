<?php
include 'config/fix_cf.php';
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" href="CssAdmin/Main_Form.css.?v=<?= time(); ?>">
    <link rel="stylesheet" href="CssAdmin/styles.css?v=<?= time(); ?>">
    <link rel="stylesheet" href="CssAdmin/IndexAdmin.css?v=<?= time(); ?>">
    <title>Add page</title>
</head>
<body>
    <?php include 'headerAdmin.php'; ?>
    <div class="container-admin-left">
        <?php include 'sidebarAdmin.php'; ?>

        <div class="body">
            <h2>Sửa Album Ca Sĩ</h2>
            <form method="POST" enctype="multipart/form-data">
                <label for="id_casi">Ca sĩ:</label>
                <select name="id_casi" id="id_casi" required>
                    <?php while($row = $resultCaSi->fetch_assoc()): ?>
                        <option value="<?= $row['id_casi'] ?>" <?= $row['id_casi'] == $album['id_casi'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($row['tenCaSi']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>
                <br><br>

                <label>Ảnh hiện tại:</label><br>
                <img src="<?= $album['linkAnh'] ?>" width="150"><br><br>

                <label for="linkAnh">Chọn ảnh mới:</label>
                <input type="file" name="linkAnh" id="linkAnh" accept="image/*" />
                <br><br>

                <button type="submit">Lưu thay đổi</button>
            </form>
        </div>
    </div>
    <?php include 'footerAdmin.php'; ?>
</body>
</html>