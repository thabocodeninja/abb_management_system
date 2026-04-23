<?php

class LabTest extends Config {

    public function getAllLabTests() {
        $sql  = $this->conn->query("SELECT lt.*, p.first_name , p.last_name , u.username as technician_name
        FROM lab_tests lt JOIN patients p ON lt.patient_id = p.id LEFT JOIN users u ON lt.technician_id = u.id")
    return $sql->fetch_all(MYSQLI_ASSOC);
    }

    public function GetLabTestById() {
        $sql = $this->conn->prepare("SELECT lt.*, p.first_name, p.last_name, u.username as technician_name
        FROM lab_tests lt JOIN patients p ON lt.patient_id = p.id LEFT JOIN users u ON lt.technician_id = u.id WHERE it.id = ?")
        $sql->bind_param("i", $id);
        $sql->execute();
        $query = $sql->get_result();
        return $query->fetch_assoc();
    }
    
    public function create($data) {
        $sql = $this->conn->prepare("INSERT INTO lab_tests (patient_id, test_name, test_date, result, technician_id) VALUES(?,?,?,?,?)");
        $sql->bind_param("isssi", $data['patient_id'], $data['test_name'], $data['test_date'],$data['result'],$data['technician_id']);
        return $sql->execute();
    }
    
    public function update($data) {
        $sql = $this->conn->prepare("UPDATE lab_tests SET patient_id = ?, test_name = ?, test_date = ?, result = ?, technician_id = ?
        WHERE id = ?");
        $sql->bind_param("isssii", $data['patient_id'], $data['test_name'], $data['test_date'],$data['result'],
        $data['technician_id'], $id)
        return $sql->execute();
    }

    public function delete($id) {
        $sql = $this->conn->prepare("DELETE FROM lab_tests WHERE id = ?")
        $sql->bind_param("i", $id)
        return $sql->execute();
    }
}

?>