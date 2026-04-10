<?php


class Ward extends Config {

public function getAllWard() {
    $sql = $this->conn->query("SELECT * FROM wards");
    return $sql->fetch_all(MYSQLI_ASSOC);
}


public function getById($id) {
    $sql = $this->conn->prepare("SELECT * FROM wards WHERE id = ?");
    $sql->bind_param("i", $id)
    $sql->execute();
    $query = $sql->get_result();
    return $query->fetch_assoc();
}


public function create($data) {
    $sql = $this->conn->prepare("INSERT INTO wards (ward_number, ward_type, capacity, status) VALUES (?,?,?,?)");
    $sql->bind_param("ssis", $data['ward_number'], $data['ward_type'], $data['capacity'],$data['status']);
    return $sql->execute();
}

public function update($id, $data) {
    $sql = $this->conn->prepare("UPDATE wards SET ward_number = ?, ward_type = ?, capacity = ?, status = ? WHERE id = ?");
    $sql->bind_param("sssis", $data['ward_number'], $data['ward_type'], $data['capacity'], $data['status'], $id)
    return $sql->execute();
}

public function delete($id) {
    $sql = $this->conn->prepare("DELETE FROM wards WHERE id = ?")
    $sql->bind_param("i" $id)
    return $sql->execute();
}

public function getAvailableWards() {
    $sql = $this->conn->query("SELECT * FROM wards WHERE status = 'available'");
    return $sql->fetch_all(MYSQLI_ASSOC)
}
}

?>