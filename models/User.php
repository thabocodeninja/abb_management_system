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
    public function getById($id){
        $sql = $this->conn->prepare("SELECT * FROM users WHERE id = ?");
        $sql->bind_param("i", $id);
        $sql->execute();
        $Query = $sql->get_result();
        return $Query->fetch_assoc();
    }

    public function create($data){
        $sql = $this->conn->prepare("INSERT INTO users (username, password, role) VALUES (?,?,?)");
        $sql->bind_param("sss", $data['username'], $data['password'], $data['role']);
        return $sql->execute();
    }
    public function update($id, $data){
        $sql = $this->conn->prepare("UPDATE users SET username = ?, password = ?, role = ? WHERE id = ?");
        $sql->bind_param("sssi", $data['username'], $data['password'], $data['role'], $id);
        return $sql->execute();
    }
    public function delete($id){
        $sql = $this->conn->prepare("DELETE FROM users WHERE id = ?");
        $sql->bind_param("i", $id);
        return $sql->execute();
    }
}

?>