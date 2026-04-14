<?php
class Transfer extends Config {
    public function getAllTransfer() {
        $sql = $this->conn->query("SELECT t.*, p.first_name, p.last_name, w1.ward_number as from_ward_name,
        w2.ward_number as to_ward_name, u.username as transferred_by_name FROM transfers t JOIN patients p ON t.patient_id=p.id
        JOIN wards w1 ON t.from_ward = w1.id JOIN wards w2 ON t.to_ward = w2.id JOIN users u ON t.transferred_by = u.id");
        return $sql->fetch_all(MYSQLI_ASSOC);
   
    }
    public function getById($id) {
        $sql = $this->conn->prepare("SELECT t.*, p.first_name, p.last_name, w1.ward_number as from_ward_name,
        w2.ward_number as to_ward_name, u.username as transferred_by_name FROM transfers t JOIN patients p ON t.patient_id = p.id JOIN wards w1 ON t.from_ward = w1.id JOIN wards w2
        ON t.to_ward = w2.id JOIN users u ON t.transferred_by = u.id WHERE t.id = ?");
        $sql->bind_param("i",$id);
        $sql->execute();
        $query = $sql->get_result();
        return $query->fetch_assoc();
    }

    public function create($data){
        $sql = $this->conn->prepare("INSERT INTO transfers(patient_id, from_ward, to_ward, transfer_date, reason, transferred_by) VALUES (?,?,?,?,?,?)");
        $sql->bind_param("isssssi" , $data['patient_id'], $data['from_ward'],$data['to_ward'],$data['transfer_date'], $data['reason'], $data['transferred_by'])
        return $sql->execute();
    }

public function update($id, $data) {
    $sql = $this->conn->prepare("UPDATE transfers SET patient_id = ?, from_ward = ?, transfer_date = ?, reason = ?, transferred_by = ? WHERE id = ?")
    $sql->bind_param("iiiisss" ,$data['patient_id'], $data['from_ward'], $data['to_ward'], $data['transfer_date'], $data['reason'],$data['transferred_by'])
    return $sql->execute();
}


public function delete($id){
    $sql = $this->conn->prepare("DELETE FROM transfers WHERE id = ?")
    $sql->bind_param("i", $id)
    return $sql->execute();
}
}
?>