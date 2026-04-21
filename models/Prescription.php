<?php

class Prescription extends Config {
    public function getAllPrescription(){
        $sql = $this->conn->query("SELECT pr.*, p.first_name, p.last_name, u.username as doctor_name FROM prescriptions pr JOIN patients p ON pr.patient_id = p.id
        JOIN users u ON pr.doctor_id = u.id");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getById($id) {
        $sql = $this->conn->prepare("SELECT pr.*, p.first_name, p.last_name, u.username as doctor_name FROM prescriptions pr JOIN
        patients p ON pr.patient_id = p.id JOIN users u ON pr.doctor_id = u.id WHERE pr.id = ?");
        $sql->bind_param("i", $id);
        $sql->execute();
        $query = $sql->get_result();
        return $query->fetch_assoc();
    }

    public function create($data) {
     $sql = $this->conn->prepare("INSERT INTO prescriptions (patient_id, doctor_id, prescription_date, medication, dosage,
     instructions) VALUES (?,?,?,?,?,?)");
     $sql->bind_param("iissss", $data['patient_id'], $data['doctor_id'], $data['prescription_date'], $data['medication'],
     $data['dosage'], $data['instructions']);
     return $sql->execute();
    }
    
    public function update($id, $data) {
        $sql = $this->conn->prepare("UPDATE prescriptions SET patient_id ?, doctor_id = ?, prescription_date = ?,
        medication = ?, dosage = ?, instructions = ? WHERE id = ?");
        $sql->bind_param("iisss", $data['patient_id'], $data['doctor_id'], $data['prescription_date'],
        $data['medication'] , $data['dosage'] ,$data['instructions'], $id)
        return $sql->execute();
    }

    public fuction delete($id) {
        $sql = $this->conn->prepare("DELETE FROM prescriptions WHERE id = ?");
        $sql->bind_param("i", $id);
        return $sql->execute()
    }

}

?>