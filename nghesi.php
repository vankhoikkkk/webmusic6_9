
<?php
 if (session_status() == PHP_SESSION_NONE) {
    session_start();
    }
include_once 'Util/database.php';

$db=new Database();

$limit = 20;
$theloai =  isset($_GET['theloai']) ? $_GET['theloai'] : "ALL";
if (isset($_GET['theloai'])) {
  $theloai = $_GET['theloai'];
} else {
  echo "Lỗi không tìm được thể loại nhạc";
}
// Trang hiện tại
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page-1 ) * $limit;

$countArtist = "";
$resultcount = "";


if($theloai == "ALL") {
  //tổng  nghệ sĩ
$countArtist="SELECT COUNT(DISTINCT id_casi) AS total FROM albumcasi";
$resultcount=$db->select($countArtist);
}else {
//tổng nghệ sĩ thể loại 
  $countArtist = "SELECT COUNT(DISTINCT albumcasi.id_casi) AS total 
FROM albumcasi 
JOIN casi ON casi.id_casi = albumcasi.id_casi 
JOIN baihat ON casi.id_casi = baihat.id_casi 
WHERE baihat.theloai = '$theloai'";
  $resultcount=$db->select($countArtist);
}

$row = $resultcount->fetch_assoc();
$totalArtists = $row['total'];
$totalPages =  ceil($totalArtists / $limit);



//truy van nghe si

$query = "
SELECT albumcasi.id_casi, tenCasi, MIN(linkAnh) AS linkAnh
FROM albumcasi
JOIN casi ON casi.id_casi = albumcasi.id_casi

GROUP BY albumcasi.id_casi, tenCasi
ORDER BY tenCasi ASC
LIMIT $offset, $limit
";

$queryTheloai2 = "
SELECT albumcasi.id_casi, tenCasi, MIN(linkAnh) AS linkAnh
FROM albumcasi
JOIN casi ON casi.id_casi = albumcasi.id_casi
JOIN baihat ON casi.id_casi = baihat.id_casi
WHERE baihat.theloai = '$theloai'
GROUP BY albumcasi.id_casi, tenCasi
ORDER BY tenCasi ASC
LIMIT $offset, $limit;
";

if($theloai == "ALL") {
  $result=$db->select($query);
}else {
  $result = $db->select($queryTheloai2);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="CSS/header.css">
  <link rel="stylesheet" href="CSS/footer.css">
  <link rel="stylesheet" href="CSS/nghesi.css?v=<?= time(); ?>">
    </head>



<body>
   <?php include 'header.php' ?>
  <div class="top"> <h1 style=color:#00aeef>Danh sách nghệ sĩ </h1> </div>

  <div class="container_nghesi">
    <div class="container_nghesi-left">
      <ul class="menu_nghesi">
        <li><a class= "item" href="nghesi.php?theloai=Nhạc Trẻ">Ca sĩ nhạc trẻ</a></li>
        <li><a class= "item" href="nghesi.php?theloai=Nhạc Rap">Ca sĩ nhạc rap</a></li>
        <li><a class= "item" href="nghesi.php?theloai=Nhạc Đỏ">Ca sĩ nhạc đỏ</a></li>
        <li><a class= "item" href="nghesi.php?theloai=Nhạc Âu">Ca sĩ nhạc âu</a></li>
        <li><a class= "item" href="nghesi.php?theloai=Nhạc Trung">Ca sĩ nhạc trung</a></li>
        <li><a class= "item" href="nghesi.php?theloai=ALL">All</a></li>
      </ul>
    </div>

    <div class = "container_nghesi-right">
        <div class="artist-grid" >
            <?php
            if ($result) {
              while ($row = $result->fetch_assoc()) {
            ?>
                <div  class="artist-item">
                  <a href="chitiet.php?id=<?= $row['id_casi'] ?>">
                
                <img src="<?php echo $row['linkAnh']; ?>" alt="<?= $row['tenCasi'] ?>"> 
                  <div class="ten">
                    <p class="casi"><?php echo $row['tenCasi']; ?></p>
                  </div>
                  </a>
                  </div>

            <?php
              }
            } else {
              echo "<p>Không có bài hát nào.</p>";
            }
            ?>
        </div>

        <!--phan trang-->
         <div class="list-buttom">
                <ul class="pagination">
            <?php
              if( $page>1 && $totalPages > 1 ){
             echo '<a href="nghesi.php?theloai='. $theloai .'&page='. ($page-1).'">Prev</a> | ';

              }
              for ($i = 1; $i <= $totalPages; $i++) {
                  if ($i == $page) {
                      echo '<span>' . $i . '</span> | ';
                  } else {
                      echo '<a href="nghesi.php?theloai='. $theloai .'&page=' . $i . '">' . $i . '</a> |';
                  }
              } 
              if($page< $totalPages  && $totalPages>1){
                echo '<a href="nghesi.php?theloai='. $theloai .'&page='. ($page+1) .' ">Next</a>';
              }

            ?></ul>
            
          </div>
        </div>

    </div>
  </div>

   <?php
   include 'footer.php'
   ?> 

</body>
</html>

 
    
   