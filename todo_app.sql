CREATE DATABASE IF NOT EXISTS todo_app;

USE todo_app;

CREATE TABLE todos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    status ENUM('pending', 'completed') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Sample data
INSERT INTO todos (title, description, status) VALUES
('Learn PHP Routing', 'Build a custom router system in PHP', 'completed'),
('Create Todo App', 'Implement CRUD operations with MySQL', 'pending'),
('Add Authentication', 'Implement simple login system', 'pending'),
('Style the Interface', 'Make the app look professional', 'completed'),
('Write Documentation', 'Create setup instructions and README', 'pending');
