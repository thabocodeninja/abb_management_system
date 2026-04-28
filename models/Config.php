<?php



class Config {
    protected $conn;

    public function __construct() {
        $this->conn = new mysqli('localhost', 'root', '', 'hospital_management');
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }   
}
?>