<?php
require_once __DIR__ . '/../Util/database.php';


class AdsDAO {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getActiveAd() {
        $query = "SELECT * FROM ads WHERE active = 1 ORDER BY created_at DESC LIMIT 1";
        return $this->db->select($query);
    }   

    public function getActiveAdChinh() {
        $query = "SELECT * FROM ads WHERE active = 2 ORDER BY created_at DESC LIMIT 1";
        return $this->db->select($query);
    }

    public function getAllAds() {
        $query = "SELECT * FROM ads ";
        return $this->db->select($query);
    }

    public function addAd($title, $image_url, $target_url) {

        $query = "INSERT INTO ads (title, image_url, target_url) VALUES ('$title', '$image_url', '$target_url')";
        return $this->db->insert($query);
    }

    public function updateAd($id, $title, $image_url, $target_url, $active) {
        $query = "UPDATE ads SET title='$title', image_url='$image_url', target_url='$target_url', active=$active WHERE id=$id";
        return $this->db->update($query);
    }

    public function getAdById($id) {
    $id = intval($id);
    $query = "SELECT * FROM ads WHERE id = $id LIMIT 1";
    $result = $this->db->select($query);
    if ($result && $result->num_rows > 0) {
        return $result->fetch_assoc();
    }
    return null;
}

public function deleteAdById($id) {
    $query = "DELETE FROM ads WHERE id = $id";
    return $this->db->delete($query);
}

    public function getAdsByPage($start, $limit) {
        $query = "SELECT * FROM ads ORDER BY id DESC LIMIT $start, $limit";
        return $this->db->select($query);
    }

    public function getTotalAds() {
        $query = "SELECT COUNT(*) as total FROM ads";
        $result = $this->db->select($query);
        return $result->fetch_assoc()['total'];
    }
}
?>