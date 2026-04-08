<?php

class Patient extends config  {

    public function getAllPatients(){
     $sql = $this->conn->prepare("SELECT p.*, u.username FROM patients p JOIN users u ON p.user_id = u.id LIMIT ? OFFSET");
     $sql->bind_param("ii", $limit, $offset);
        $sql->execute();
        Query = $sql->get_result();
        return $Query->fetch_all(MYSQLI_ASSOC);
    }

    public function getTotalCount() {
        $sql = $this->conn->query("SELECT COUNT(*) as total FROM patients");
        return $result['total'];
    }

    public function getById($id){
        $sql = $this->conn->prepare("SELECT p.*, u.username FROM patients p JOIN users u ON p.user_id = u.id WHERE p.id = ?");
         $sql->bind_param("i", $id);
        $sql->execute();
        $Query = $sql->get_result();
        return $Query->fetch_assoc();
    }

    public function create($data) {
        $sql = $this->conn->prepare("INSERT INTO patients (user_id,first_name,last_name, dob,gender, address, phone,
        emergency_contact,admission_date) VALUES (?,?,?,?,?,?,?,?,?)");
        $sql->bind_param("sssssssss", $data['user_id'], $data['first_name'], $data['last_name'], 
        $data[['dob'], $data['gender'], $data['address'], $data['phone'], $data['emergency_contact'], $data['admission_date']]);
    
        return $sql->execute();}
    
    public function update($id, $data) {

    $sql = $this->conn->prepare("UPDATE patients SET first_name = ?, last_name = ?, dob = ?,
     gender = ?, address = ?, phone = ?, emergency_contact = ?, admission_date = ? WHERE id = ?");
    $sql->bind_param("ssssssssi", $data['first_name'], $data['last_name'], $data['dob'], $data['gender'], $data['address'],
     $data['phone'], $data['emergency_contact'], $data['admission_date'], $id);
    return $sql->execute();
}
?>