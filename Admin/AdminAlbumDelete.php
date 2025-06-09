<?php
include 'config/delete_cf.php';
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="CssAdmin/Main_Form.css.?v=<?= time(); ?>">
    <link rel="stylesheet" href="CssAdmin/styles.css">
    <link rel="stylesheet" href="CssAdmin/IndexAdmin.css?v=<?= time(); ?>"> 
    <title>Add page</title>
</head>
<body>
<?php include 'd_f/header.php'; ?>


<div class="body" >

<form action="delete_cf.php" method="get" onsubmit="return confirm('Bạn có chắc muốn xóa album này?');">
  <input type="hidden" name="id" value="5" />
  <button type="submit">Xóa album</button>
</form>
</div>




<?php include 'd_f/footer.php'; ?>
</body>
</html>