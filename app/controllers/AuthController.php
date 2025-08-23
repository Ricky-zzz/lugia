<?php
class AuthController extends Controller
{

    public function login()
    {
        $title = "Login - Lugia";
        $this->view("auth/login", compact('title'));
    }

    public function doLogin()
    {
        session_start();

        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        $airlineUserModel = new AirlineUser($GLOBALS['db']);
        $userModel = new User($GLOBALS['db']);

        // fetch users from DB
        $airlineUser = $airlineUserModel->findByUsername($username);
        $user = $userModel->findByUsername($username);

        // Airline user first
        if ($airlineUser && $airlineUser['pass'] === $password) {
            $_SESSION['user'] = $airlineUser;
            $_SESSION['role'] = $airlineUser['type']; // maybe 'pilot', 'staff', etc.
            header('Location: /airline/dashboard');
            exit;
        }

        // Regular user
        if ($user && $user['pass'] === $password) {
            $_SESSION['user'] = $user;
            $_SESSION['role'] = $user['role']; // 'admin' or 'user'
            if ($user['role'] === 'admin') {
                header('Location: /admin/dashboard');
            } else {
                header('Location: /user/home');
            }
            exit;
        }

        // Invalid login
        $_SESSION['error'] = 'Account does not exist.';
        header('Location: /');
        exit;
    }

}

