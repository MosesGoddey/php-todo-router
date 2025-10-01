<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f4f4f4; padding: 20px; }
        .container { max-width: 1000px; margin: 0 auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px; }
        .stat-card { background: #f8f9fa; padding: 20px; border-radius: 8px; text-align: center; border-left: 4px solid #007bff; }
        .stat-number { font-size: 2em; font-weight: bold; color: #007bff; }
        .stat-label { color: #666; margin-top: 5px; }
        .btn { padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block; margin-right: 10px; }
        .btn-primary { background: #007bff; color: white; }
        .btn-secondary { background: #6c757d; color: white; }
        .btn-info { background: #17a2b8; color: white; }
        .recent-todos { margin-top: 30px; }
        .todo-item { background: #f8f9fa; padding: 15px; margin-bottom: 10px; border-radius: 5px; border-left: 3px solid #28a745; }
        .user-badge { background: #e3f2fd; color: #1976d2; padding: 2px 8px; border-radius: 12px; font-size: 0.8em; }
    </style>
</head>
<body>
            <div class="header">
            <h1>Admin Dashboard</h1>
            <div>
                <a href="/php-todo-router/admin/stats" class="btn btn-info">View Statistics</a>
                <a href="/php-todo-router/admin/users" class="btn btn-info">Manage Users</a>
                <a href="/php-todo-router/todos" class="btn btn-primary">View All Todos</a>
                <a href="/php-todo-router/logout" class="btn btn-secondary">Logout</a>
            </div>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-number"><?php echo $stats['total_users']; ?></div>
                <div class="stat-label">Total Users</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo $stats['total_todos']; ?></div>
                <div class="stat-label">Total Todos</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo $stats['active_users']; ?></div>
                <div class="stat-label">Active Users</div>

            </div>

            <!-- <div style="text-align: center; margin: 20px 0;">
            <a href="/php-todo-router/admin/stats" class="btn btn-info">View Detailed Statistics</a>
            </div> -->
        </div>

        <div class="recent-todos">
            <h2>Recent Todos</h2>
            <?php if (empty($recentTodos)): ?>
                <p>No todos found.</p>
            <?php else: ?>
                <?php foreach ($recentTodos as $todo): ?>
                    <div class="todo-item">
                        <div>
                            <strong><?php echo htmlspecialchars($todo['title']); ?></strong>
                            <span class="user-badge"><?php echo htmlspecialchars($todo['username']); ?></span>
                        </div>
                        <div style="font-size: 0.9em; color: #666; margin-top: 5px;">
                            <?php echo date('M d, Y g:i A', strtotime($todo['created_at'])); ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>