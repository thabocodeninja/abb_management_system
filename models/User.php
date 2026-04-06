<?php

class User extends config {
    public function authenticate($username, $pass) {
        $sql = "SELECT id , username , role FROM users WHERE username = ? AND password = ?";
        $query = bind_param("ss", $username,$password);
        $query->execute();
        $result = $query->get_result();
        return $result->fetch_assoc();        
    }

    public function getAllUsers(){
        $sql = $this->conn->query("SELECT * FROM users");
        return $sql->fetch_all(MYSQLI_ASSOC);
    }

    public function getUsersByRole($role){
        $sql = $this->conn->query("SELECT * FROM users WHERE role = ?");
        $query = bind_param("s", $role);
        $query->execute();
        $result = $query->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);    
    }
}

?>