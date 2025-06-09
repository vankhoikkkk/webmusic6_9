<?php 

use LDAP\Result; 
    require_once __DIR__ . '/../Util/database.php';
?>
<?php
    class AdminSingerDao {
        private $db;
        public function __construct(){
            $this->db = new Database();
        }
        public function ShowListSinger(){
            $query = "SELECT * FROM `casi`;";
            $result = $this->db->select($query);
            return $result;
        }
        public function GetSingerId($id_casi){
            $query = "SELECT * FROM `casi` WHERE id_casi = $id_casi";
            $result = $this->db->select($query);
            if ($result && $result->num_rows > 0){
                return $result->fetch_assoc();
            }
        }
        public function GetSongByIdSinger($id_casi){
            $query = "SELECT * FROM `baihat` WHERE id_casi = $id_casi;";
            $result = $this->db->select($query);
        }
        public function GetTotalSinger(){
            $query = "SELECT COUNT(*) as total FROM `casi`;";
            $result = $this->db->select($query);
            return $result->fetch_assoc()['total'];
        }

        public function UpdateSingerById($id_casi, $tenCaSi, $tieusu){
            $query = "UPDATE `casi` SET tenCaSi = '$tenCaSi', tieusu = '$tieusu' WHERE id_casi = $id_casi;";
            $result = $this->db->update($query);
            return $result > 0;
        }
        public function DeleteSingerById($id_casi){
            $query = "DELETE FROM `casi` WHERE id_casi = $id_casi;";
            $exists = $this->db->select($query);
            return $exists;
        }
        public function AddSinger($tenCaSi, $tieusu){
            $query = "INSERT INTO `casi` (tenCaSi, tieusu) VALUES('$tenCaSi', '$tieusu')";
            $result = $this->db->insert($query);
            return $result > 0;
        }
        public function GetAllSinger($start, $limit) {
            $query = "SELECT * FROM `casi` LIMIT $start, $limit";
            return $this->db->select($query);
        }
    }
?>