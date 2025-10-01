<?php
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Todo.php';

class AdminController {
    private $userModel;
    private $todoModel;

    public function __construct() {
        $this->userModel = new User();
        $this->todoModel = new Todo();
    }

    public function dashboard() {
        if (!$this->isAdmin()) {
            $_SESSION['error'] = 'Access denied';
            echo "<script>window.location.href = '/php-todo-router/todos';</script>";
            exit;
        }

        $stats = $this->userModel->getSystemStats();
        $recentTodos = $this->todoModel->getAllWithUsers();
        $recentTodos = array_slice($recentTodos, 0, 5); // Latest 5 todos

        $this->view('admin/dashboard', ['stats' => $stats, 'recentTodos' => $recentTodos]);
    }

    public function users() {
        if (!$this->isAdmin()) {
            $_SESSION['error'] = 'Access denied';
            echo "<script>window.location.href = '/php-todo-router/todos';</script>";
            exit;
        }

        $users = $this->userModel->getAllUsers();
        $this->view('admin/users', ['users' => $users]);
    }

    public function stats() {
        if (!$this->isAdmin()) {
            $_SESSION['error'] = 'Access denied';
            echo "<script>window.location.href = '/php-todo-router/todos';</script>";
            exit;
        }

        $stats = $this->userModel->getDetailedStats();
        $recentActivity = $this->userModel->getRecentActivity();
        
        $this->view('admin/stats', ['stats' => $stats, 'recentActivity' => $recentActivity]);
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

    private function isAdmin() {
        return isset($_SESSION['user_logged_in']) && 
               $_SESSION['user_logged_in'] === true && 
               $_SESSION['role'] === 'admin';
    }
}