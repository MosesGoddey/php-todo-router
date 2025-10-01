<?php
require_once __DIR__ . '/../models/Todo.php';

class TodoController {
    private $todoModel;

    public function __construct() {
        $this->todoModel = new Todo();
    }

    public function index() {
        if (!$this->isLoggedIn()) {
            echo "<script>window.location.href = '/php-todo-router/login';</script>";
            exit;
        }

        $userId = $_SESSION['user_id'];
        $isAdmin = ($_SESSION['role'] ?? 'user') === 'admin';
        
        if ($isAdmin) {
            $todos = $this->todoModel->getAllWithUsers();
        } else {
            $todos = $this->todoModel->all($userId);
        }
        
        $this->view('todos/index', ['todos' => $todos, 'isAdmin' => $isAdmin]);
    }

    public function create() {
        if (!$this->isLoggedIn()) {
            echo "<script>window.location.href = '/php-todo-router/login';</script>";
            exit;
        }

        $this->view('todos/create');
    }

    public function store() {
        if (!$this->isLoggedIn()) {
            echo "<script>window.location.href = '/php-todo-router/login';</script>";
            exit;
        }

        $errors = $this->todoModel->validate($_POST);
        
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = $_POST;
            echo "<script>window.location.href = '/php-todo-router/todos/create';</script>";
            exit;
        }

        if ($this->todoModel->create($_POST)) {
            $_SESSION['success'] = 'Todo created successfully!';
        } else {
            $_SESSION['error'] = 'Failed to create todo';
        }

        echo "<script>window.location.href = '/php-todo-router/todos';</script>";
        exit;
    }

    public function edit($id) {
        if (!$this->isLoggedIn()) {
            echo "<script>window.location.href = '/php-todo-router/login';</script>";
            exit;
        }

        $todo = $this->todoModel->find($id);
        $isAdmin = ($_SESSION['role'] ?? 'user') === 'admin';
        
        if (!$todo) {
            $_SESSION['error'] = 'Todo not found';
            echo "<script>window.location.href = '/php-todo-router/todos';</script>";
            exit;
        }

        // Check if user owns this todo (unless admin)
        if (!$isAdmin && !$this->todoModel->belongsToUser($id, $_SESSION['user_id'])) {
            $_SESSION['error'] = 'Access denied';
            echo "<script>window.location.href = '/php-todo-router/todos';</script>";
            exit;
        }

        $this->view('todos/edit', ['todo' => $todo]);
    }

    public function update($id) {
        if (!$this->isLoggedIn()) {
            echo "<script>window.location.href = '/php-todo-router/login';</script>";
            exit;
        }

        $isAdmin = ($_SESSION['role'] ?? 'user') === 'admin';
        
        if (!$isAdmin && !$this->todoModel->belongsToUser($id, $_SESSION['user_id'])) {
            $_SESSION['error'] = 'Access denied';
            echo "<script>window.location.href = '/php-todo-router/todos';</script>";
            exit;
        }

        $errors = $this->todoModel->validate($_POST);
        
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = $_POST;
            echo "<script>window.location.href = '/php-todo-router/todos/edit/$id';</script>";
            exit;
        }

        if ($this->todoModel->update($id, $_POST)) {
            $_SESSION['success'] = 'Todo updated successfully!';
        } else {
            $_SESSION['error'] = 'Failed to update todo';
        }

        echo "<script>window.location.href = '/php-todo-router/todos';</script>";
        exit;
    }

    public function delete($id) {
        if (!$this->isLoggedIn()) {
            echo "<script>window.location.href = '/php-todo-router/login';</script>";
            exit;
        }

        $isAdmin = ($_SESSION['role'] ?? 'user') === 'admin';
        
        if (!$isAdmin && !$this->todoModel->belongsToUser($id, $_SESSION['user_id'])) {
            $_SESSION['error'] = 'Access denied';
            echo "<script>window.location.href = '/php-todo-router/todos';</script>";
            exit;
        }

        if ($this->todoModel->delete($id)) {
            $_SESSION['success'] = 'Todo deleted successfully!';
        } else {
            $_SESSION['error'] = 'Failed to delete todo';
        }

        echo "<script>window.location.href = '/php-todo-router/todos';</script>";
        exit;
    }

    public function toggleComplete($id) {
        if (!$this->isLoggedIn()) {
            echo "<script>window.location.href = '/php-todo-router/login';</script>";
            exit;
        }

        $isAdmin = ($_SESSION['role'] ?? 'user') === 'admin';
        
        if (!$isAdmin && !$this->todoModel->belongsToUser($id, $_SESSION['user_id'])) {
            $_SESSION['error'] = 'Access denied';
            echo "<script>window.location.href = '/php-todo-router/todos';</script>";
            exit;
        }

        if ($this->todoModel->toggleComplete($id)) {
            $_SESSION['success'] = 'Todo status updated!';
        } else {
            $_SESSION['error'] = 'Failed to update todo status';
        }

        echo "<script>window.location.href = '/php-todo-router/todos';</script>";
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