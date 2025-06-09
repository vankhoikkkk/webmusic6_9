<?php
include 'Util/database.php';
?>

<?php 
class LuotNgheDAO {
    private $db;
    function __construct()
    {
        $this->db = new Database();
    }


    function CountLuotNgheBaiHat($id_baihat) {
        $query = "SELECT COUNT(*) FROM luotNghe WHERE id_baihat = $id_baihat";
        $result = $this -> db -> select($query);
        return $result;
    }

    function UpdateLuotNgheBaiHat($id_baihat) {
        $query = "UPDATE baihat SET luotnghe = luotnghe + 1 WHERE id_baihat = $id_baihat";
        $result = $this -> db -> update($query);
        return $result;
    }


}


?>
