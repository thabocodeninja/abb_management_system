<?php

require_once __DIR__. '/../models/Patient.php';
require_once __DIR__. '/../models/Appointment.php';
require_once __DIR__ . '/../models/MedicalRecord.php';

class ReportController extents BaseController {

public function index() {
    $this->checkRole('admin');
    $patientModel = new Patient();
    $patients = $patientModel->getAll();

    require_once __DIR__. '/../../vendor/autoload.php';
    $mpdf = new \Mpdf\Mpdf();
    $html = '<h1>Patient Report</h1><<table border="1"><tr><th>Name</th><th>Phone</th><th>Status<th></tr>';
    foreach ($patients as $patient){
        $html .= '<tr><td>' . $patient['first_name'] . ' ' . $patient['last_name'] . '</td>';
        $html .= '<td>' . $patient['date_of_birth'] . '</td>';
        $html .= '<td>' . $patient['gender'] . '</td>';
        $html .= '<td>' . $patient['contact_info'] . '</td>';       
        $html .= '</tr>';
    }
    $html .= '</table>';

    $dompdf->loadHTML($html);
    $dompdf->setPaper('A4', 'landscape');
    $dompdf->render();
    $dompdf->stream('patient_report.pdf');
}

public function appointmentsPDF() {
    $this->checkRole('admin');
    $appointmentModel = new Appointment();
    $appointments = $appointmentModel->getAllAppointment();
    require_once __DIR__. '/../../vendor/autoload.php';
    $dompdf = new \Dompdf\Dompdf();

    $html = '<h1>Appointments Report</h1><table border="1"><tr><th>ID</th><th>Patient</th><th>Doctor</th><th>Date</th><th>Notes</th></tr>';
      foreach ($appointments as $appointment) {
        $html .= '<tr><td>' .$appointment['id'] . '</td><td>' .$appointment['first_name'] .  ' ' . $appointment['last_name'] .
         '</td><td>' . '/td><td>' . $appointment['doctor_name'] . '</td><td>' . $appointment['appointment_date'] . '</td><td>' . $appointment['notes'] . '</td></tr>';

      }
    
    $html .= '</table>';

    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'landscape');
    $dompdf->render();
    $dompdf->stream('appointments_report.pdf');
}


public function medicalRecords() {
    $this->checkRole('admin');
    $medicalRecordModel = new medicalRecords();
    $medicalRecords = $medicalRecordModel->getAllMedicalRecord();
    $this->exportCSV($medicalRecords, 'medical_records_report.csv');
}

private function exportCSV($data, $filename) {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    $output = fopen('php://output', 'w');
    if (!empty($data)) {
        fputcsv($output, array_keys($data[0]));
        foreach ($data as $row) {
            fputcsv($output, $row)
        }
    }
    fclose($output);
    exit;
}

public function import() {
    $this->checkRole('admin');
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['csv_file'])){
        $file = $_FILES['csv_file']['tmp_name'];
        if (($handle = fopen($file, "r")) !== FALSE) {
            $headers = fgetcsv($handle, 1000, ",");
            $data = [];
            while (($row = fgetcsv($handle, 1000, "," )) !== FALSE){
                $data[] = array_combine($headers, $row)
            }
        fclose($handle);
        $type = $_POST['import_type'];
        $this->processImport($type, $data)
        }
    }
    $this->render('renders/import');
}

private function processImport($type, $data) {
    $this->redirect('/reports')
}

}

?>
