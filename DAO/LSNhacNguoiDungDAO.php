<?php 
include_once __DIR__ . '/../Util/database.php';

?>

<?php 

class LSNhacNguoiDungDAO {
    private $db;

    function __construct(){
        $this->db = new Database();
    }
    function luuMoiLS($id_baihat, $id_nguoidung) {
        $query = "INSERT INTO `lichsunghenhac` (id_baihat, id_nguoidung) VALUES ($id_baihat, $id_nguoidung)";
        $result = $this->db->insert($query);
        return $result;
    }

    function kiemTraBaiHatDaLuu($id_baihat, $id_nguoidung) {
        $query = "SELECT * FROM `lichsunghenhac` WHERE id_baihat = $id_baihat AND id_nguoidung = $id_nguoidung";
        $result = $this->db->select($query);
        return $result;
    }

    function xoaBaiHatDaLuu($id_baihat, $id_nguoidung) {
        $query = "DELETE FROM `lichsunghenhac` WHERE id_baihat = $id_baihat AND id_nguoidung = $id_nguoidung";
        $result = $this->db->delete($query);
        return $result;
    }

    function getBaiHatDaLuuByID($id_nguoidung) {
        $query = "SELECT * FROM `lichsunghenhac` WHERE id_nguoidung = $id_nguoidung";
        $result = $this->db->select($query);
        return $result;
    }

    function getAllMusic($start, $limit, $id_nguoidung) {
        $query = "SELECT * FROM `lichsunghenhac`, `baihat`,casi WHERE lichsunghenhac.id_baihat = baihat.id_baihat AND baihat.id_casi = casi.id_casi AND id_nguoidung = $id_nguoidung LIMIT $start, $limit";
        $result = $this->db->select($query);
        return $result;
    }



}



?>