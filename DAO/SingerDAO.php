<?php 
include_once "Util/database.php";

?>



<?php
class SingerDAO
{
    private $db;

    public function __construct()
    {
        $this->db = new Database(); // Kết nối đến cơ sở dữ liệu
    }

    public function getSingerBySongId($id_baihat)
    {
        $query = "
            SELECT casi.tenCaSi, albumcasi.linkAnh
            FROM baihat
            JOIN casi ON baihat.id_casi = casi.id_casi
            JOIN albumcasi ON baihat.id_casi = albumcasi.id_casi
            WHERE baihat.id_baihat = $id_baihat ";
        $result = $this->db->select($query);
        if ($result && $result->num_rows > 0) {
            return $result;
        }
        return null;
    }

    public function getAlbumSingerById($id_casi)
    {
        $query = "select * from casi,albumcasi where casi.id_casi = albumcasi.id_casi and casi.id_casi = $id_casi;";
        $result = $this->db->select($query);
        if ($result && $result->num_rows > 0) {
            return $result;
        }
        return null;
    }
}
