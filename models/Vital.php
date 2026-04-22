<?php

class Vital extends Config {

    public function getAllVital() {
        $sql = $this->conn->query("SELECT v.*, p.first_name, p.last_name, u.username as recorded_by_name FROM
        vitals v JOIN patients p ON v.patient_id = p.id JOIN users u ON v.recorded_by = u.id");
        return $sql->fetch_all(MYSQLI_ASSOC);
    }

    public function getById($id) {
        $sql = $this->conn->prepare("SELECT v.*, p.first_name, p.last_name, u.username as recorded_by_name FROM
        vitals v JOIN patients p ON v.patient_id = p.id JOIN users u ON v.recorded_by = u.id WHERE v.id = ?")
        $sql->bind_param("i", $id);
        $sql->execute();
        $query = $sql->get_result();
        return $query->fetch_assoc();
    }

    public function create(){
        $sql = $this->conn->prepare("INSERT INTO vitals (patient_id, recorded_date, blood_pressure,heart_rate,
        recorded_by) VALUES (?,?,?,?,?,?,?)");
        $sql->bind_param("issdii", $data['patient_id'], $data['recorded_date'],$data['blood_pressure'], $data['temperature'],
        $data['heart_rate'], $data['recorded_by'], $id);
        return $sql->execute();
    }

    public function update($id, $data) {
        $sql = $this->conn->prepare("UPDATE vitals SET patient_id = ?, recorded_date = ?, blood_pressure = ?,
        temperature = ?, heart_rate = ?, recorded_by = ? WHERE id = ?")
        $sql->bind_param("issdiii" , $data['patient_id'], $data['recorded_date'], $data['blood_pressure'],$data['temperature'],
        $data['heart_rate'], $data['recorded_by'], $id);
        return $sql->execute();
    }

    public function delete($id) {
        $sql = $this->conn->prepare("DELETE FROM vitals WHERE id = ?");
        $sql->bind_param("i",$id)
        return $sql->execute();
    }
}

?>