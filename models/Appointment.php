<?php

class Appointment extends Config {

public function getAllAppointments() {
    $sql = $this->conn->query("SELECT .*, p.first_name, p.last_name, u.username as docto_name FROM appointments a JOIN
    patients p ON a.patient_id = p.id JOIN users u ON a .doctor_id = u.id");
    return $sql->fetch_all(MYSQLI_ASSOC);  
}

public function getById($id) {

$sql = $this->conn->prepare("SELECT a.*, p.first_name, p.last_name, u.username as doctor_name FROM appointments a JOIN 
patients p ON a.patient_id = p.id JOIN users u ON a.doctor_id = u.id WHERE a.id = ?");
$sql->bind_param("i", $id);
$sql->execute();
$query = $sql->get_result();
return $query->fetch_assoc();
}

public function create($data){
    $sql = $this->conn->prepare("INSERT INTO appointments (patient_id, doctor_id, appointment_date, notes) VALUES (?,?,?,?)");
    $sql->bind_param("isssi", $data['patient_id'], $data['doctor_id'], $data['appointment_date'],$data['notes']);
    return $sql->execute();
}

public function update($id,$data){
    $sql = $this->conn->prepare("UPDATE appointments SET patient_id= ?,doctor_id=?,appointment_date= ?, notes = ? WHERE id = ?");
    $sql->bind_param("issssi", $data['patient_id'], $data['dpctor_id'], $data['appointment_date'], $data['notes'], $id);
    return $sql->execute();
}

public function delete($id) {
    $sql = $this->conn->prepare("DELETE FROM appointments WHERE id = ?");
    $sql->bind_param("i", $id);
    return $sql->execute();
}


public function getAllAppointmentsByUser($user_id) {
    $sql = $this->conn->prepare("SELECT a.*, p.first_name, p.last_name, FROM appointments a JOIN patients p ON a.patient_id = p.id WHERE a.patient_id = ? OR a.doctor_id = ?");
     $sql->bind_param("ii", $user_id);
     $sql->execute();
     $query = $sql->get_result();
        return $query->fetch_all(MYSQLI_ASSOC); 
    }

}
?>

