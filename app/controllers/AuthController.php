<?php
class AuthController extends Controller
{

    public function login()
    {
        $title = "Login - Lugia";
        $this->view("auth/login", compact('title'));
    }

    public function register()
    {
        $title = "Register - Lugia";
        $this->view("auth/register", compact('title'));
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
            $_SESSION['user_id'] = $airlineUser['id'];
            $_SESSION['user'] = $airlineUser;
            $_SESSION['role'] = $airlineUser['type'];
            $_SESSION['aid'] = $airlineUser['aid']; // <-- store airline ID
            header('Location: /airline/dashboard');
            exit;
        }


        // Regular user
        if ($user && $user['pass'] === $password) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user'] = $user;
            $_SESSION['role'] = $user['role']; // 'admin' or 'user'
            if ($user['role'] === 'admin') {
                header('Location: /admin/dashboard');
            } else {
                header('Location: /user/dashboard');
            }
            exit;
        }

        // Invalid login
        $_SESSION['error'] = 'Account does not exist.';
        header('Location: /');
        exit;
    }

    public function doRegister()
    {
        session_start();

        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirmPassword'] ?? '';

        // Basic validation
        if ($username === '' || $password === '' || $confirmPassword === '') {
            $_SESSION['error'] = "All fields are required.";
            header('Location: /register');
            exit;
        }

        // check password match
        if ($password !== $confirmPassword) {
            $_SESSION['error'] = "Passwords do not match.";
            header('Location: /register');
            exit;
        }

        $userModel = new User($GLOBALS['db']);

        // check if username already exists
        if ($userModel->findByUsername($username)) {
            $_SESSION['error'] = "Username already taken.";
            header('Location: /register');
            exit;
        }

        // create user with default role "user"
        $created = $userModel->create([
            'user' => $username,
            'pass' => $password,  // plain text for now
            'role' => 'user'
        ]);

        if ($created) {
            $_SESSION['success'] = "Registration successful. Please login.";
            header('Location: /');
            exit;
        } else {
            $_SESSION['error'] = "Failed to register. Please try again.";
            header('Location: /register');
            exit;
        }
    }


    public function logout()
    {
        session_start();           // Make sure session is started
        $_SESSION = [];            // Clear all session variables
        session_unset();           // Unset $_SESSION array
        session_destroy();         // Destroy the session
        setcookie(session_name(), '', time() - 3600, '/'); // Delete session cookie

        header('Location: /');     // Redirect to login page
        exit;
    }



}

