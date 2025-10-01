<?php
class Todo {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function all($userId = null) {
        if ($userId) {
            $stmt = $this->db->prepare("SELECT * FROM todos WHERE user_id = ? ORDER BY created_at DESC");
            $stmt->execute([$userId]);
        } else {
            $stmt = $this->db->query("SELECT * FROM todos ORDER BY created_at DESC");
        }
        return $stmt->fetchAll();
    }

    public function getAllWithUsers() {
        $stmt = $this->db->query("
            SELECT t.*, u.username, u.email 
            FROM todos t 
            JOIN users u ON t.user_id = u.id 
            ORDER BY t.created_at DESC
        ");
        return $stmt->fetchAll();
    }

    public function find($id) {
        $stmt = $this->db->prepare("SELECT * FROM todos WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create($data) {
        $userId = $_SESSION['user_id'] ?? 1;
        
        $stmt = $this->db->prepare("INSERT INTO todos (title, description, status, user_id) VALUES (?, ?, ?, ?)");
        return $stmt->execute([
            $data['title'],
            $data['description'] ?? null,
            $data['status'] ?? 'pending',
            $userId
        ]);
    }

    public function update($id, $data) {
        $stmt = $this->db->prepare("UPDATE todos SET title = ?, description = ?, status = ? WHERE id = ?");
        return $stmt->execute([
            $data['title'],
            $data['description'] ?? null,
            $data['status'] ?? 'pending',
            $id
        ]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM todos WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function toggleComplete($id) {
        $stmt = $this->db->prepare("UPDATE todos SET status = CASE WHEN status = 'pending' THEN 'completed' ELSE 'pending' END WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function belongsToUser($todoId, $userId) {
        $stmt = $this->db->prepare("SELECT user_id FROM todos WHERE id = ?");
        $stmt->execute([$todoId]);
        $todo = $stmt->fetch();
        return $todo && $todo['user_id'] == $userId;
    }

    public function validate($data) {
        $errors = [];
        
        if (empty(trim($data['title'] ?? ''))) {
            $errors[] = 'Title is required';
        }
        
        if (strlen($data['title'] ?? '') > 255) {
            $errors[] = 'Title must not exceed 255 characters';
        }

        return $errors;
    }
}