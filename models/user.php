<?php
class User {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function create($userData) {
        $stmt = $this->db->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
        return $stmt->execute([
            $userData['username'],
            $userData['email'],
            password_hash($userData['password'], PASSWORD_DEFAULT),
            $userData['role'] ?? 'user'
        ]);
    }

    public function findByCredentials($usernameOrEmail) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE (username = ? OR email = ?) AND status = 'active'");
        $stmt->execute([$usernameOrEmail, $usernameOrEmail]);
        return $stmt->fetch();
    }

    public function findById($id) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function getAllUsers() {
        $stmt = $this->db->query("SELECT id, username, email, role, status, created_at FROM users ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }

    public function checkExistence($username, $email) {
        $stmt = $this->db->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$username, $email]);
        return $stmt->fetch();
    }

    public function getSystemStats() {
        $userCount = $this->db->query("SELECT COUNT(*) as count FROM users")->fetch()['count'];
        $todoCount = $this->db->query("SELECT COUNT(*) as count FROM todos")->fetch()['count'];
        $activeUsers = $this->db->query("SELECT COUNT(*) as count FROM users WHERE status = 'active'")->fetch()['count'];
        
        return [
            'total_users' => $userCount,
            'total_todos' => $todoCount,
            'active_users' => $activeUsers
        ];
    }

    public function getDetailedStats() {
        $userCount = $this->db->query("SELECT COUNT(*) as count FROM users")->fetch()['count'];
        $todoCount = $this->db->query("SELECT COUNT(*) as count FROM todos")->fetch()['count'];
        $activeUsers = $this->db->query("SELECT COUNT(*) as count FROM users WHERE status = 'active'")->fetch()['count'];
        $completedTodos = $this->db->query("SELECT COUNT(*) as count FROM todos WHERE status = 'completed'")->fetch()['count'];
        $pendingTodos = $this->db->query("SELECT COUNT(*) as count FROM todos WHERE status = 'pending'")->fetch()['count'];
        
        $completionRate = $todoCount > 0 ? ($completedTodos / $todoCount) * 100 : 0;
        
        return [
            'total_users' => $userCount,
            'total_todos' => $todoCount,
            'active_users' => $activeUsers,
            'completed_todos' => $completedTodos,
            'pending_todos' => $pendingTodos,
            'completion_rate' => $completionRate
        ];
    }

    public function getRecentActivity() {
        $stmt = $this->db->query("
            SELECT u.username, 'created a todo' as action, t.created_at 
            FROM todos t 
            JOIN users u ON t.user_id = u.id 
            ORDER BY t.created_at DESC 
            LIMIT 10
        ");
        return $stmt->fetchAll();
    }

    public function setRememberToken($userId, $token) {
        $hashedToken = password_hash($token, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare("UPDATE users SET remember_token = ? WHERE id = ?");
        return $stmt->execute([$hashedToken, $userId]);
    }

    public function findByRememberToken($token) {
        $stmt = $this->db->query("SELECT * FROM users WHERE remember_token IS NOT NULL");
        $users = $stmt->fetchAll();
        
        foreach ($users as $user) {
            if (password_verify($token, $user['remember_token'])) {
                return $user;
            }
        }
        
        return false;
    }

    public function clearRememberToken($userId) {
        $stmt = $this->db->prepare("UPDATE users SET remember_token = NULL WHERE id = ?");
        return $stmt->execute([$userId]);
    }
}