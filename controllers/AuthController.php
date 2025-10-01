<?php
require_once __DIR__ . '/../models/User.php';

class AuthController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    public function login() {
        // Check for remember me cookie
        if (!$this->isLoggedIn() && isset($_COOKIE['remember_token'])) {
            $user = $this->userModel->findByRememberToken($_COOKIE['remember_token']);
            if ($user) {
                $_SESSION['user_logged_in'] = true;
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];
                echo "<script>window.location.href = '/php-todo-router/todos';</script>";
                exit;
            }
        }

        if ($this->isLoggedIn()) {
            echo "<script>window.location.href = '/php-todo-router/todos';</script>";
            exit;
        }
        $this->view('auth/login');
    }

    public function authenticate() {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
        $rememberMe = isset($_POST['remember_me']);

        $user = $this->userModel->findByCredentials($username);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_logged_in'] = true;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['success'] = 'Logged in successfully!';

            // Handle remember me
            if ($rememberMe) {
                $token = bin2hex(random_bytes(32));
                setcookie('remember_token', $token, time() + (30 * 24 * 60 * 60), '/');
                $this->userModel->setRememberToken($user['id'], $token);
            }

            echo "<script>window.location.href = '/php-todo-router/todos';</script>";
            exit;
        }

        $_SESSION['error'] = 'Invalid credentials';
        echo "<script>window.location.href = '/php-todo-router/login';</script>";
        exit;
    }

    public function showRegister() {
        if ($this->isLoggedIn()) {
            echo "<script>window.location.href = '/php-todo-router/todos';</script>";
            exit;
        }
        $this->view('auth/register');
    }

    public function register() {
        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';
        
        $errors = [];
        
        if (empty($username)) {
            $errors[] = 'Username is required';
        } elseif (strlen($username) < 3) {
            $errors[] = 'Username must be at least 3 characters';
        }
        
        if (empty($email)) {
            $errors[] = 'Email is required';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Invalid email format';
        }
        
        if (empty($password)) {
            $errors[] = 'Password is required';
        } elseif (strlen($password) < 6) {
            $errors[] = 'Password must be at least 6 characters';
        }
        
        if ($password !== $confirmPassword) {
            $errors[] = 'Passwords do not match';
        }
        
        if ($this->userModel->checkExistence($username, $email)) {
            $errors[] = 'Username or email already exists';
        }
        
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = $_POST;
            echo "<script>window.location.href = '/php-todo-router/register';</script>";
            exit;
        }
        
        if ($this->userModel->create([
            'username' => $username,
            'email' => $email,
            'password' => $password
        ])) {
            $_SESSION['success'] = 'Registration successful! Please log in.';
            echo "<script>window.location.href = '/php-todo-router/login';</script>";
            exit;
        }
        
        $_SESSION['error'] = 'Registration failed. Please try again.';
        echo "<script>window.location.href = '/php-todo-router/register';</script>";
        exit;
    }

    public function logout() {
        if (isset($_COOKIE['remember_token'])) {
            setcookie('remember_token', '', time() - 3600, '/');
            if (isset($_SESSION['user_id'])) {
                $this->userModel->clearRememberToken($_SESSION['user_id']);
            }
        }
        session_destroy();
        echo "<script>window.location.href = '/php-todo-router/login';</script>";
        exit;
    }

    private function view($template, $data = []) {
        extract($data);
        $viewFile = __DIR__ . "/../views/$template.php";
        
        if (file_exists($viewFile)) {
            include $viewFile;
        } else {
            echo "View not found: $template";
        }
    }

    private function isLoggedIn() {
        return isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true;
    }
}