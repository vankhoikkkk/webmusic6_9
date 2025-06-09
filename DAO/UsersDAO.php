<?php
use Dba\Connection;

class UsersDAO
{
    private $db;

    public function __construct($connection)
    {
        $this->db = $connection;
    }

    public function getUserById($id_nguoidung)
    {
        $id_nguoidung = intval($id_nguoidung);
        $query = "SELECT * FROM nguoidung WHERE id_nguoidung = $id_nguoidung";
        $result = $this->db->select($query);
        if ($result && $result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        return null;
    }

    public function updateUser($id, $tenDayDu, $gioiTinh, $avatar = null) 
    {
        $conn = $this->db->getConnection();
        $id = intval($id);
        
        // Escape dữ liệu đầu vào
        $tenDayDu = $conn->real_escape_string($tenDayDu);
        $gioiTinh = $conn->real_escape_string($gioiTinh);
        
        // // Kiểm tra thời gian đổi tên
        // $query = "SELECT last_update_name FROM nguoidung WHERE id_nguoidung = $id";
        // $result = $conn->query($query);
        
        // if ($result && $result->num_rows > 0) {
        //     $row = $result->fetch_assoc();
        //     $lastChange = $row['last_update_name'];
            
        //     if ($lastChange) {
        //         $lastChangeTime = new DateTime($lastChange);
        //         $now = new DateTime();
        //         $interval = $lastChangeTime->diff($now);

        //         if ($interval->days < 1) {
        //             return "Bạn chỉ được phép đổi tên sau 1 ngày kể từ lần đổi trước.";
        //         }
        //     }
        // }

        // Xây dựng câu lệnh SQL
        $sql = "UPDATE nguoidung SET 
                tenDayDu = '$tenDayDu', 
                gioiTinh = '$gioiTinh'
                ";
        
        // Thêm avatar nếu có
        if ($avatar !== null) {
            $avatar = $conn->real_escape_string($avatar);
            $sql .= ", avatar = '$avatar'";
        }
        
        $sql .= " WHERE id_nguoidung = $id";
        
        if ($conn->query($sql)) {
            return true;
        } else {
            return "Lỗi khi cập nhật: " . $conn->error;
        }
    }
}