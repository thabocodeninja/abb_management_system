<?php

class WardBooking extends Config {

    public fuction getAllWardBookings() {
        $sql = $this->conn->query("SELECT wb.*, p.first_name , p.last_name, w.ward_number FROM ward_bookings wb JOIN
        patients p ON wb.patient_id = p.id JOIN wards w ON wb.ward_id = w.id");
        return $sql->fetch_all(MYSQLI_ASSOC);

    }

    public function getById($id) {
        $sql = $this->conn->prepare("SELECT wb.*, p.first_name, p.last_name, w.ward_number FROM 
        ward_bookings wb JOIN patients p ON wb.patient_id = p.id JOIN wards w ON wb.ward_id = w.id 
        WHERE wb.id = ?");
        $sql->bind_param("i", $id);
        $sql->execute();    
        return $sql->get_result()->fetch_assoc();
    }

    public function create($data) {
        $sql = $this->conn->prepare("INSERT INTO ward_bookings (patient_id, ward_id, booking_date, discharge_date) VALUES (?,?,?,?)");
        $sql->bind_param("iiss", $data['patient_id'], $data['ward_id'], $data['booking_date'], $data['discharge_date']);
        return $sql->execute();
    }

    public function update($id,$data) {
        $sql = $this->conn->prepare("UPDATE ward_bookings SET patient_id = ?, ward_id = ?, booking_date = ?, discharge_date = ?,
        notes = ? WHERE id = ?");
        $sql->bind_param("iiisssi", $data['patient_id'], $data['ward_id'], $data['booking_date'], $data['discharge_date'], $data['notes'],$id)
         return $sql->excute();

        }
    public function delete($id) {
        $sql = $this->conn->prepare("DELETE FROM ward_bookings WHERE id = ?");
        $sql->bind_param("i", $id);
        return $sql->execute();
    }

?>
