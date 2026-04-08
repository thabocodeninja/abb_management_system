<?php
require_once __DIR__. '/../models/Employee.php';
require_once __DIR__. '/../models/User.php';
require_once __DIR__. '/DepartmentController.php';



class EmployeeController extends BaseController {
    public function index() {
        $this->checkRole('admin');
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 10;
        $offset = ($page - 1) * $limit;

        $employeeModel = new Employee();
        $employees = $employeeModel->getAll($limit, $offset);
        $total = $employeeModel->getTotalCount();
        $totalPages = ceil($total / $limit);

        $this->render('employees/index', ['employees' => $employees, 'page' => $page, 'totalPages' => $totalPages]);
    }

    public  function create() {
        $this->checkRole('admin');
        $userModel = new User();
         $departmentModel = new Department();
        $users = $userModel->getAllUsers();
        $departments = $departmentModel->getAllDepartments();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'user_id' => $_POST['user_id'],
                 'department_id' => $_POST['department_id'],
                 'position' => $_POST['position'],
                 'hire_date' => $_POST['hire_date']

            ];
            $employeeModel = new Employee();    
            if ($employeeModel->create($data)) {
                $this->redirect('/employees');
            }

            $this->render('employees/create', ['users' => $users, 'departments' => $departments]);
        }
    }

    public function edit($id) {

    $this->checkRole('admin');
    $employeeModel = new Employee();
    $userModel = new User();
    $departmentModel = new Department();
    $employee = $employeeModel->getById($id);
    $users = $userModel->getAllUsers();
    $departments = $departmentModel->getAllDepartments();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = [
            'user_id' => $_POST['user_id'],
            'department_id' => $_POST['department_id'],
            'position' => $_POST['position'],
            'hire_date' => $_POST['hire_date']
        ];
        if ($employeeModel->update($id, $data)) {
            $this->redirect('/employees');
        }
    }
    $this->render('employees/edit', ['employee' => $employee, 'users' => $users, 'departments' => $departments]);
    }       
      
    
    public function delete($id) {
        $this->checkRole('admin');
        $employeeModel = new Employee();
        if ($employeeModel->delete($id)) {
            $this->redirect('/employees');  
    }
    }
   ?>