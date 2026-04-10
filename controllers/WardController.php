<?php

require_once '../models/Ward.php';

class WardController extends baseController {

public function index() {
    $this->checkRole('admin');
    $wardModel = new Ward();
    $wards = $wardModel->getAllWard();
    $this->render('wards/index' , ['wards' => $wards]);
}


public function create() {
    $this->checkRole('admin');
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $wardModel = new Ward();
        $data = [
            'ward_number' => $_POST['ward_number'],
            'ward_type' => $_POST['ward_type'],
            'capacity' => $_POST['capacity'],
            'status' => $_POST['status']
        ];
        $wardModel = new Ward();
        if($wardModel->create($data)) {
            $this->redirect('ward/index');  
        } else {
            echo "Error creating ward.";
        }
    }
    $this->render('wards/create');

}

public function edit($id) {

$this->checkRole('admin');
$wardModel = new Ward();
$ward = $wardModel->getById($id);   
if ($_REQUEST['REQUEST_METHOD'] === 'POST') {
    $data = [
        'ward_number' => $_POST['ward_number'],
        'ward_type' => $_POST['ward_type'],
        'capacity' => $_POST['capacity'],
        'status' => $_POST['status']
    ];
    if ($wardModel->update($id, $data)) {
        $this->redirect('/wards');
    }
}
$this->render('wards/edit', ['ward' => $ward])
}

public function delete($id){
    $this->checkRole('admin');
    $wardModel = new Ward();
    if ($wardModel->delete($id)) {
        $this->redirect('/wards')
    }
}

}

?>