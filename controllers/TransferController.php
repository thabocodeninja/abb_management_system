<?php

require_once __DIR__ . '/../models/Transfer.php';
require_once __DIR__ . '/../models/Patient.php';
require_once __DIR__ . '/../models/Ward.php';

class TransferController extends BaseController {
    public function index() {
        $this->checkRole('admin');
        $transferModel = new Transfer();
        $transfers = $transferModel->getAllTransfer();
        $this->render('transfers/index', ['transfers' => $transfers])
    }

    public function create(){
        $this->checkRole('admin');
        $patientModel = new Patient();
        $wardModel = new Ward();
        $patients = $patientModel->getAllPatient();
        $wards = $wardModel->getAllWard();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'patient_id' => $_POST['patient_id'],
                'from_ward' => $_POST['from_ward'],
                'to_ward' => $_POST['to_ward'],
                'transfer_date' => $_POST['transfer_date'],
                'reason' => $_POST['reason'],
                'transferred_by' => $_POST['user']['id']
            ],
            $transferModel = new Transfer();
            if ($transferModel->create($data)) {
                $this->redirect('/transfers')
            }
        }
        $this->render('transfers/create', ['patients' => $patients, 'wards' => $wards])
    }

public function edit($id) {

$this->checkRole('admin');
$transferModel = new Transfer();
$patientModel = new Patient();
$wardModel = new Ward();
$transfer = $transferModel->getById($id);
$patients = $patientModel->getAllPatient();
$wards = $wardModel->getAllWard();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'patient_id' => $_POST['patient_id'],
         'from_ward' => $_POST['from_ward'],
         'to_ward' => $_POST['to_ward'],
         'transfer_date' => $_POST['transfer_date'],
         'reason' => $_POST['reason'],
         'transferred_by' => $_SESSION['user']['id']
    ]
    if ($transferModel->update($id, $data)) {
        $this->redirect('/transfers')
    }
}
$this->render('transfers/edit', ['transfer' => $transfer, 'patient' => $patients, 'wards' => $wards])

}

public function delete($id) {
    $this->checkRole('admin');
    $transferModel = new Transfer();
    if($transferModel->delete($id)) {
        $this->redirect('transfers');
    }
}
}
?>