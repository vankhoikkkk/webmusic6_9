<?php 

use LDAP\Result; 
    require_once __DIR__ . '/../Util/database.php';
?>
<?php
    class AdminUserDao {
        private $db;
        public function __construct(){
            $this->db = new Database();
        }
        public function ShowListUser(){
            $query = "SELECT * FROM `nguoidung`;";
            $result = $this->db->select($query);
            return $result;
        }
        public function GetUserId($id_nguoidung){
            $query = "SELECT * FROM `nguoidung` WHERE id_nguoidung = $id_nguoidung";
            $result = $this->db->select($query);
            if ($result && $result->num_rows > 0){
                return $result->fetch_assoc();
            }
        }

        public function GetTotalUser(){
            $query = "SELECT COUNT(*) as total FROM `nguoidung`;";
            $result = $this->db->select($query);
            return $result->fetch_assoc()['total'];
        }

        public function UpdateUserById($id_nguoidung, $tenDangNhap, $tenDayDu, $gioiTinh, $email, $matkhau, $laAdmin, $avatar){
            $query = "UPDATE `nguoidung` SET tenDangNhap = '$tenDangNhap', tenDayDu = N'$tenDayDu', gioiTinh = '$gioiTinh', email = '$email', matkhau = '$matkhau', laAdmin = '$laAdmin', avatar = '$avatar' WHERE id_nguoidung = $id_nguoidung;";
            $result = $this->db->update($query);
            return $result > 0;
        }
        public function DeleteUserById($id_nguoidung){
            $query = "DELETE FROM `nguoidung` WHERE id_nguoidung = $id_nguoidung;";
            $exists = $this->db->select($query);
            return $exists;
        }
        public function AddUser($tenDangNhap, $tenDayDu, $gioiTinh, $email, $matkhau, $laAdmin, $avatar){
            $query = "INSERT INTO `nguoidung` (tenDangNhap, tenDayDu, gioiTinh, email, matkhau, laAdmin, avatar) VALUES('$tenDangNhap', N'$tenDayDu', '$gioiTinh', '$email', '$matkhau', '$laAdmin', '$avatar')";
            $result = $this->db->insert($query);
            return $result > 0;
        }

        public function GetAllUser($start, $limit) {
            $query = "SELECT * FROM `nguoidung` LIMIT $start, $limit";
            return $this->db->select($query);
        }
        public function ExistsUser($username, $email){
            $query = "SELECT * FROM `nguoidung` WHERE tenDangNhap = '$username' OR email = '$email'";
            $result =  $this->db->select($query);
            return $result;
        }

        public function InsertSignin($loginname, $username, $email, $password){
            $query = "INSERT INTO `nguoidung`(tenDangNhap, tenDayDu, email, matkhau) VALUES('$loginname', N'$username', '$email', '$password')";
            $result = $this->db->insert($query);
            return $result > 0;
        }
    }
?>