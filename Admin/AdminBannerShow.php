<?php
include_once '../Util/database.php';
$db = new Database();

$limit = 5;
// Trang hiện tại
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $limit;
//tổng  banner
$countArtist="select count(id_banner) as total from banner";

 $resultcount = $db->select($countArtist);

  $row = $resultcount->fetch_assoc();
$totalArtists = $row['total'];
$totalPages =  ceil($totalArtists / $limit);

?>

<!DOCTYPE html>
<html lang="en">

<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Document</title>
     
     <link rel="stylesheet" href="CssAdmin/adminBanner.css">
    <link rel="stylesheet" href="CssAdmin/IndexAdmin.css?v=<?= time(); ?>">
    
    
</head>
<style>
     .link {
    text-decoration: underline !important;

}

</style>

<body>
 <?php include 'headerAdmin.php'; ?>
     <div class="container-admin-left" >
          
    <?php include 'sidebarAdmin.php'; ?>
      
       <div class="container-right">
          
          <p>Danh sách banner</p>
          <div class="container">
              
               <?php
               $db = new Database();
               $query = "SELECT * FROM banner  LIMIT $offset,$limit";
               $result = $db->select($query);
               if ($result->num_rows > 0) {
                    echo "<table border='1' style='width:100%; border-collapse:collapse;'>";
                    echo "<tr>
                         <th>id_banner</th>
                         <th>Tên banner</th>
                         <th>Trạng thái</th>
                         <th>linkImage</th>
                         <th>linkTrang</th>
                         <th>Tùy chỉnh</th>
                         </tr>";

                    while ($row = $result->fetch_assoc()) {
                         echo "<tr>
               <td>" . $row["id_banner"] . "</td>
               <td>" . $row["tenBanner"] . "</td>
               <td>" . $row["trangThai"] . "</td>
             <td><img src='../" . $row["linkImage"] . "' alt='" . $row["tenBanner"] . "' width='150' height='150'></td>
             <td ><a class ='link' href='" . $row["linkTrang"] . "'>" . $row["linkTrang"] . "</a></td>
        <td class='tuychinh'>
               <a href='AdminBannerEdit.php?id=" . $row["id_banner"] . "' class='btn-edit'>Sửa</a> 
                    <a href='AdminBannerDelete.php?id=" . $row["id_banner"] . "' onclick=\"return confirm('Bạn có chắc chắn muốn xóa ca sĩ này không?');\" class='btn-delete'>Xóa</a>
                    
                    </td>
                    </tr>";
                    }
                    echo "</table>";
               } else {
                    echo "0 results";
               }

               ?>
          </div>
         <!--phan trang-->
         <div class="list-buttom">
                <ul class="pagination">
            <?php
              if( $page>1 && $totalPages > 1 ){
             echo '<a href="?page='. ($page-1).'">Prev</a> | ';

              }
              for ($i = 1; $i <= $totalPages; $i++) {
                  if ($i == $page) {
                      echo '<span>' . $i . '</span> | ';
                  } else {
                      echo '<a href="?page=' . $i . '">' . $i . '</a> |';
                       
                  }
                  }
              if($page< $totalPages  && $totalPages>1){
                echo '<a href="?page='. ($page+1) .' ">Next</a>';
              }

            ?></ul>
            
          </div>
      </div>
     
     </div>
  <?php include 'footerAdmin.php'; ?>
</body>

</html>