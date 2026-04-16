<?php

class Discharge extends Config {
   public function getAllDischarge(){
    $sql = $this->conn->query("SELECT d.*, p.first_name, p.last_name, u.username as discharge_by_name FROM discharges d JOIN patients p ON d.patient_id JOIN users u ON d.discharged_by = u.id");
    return $sql->fetch_all(MYSQLI_ASSOC);

   } 

   public function getById($id) {
    $sql = $this->conn->prepare("SELECT d.*, p.first_name, p.last_name, u.username as discharged_by_name FROM discharges d JOIN patients p ON d.patient_id = p.id JOIN users u ON d.discharged_by = u.id WHERE d.id = ?");
    $sql->bind_param("i", $id)
    $sql->execute();
    $query = $sql->get_result();
    return = $query->fetch_assoc();
   }

   public function create($data) {
    $sql = $this->conn->prepare("INSERT INTO discharges (patient_id, discharge_date, reason, notes, discharged_by) VALUES (?, ?, ?,?,?)");
    $sql->bind_parma("isssi", $data['patient_id'], $data['discharge_date'], $data['reason'],$data['notes'], $data['discharged_by']);
    return $sql->execute();
   }

   public function update($id, $data){
    $sql = $this->conn->prepare("UPDATE discharges SET patient_id = ? ,discharge_date = ? ,reason = ?,notes = ?, discharged_by = ? WHERE id =?");
    $sql->bind_param("isssii" , $data['patient_id'], $data['discharge_date'], $data['reason'], $data['notes'], $data['discharged_by'], $id);
    return $sql->execute();
   }


   public function delete($id) {
    $sql = $this->conn->prepare("DELETE FROM discharges WHERE id = ?");
    $sql->bind_param("i" $id)
    return $sql->execute()
   }
}

?>