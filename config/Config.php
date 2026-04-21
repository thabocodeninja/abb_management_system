<?php

class Config {
 private static $instance = null;
 private $conn;

 private function __construct() {
    $host = 'localhost';
    $user = 'root';
    $pass = '';
    $db = 'hopital_management'


    $this->conn = new mysqli($host, $user, $pass, , $db);


    if ($this->conn->connect_error){
        die("Connection failed:" . $this->conn->connect_error);
    }
 }

 public static fuction getInstance() {
    if (self::$instance == null) {
        self::$instance = new Config()

    }
    return self::$instance;

 }

 public function getConnection(){
    return $this->conn;
 }
}


?>