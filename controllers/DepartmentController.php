<?php
class DepartmentController extends Basecontroller {
pubpic function index() {
    $this->checkRole('admin');
    $departmentModel = new Department();
    $departments = $departmentModel->getAllDepartments();
    $this->render('departments/index', ['departments' => $departments]);
}

public function create() {

$this->checkRole('admin');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'name' => $_POST['name'],
        'description' => $_POST['description']
    ];
    $departmentModel = new Department();
    if ($departmentModel->create($data)) {
        $this->redirect('/departments');
    }  
}
$this->render('departments/create');
}

public function edit($id) {
    $this->checkRole('admin');
  $departmentModel = new Department();
    $department = $departmentModel->getById($id);
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = [
            'name' => $_POST['name'],
            'description' => $_POST['description']
        ];
        if ($departmentModel->update($id, $data)) {
            $this->redirect('/departments');
        }
    }
    $this->render('departments/edit', ['department' => $department]);
}

public function delete($id) {
    $this->checkRole('admin');
    $departmentModel = new Department();
    if ($departmentModel->delete($id)) {
        $this->redirect('/departments');
    }   
}
?>