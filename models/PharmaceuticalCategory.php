<?php

class PharmaceuticalCategory extends Config {

public function getAllPharmaceuticalCategory() {
    $sql = $this->conn->query("SELECT * pharmaceutical_categories");
    return $sql->fetch_all(MYSQLI_ASSOC);
}

public function getById($id) {
    $sql = $this->conn->prepare("SELECT * FROM pharmaceutical_categories WHERE id = ?");
    $sql->bind_param("i",$id);
    $sql->execute();
    $query = $sql->get_result();
    return $query->fetch_assoc();
}

public fuction create($data) {
    $sql = $this->conn->prepare("INSERT INTO pharmaceutical_categories (name, description) VALUES (?,?)")
    $sql = bind_param("ss" , $data['name'] , $data['description']);
    return $sql->execute();
}

public function update($id, $data) {
    $sql = $this->conn->prepare("UPDATE pharmaceutical_categories SET name = ?, description = ? WHERE id = ?")
    $sql->bind_param("ssi", $data['name'] , $data['description'], $id);
    return $sql->execute();
}
public function delete($id) {
    $sql = $this->conn->prepare("DELETE FROM pharmaceutical_categories WHERE id = ?");
    $sql->bind_param("i", $id);
    return $sql->execute();
}
}

?>