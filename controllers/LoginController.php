<?php 

require_once __DIR__. '/../models/User.php';

class LoginController extends BaseController {
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = md5($_POST['password']);

            $userModel = new User();
            $user = $userModel->authenticate($username, $password);

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['role'] = $user['role'];
                $this->redirect('/dashboard');
            } else {
                $error = "Invalid username or password";
                $this->render('login/login', ['error' => $error]);
            }
        } else {
            $this->render('login/login');
        }
    }

    public function logout() {
        session_destroy();
        $this->redirect('/login');
    }
}

?>