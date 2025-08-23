<?php
class AirlineUser {
    protected $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function findByUsername($username) {
        $stmt = $this->db->prepare("SELECT * FROM tblairlineuser WHERE user = :user");
        $stmt->execute(['user' => $username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
