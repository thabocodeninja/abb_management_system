<?php

require_once __DIR__. '/../models/PharmaceuticalCategory.php';
require_once __DIR__. '/../models/Medicine.php';


class PharmaceuticalController extends BaseController {

public function index(){
    $this->checkRole('admin')
    $medicineModel = new Medicine();
    $medicines = $medicineModel->getAllMedicine();
    $this->render('pharmaceuticals/index' , ['medicines' => $medicines])
}


public function create() {
    $this->checkRole('admin');
    $categoryModel = new PharmaceuticalCategory();
    $categories = $categoryModel->getAllPharmaceuticalCategory();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = [
            'name' => $_POST['name'],
            'category_id' => $_POST['category_id'],
            'description' => $_POST['description'],
            'stock_quantity' => $_POST['stock_quantity'],
            'unit_price' => $_POST['unit_price']
        ];
        $medicineModel = new Medicine();
        if ($medicineModel->create($data)){
            $this->redirect('pharmaceuticals');
        }
    }
    $this->render('pharmaceuticals/create', ['categories' => $categories])
}

public function edit($id){
$this->checkRole('admin');
$medicineModel = new Medicine();
$categoryModel = new PharmaceuticalCategory()
$medicine = $medicineModel->getById();
$categories = new $categoryModel->getAllPharmaceuticalCategory();
 if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'name' => $_POST['name'],
        'category_id' => $_POST['category_id'],
        'description' => $_POST['description'],
        'stock_quantity' => $_POST['stock_quantity'],
        'unit_price' => $_POST['unit_price']
    ];
    if ($medicineModel->update($id,$data)) {
        $this->redirect('/pharmaceuticals');
    }
 }
 $this->render('pharmaceuticals/edit', ['medicine' => $medicine, 'categories' => $categories]);
}

public function delete($id){
    $this->checkRole('admin');
    $medicineModel = new Medicine();
    if ($medicineModel->delete($id)){
        $this->redirect('/pharmaceuticals')
    }
}

public function categories() {
    $this->checkRole('admin');
    $categoryModel = new PharmaceuticalCategory();
    $categories = $categoryModel->getAllPharmaceuticalCategory();
    $this->render('pharmaceuticals/categories' , ['categories' => $categories])
}

public function createCategory(){
    $this->checkRole('admin')
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'name' => $_POST['name'],
        'description' => $_POST['description']
    ]
    $categoryModel = new PharmaceuticalCategory();
    if ($categoryModel->create($data)) {
        $this->redirect('/pharmaceuticals/categories')
    }
}
$this->render('pharmaceuticals/create-category');
}

public function editCategory($id) {
    $this->checkRole('admin');
    $categoryModel = new PharmaceuticalCategory();
    $category = $categoryModel->getById($id);
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = [
            'name' => $_POST['name'],
            'description' => $_POST['description']
        ]
        if ($categoryModel->update($id,$data)) {
            $this->redirect('/pharmaceuticals/categories')
        }
    }
    $this->render('pharmaceuticals/edit-category', ['category'] => $category)
}

public function deleteCategory($id) {
    $this->checkRole('admin');
    $categoryModel = new PharmaceuticalCategory();
    if ($categoryModel->delete($id)) {
        $this->redirect('/pharmaceuticals/categories')
    }
 }
}
?>