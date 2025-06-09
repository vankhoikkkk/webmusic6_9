<?php
include 'config/add_cf.php'; 
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CssAdmin/Main_Form.css.?v=<?= time(); ?>">
    <link rel="stylesheet" href="CssAdmin/styles.css">
    <link rel="stylesheet" href="CssAdmin/IndexAdmin.css?v=<?= time(); ?>">
    <title>Thêm Album Ca Sĩ</title>
</head>
<body>
    <?php include 'headerAdmin.php'; ?>
    <div class="container-admin-left">
        <?php include 'sidebarAdmin.php'; ?>

        <div class="body-container">
            <h2>Thêm Album Ca Sĩ</h2>
            
            <?php if (!empty($error)): ?>
                <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            
            <?php if (!empty($success)): ?>
                <div class="success-message"><?php echo htmlspecialchars($success); ?></div>
            <?php endif; ?>

            <form method="POST" enctype="multipart/form-data" class="album-form">
                <div class="form-group">
                    <label for="id_casi">Ca sĩ:</label>
                    <select name="id_casi" id="id_casi" required>
                        <option value="">-- Chọn ca sĩ --</option>
                        <?php while($row = $resultCaSi->fetch_assoc()): ?>
                            <option value="<?php echo htmlspecialchars($row['id_casi']); ?>">
                                <?php echo htmlspecialchars($row['tenCaSi']); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="linkAnh">Ảnh album:</label>
                    <input type="file" name="linkAnh" id="linkAnh" accept="image/*" required />
                </div>

                <button type="submit" class="submit-btn">Thêm Album</button>
            </form>
        </div>
    </div>

    <?php include 'footerAdmin.php'; ?>
</body>
</html>