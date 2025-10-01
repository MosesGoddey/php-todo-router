<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo App</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f4f4f4; padding: 20px; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .btn { padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block; margin-right: 10px; }
        .btn-primary { background: #007bff; color: white; }
        .btn-success { background: #28a745; color: white; }
        .btn-danger { background: #dc3545; color: white; }
        .btn-warning { background: #ffc107; color: black; }
        .btn-secondary { background: #6c757d; color: white; }
        .btn-info { background: #17a2b8; color: white;
        margin-bottom: 10px;
        }
        .alert { padding: 15px; margin-bottom: 20px; border-radius: 5px; }
        .alert-success { background: #d4edda; color: #155724; }
        .alert-error { background: #f8d7da; color: #721c24; }
        .todo-item { background: #f8f9fa; padding: 20px; margin-bottom: 15px; border-radius: 8px; border-left: 4px solid #007bff; }
        .todo-item.completed { border-left-color: #28a745; opacity: 0.8; }
        .todo-item.completed h3 { text-decoration: line-through; }
        .todo-meta { color: #6c757d; font-size: 0.9em; margin-bottom: 10px; }
        .todo-actions { margin-top: 15px; }
        .status-badge { padding: 3px 8px; border-radius: 15px; font-size: 0.8em; }
        .status-pending { background: #fff3cd; color: #856404; }
        .status-completed { background: #d1ecf1; color: #0c5460; }
        .admin-panel { background: #e3f2fd; padding: 15px; margin-bottom: 20px; border-radius: 5px; border-left: 4px solid #2196f3; }
        .user-info { font-size: 0.9em; color: #666; margin-bottom: 10px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>
                <?php if ($isAdmin): ?>
                    Admin Dashboard - All Todos
                <?php else: ?>
                    My Todos
                <?php endif; ?>
            </h1>
            <div>
                <span>Welcome, <?php echo $_SESSION['username'] ?? 'User'; ?>!</span>
                <?php if ($isAdmin): ?>
                    <span style="background: #17a2b8; color: white; padding: 2px 6px; border-radius: 3px; font-size: 0.8em; margin-left: 5px;">ADMIN</span>
                    <a href="/php-todo-router/admin" class="btn btn-info">Admin Panel</a>
                <?php endif; ?>
                <a href="/php-todo-router/todos/create" class="btn btn-primary">Add New Todo</a>
                <a href="/php-todo-router/logout" class="btn btn-secondary">Logout</a>
            </div>
        </div>

        <?php if ($isAdmin): ?>
            <div class="admin-panel">
                <h3>System Overview</h3>
                <p>Total Todos: <?php echo count($todos); ?> | <a href="/php-todo-router/admin/users">Manage Users</a></p>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-error">
                <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <?php if (empty($todos)): ?>
            <div style="text-align: center; padding: 50px; color: #6c757d;">
                <h3>No todos yet!</h3>
                <p>Create your first todo to get started.</p>
                <a href="/php-todo-router/todos/create" class="btn btn-primary">Add Todo</a>
            </div>
        <?php else: ?>
            <?php foreach ($todos as $todo): ?>
                <div class="todo-item <?php echo $todo['status']; ?>">
                    <?php if ($isAdmin): ?>
                        <div class="user-info">
                            Created by: <strong><?php echo htmlspecialchars($todo['username']); ?></strong> (<?php echo htmlspecialchars($todo['email']); ?>)
                        </div>
                    <?php endif; ?>
                    
                    <div class="todo-meta">
                        <span class="status-badge status-<?php echo $todo['status']; ?>">
                            <?php echo ucfirst($todo['status']); ?>
                        </span>
                        <span> • Created: <?php echo date('M d, Y g:i A', strtotime($todo['created_at'])); ?></span>
                    </div>
                    
                    <h3><?php echo htmlspecialchars($todo['title']); ?></h3>
                    
                    <?php if ($todo['description']): ?>
                        <p><?php echo nl2br(htmlspecialchars($todo['description'])); ?></p>
                    <?php endif; ?>
                    
                    <div class="todo-actions">
                        <a href="/php-todo-router/todos/complete/<?php echo $todo['id']; ?>" class="btn <?php echo $todo['status'] === 'completed' ? 'btn-warning' : 'btn-success'; ?>">
                            <?php echo $todo['status'] === 'completed' ? 'Mark Pending' : 'Mark Complete'; ?>
                        </a>
                        <a href="/php-todo-router/todos/edit/<?php echo $todo['id']; ?>" class="btn btn-primary">Edit</a>
                        <a href="/php-todo-router/todos/delete/<?php echo $todo['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this todo?')">Delete</a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</body>
</html>