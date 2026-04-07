<?php

class Employee extends config {
    public function getAllPatients(){
   $sql = $this->conn->query("SELECT e.*, u.username, d.name as department_name FROM employees e JOIN users u ON e.user_id = u.id
    JOIN departments d ON e.department_id = d.id");
    return $sql->fetch_all(MYSQLI_ASSOC);
    }

    public function getById($id) {
        $sql = $this->conn->prepare("SELECT e.*, u.username, d.name as department_name FROM employees e JOIN user u ON e.user_id = u.id 
        JOIN departments d ON e.department_id = d.id WHERE e.id = ?");
        $sql->bind_param("i", $id);
        $sql->execute();
        $Query = $sql->get_result();
        return $Query->fetch_assoc();
    }

    public function create($data){
        $sql = $this->conn->prepare("INSERT INTO employees (user_id,Department_id, position,hire_date") Values(?,?,?,?)");
        $sql-> bind_param("iiss", $data['user_id'], $data['department_id'], $data['position'], $data['hire_date']);
        return $sql->execute();
    }

    public function update($id,$data){
    $sql = $this->conn->prepare("UPDATE employees SET user_id = ?, department_id = ?, position = ?, hire_date = ? WHERE id = ?");
    $sql->bind_param("iissi", $data['user_id'], $data['deparment_id'], $data['position'], $data['hire_date'], $id);
    return $sql->execute();
    }

    public function delete($id){
    $sql = $this->conn->prepare("DELETE FROM employees WHERE id = ?");
    $sql->bind_param("i", $id); 
    return $sql->execute();
    }
   
  
}

?>