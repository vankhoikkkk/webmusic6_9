
<?php
include_once __DIR__ . '/../Util/database.php';
?>

<?php
class LuuBaihatNguoiDung {
    private $db;

    function __construct() 
    {
        $this->db = new Database();
    }
    function LuuBaiHat($id_baihat, $id_nguoidung) {
        $query = "INSERT INTO dsnhacnguoidung (id_baihat, id_nguoidung) VALUES ($id_baihat, $id_nguoidung)";
        $result = $this->db->insert($query);
        return $result;
    }

    function KiemTraBaiHatDaLuu($id_baihat, $id_nguoidung) {
        $query = "SELECT * FROM dsnhacnguoidung WHERE id_baihat = $id_baihat AND id_nguoidung = $id_nguoidung";
        $result = $this->db->select($query);
        return $result;
    }

    function DeleteHatDaLuu($id_baihat, $id_nguoidung) {
        $query = "DELETE FROM dsnhacnguoidung WHERE id_baihat = $id_baihat AND id_nguoidung = $id_nguoidung";
        $result = $this->db->delete($query);
        return $result;
    }

     function BaiHatDaLuuOfID($id_nguoidung) {
        $query = "SELECT * FROM dsnhacnguoidung, casi, baihat WHERE dsnhacnguoidung.id_baihat = baihat.id_baihat AND baihat.id_casi = casi.id_casi AND id_nguoidung = $id_nguoidung";
        $result = $this->db->select($query);
        return $result;
    }

    function getAllMusic($start, $limit, $id_nguoidung) {
        $query = "SELECT * FROM dsnhacnguoidung, casi, baihat WHERE dsnhacnguoidung.id_baihat = baihat.id_baihat AND baihat.id_casi = casi.id_casi AND id_nguoidung = $id_nguoidung LIMIT $start, $limit";
        $result = $this->db->select($query);
        return $result;
    }

    
}

?>