<?php
include '../DAO/AdminSongDAO.php';

$song = new AdminSongDAO();

if (isset($_GET['id'])) {
    $id = $_GET['id']; 
    $songData = $song->GetSongById($id);
    
    if ($songData) {
        $albumPath = '../album/' . $songData['album'];
        $audioPath = '../audio/' . $songData['linknhac'];

        // Xóa file vật lý
        if (file_exists($albumPath)) {
            unlink($albumPath);
        }
        if (file_exists($audioPath)) {
            unlink($audioPath);
        }

        $deleteResult = $song->DeleteSongById($id);

        if ($deleteResult) {
            header("Location: AdminSongShow.php");
            exit();
        } else {
            echo "Xóa bài hát không thành công.";
        }
    }
} else {
    echo "Không tìm thấy ID bài hát để xóa.";
}
?>