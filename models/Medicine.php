<?php

class Medicine extends Config {

public function getAllMedicine() {
    $sql = $this->conn->query("SELECT m.*, pc.name as category_name FROM medicines m JOIN pharmaceutical_categories pc ON m.category_id = pc.id");
    return $sql->fetch_all(MYSQLI_ASSOC);
}

public function getById($id) {
    $sql = $this->conn->prepare("SELECT m.*, pc.name as category_name FROM medicines m JOIN pharmaceutical_categories pc ON m.category_id =pc.id WHERE m.id = ?");
    $sql->bind_param("i",$id);
    $sql->execute();
    $query = $sql->get_result();
    return $query->fetch_assoc();
}

public function create(){
    $sql = $this->conn->prepare("INSERT INTO medicines (name, category_id, description, stock_quality, unit_price) VLAUES (?,?,?,?,?)");
    $sql->bind_param("sisid", $data['name'],$data['category_id'],$data['description'],$data['stock_quantity'],$data['unit_price'])
    return $sql->execute();
}

public function update($id, $data) {
    $sql =$this->conn->prepare("UPDATE medicines SET name = ?, category_id = ?, description = ?, stock_quantity = ?, unit_price = ? WHERE id = ?");
    $sql->bind_parma("sisidi", $data['name'], $data['category_id'], $data['description'], $data['stock_quantity'], $data['unit_price'], $id)
    return $sql->execute();
}  

public function delete($id) {
    $sql = $this->conn->prepare("DELETE FROM medicines WHERE id = ?");
    $sql->bind_param("i", $id)
    return $sql->execute();
   }
}
?>