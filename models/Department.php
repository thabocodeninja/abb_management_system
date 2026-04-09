<?php


class Department extends config {
    public function getAllDepartments() {
        $sql = $this->conn->query("SELECT * FROM departments");
        return $sql->fetch_all(MYSQLI_ASSOC);
    }
public function getById($id){
    $sql = $this->conn->prepare("SELECT * FROM departments WHERE id = ?");
    $sql->bind_param("i", $id);
    $sql->execute();
    $query = $sql->get_result();
    return $query->fetch_assoc();
}
public function create($data) {
    $sql = $this->conn->prepare("INSERT INTO departments (name, description) VALUES (?, ?)");
    $sql->bind_param("ss", $data['name'], $data['description']);
    return $sql->execute();

}
public function update($id,$data){
    $sql = $this->conn->prepare("UPDATE departments SET name=?, description = ? WHERE id = ?");
    $sql->bind_param("ssi", $data['name'], $data['description'], $id);
    return $sql->execute();

}

public function delete($id){
    $sql = $this->conn->prepare("DELETE FROM departments WHERE id = ?");
    $sql->bind_param("i", $id);
    return $sql->execute();

}

?>