<?php

class BaseController {
    protected function render($view, $data = []){
        extract($data);
        ob_start();
     require_once __DIR__. '/../views/' .$view . '.php';
     $content = ob_get_clean();
     require_once __DIR__ . '/../views/layout.php';
    }

    protected function redirect($url) {
        header('Location: ' .$url)
        exit;
    }

    protected function checkRole($role) {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== $role) {
            $this->redirect('/login')
        }
    }
}
?>