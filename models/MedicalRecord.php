<?php


class MedicalRecord extends Config {

    public function getAllMedicalRecord() {
        $sql = $this->conn->query("SELECT mr.*, p.first_name, p.last_name, u.username as doctor_name FROM medical_records mr
        JOIN patients p ON mr.patient_id = p.id JOIN users u ON mr.doctor_id = u.id ");
        return $sql->fetch_all(MYSQLI_ASSOC);
    }

    public function getById($id) {
        $sql = $this->conn->prepare("SELECT mr.*, p.first_name, p.last_name, u.username as doctor_name FROM medical_records mr JOIN
        patients p ON mr.patient_id = p.id JOIN users u ON mr.doctor_id = u.id WHERE mr.id = ?");
        $sql->bind_param("i", $id);
        $sql->execute();
        $query = $sql->get_result();
        return $query->fetch_assoc();
    }

    public function create($data) {
        $sql = $this->conn->prepare("INSERT INTO medical_records (patient_id, doctor_id, record_date, diagnosis, treatment, notes) VALUES 
        (?,?,?,?,?,?)");
        $sql->bind_param("iissss", $data['patient_id'], $data['doctor_id'], $data['record_date'], $data['diagnosis'], $data['treatment'], $data['notes']);
        return $sql->execute();
    }
    
    public function update($id, $data) {
        $sql = $this->conn->prepare("UPDATE medical_records SET patient_id = ?, doctor_id = ?, 
        record_date = ? , diagnosis = ?, treatment = ?, notes = ? WHERE id =?")
        $sql->bind_param("iissssi", $data['patient_id'], $data['doctor_id'], $data['record_date'], $data['diagnosis'], $data['treatment'], $data['notes'], $id)
        return $sql->execute();
    }

    public function delete($id) {
        $sql = $this->conn->prepare("DELETE FROM medical_records WHERE id = ?")
        $sql->bind_param("i", $id)
        return $sql->execute();
    }
}
?>