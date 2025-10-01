<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Statistics</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f4f4f4; padding: 20px; }
        .container { max-width: 1000px; margin: 0 auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .btn { padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block; margin-right: 10px; }
        .btn-secondary { background: #6c757d; color: white; }
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 30px; }
        .stat-card { background: #f8f9fa; padding: 25px; border-radius: 8px; text-align: center; }
        .stat-number { font-size: 2.5em; font-weight: bold; color: #007bff; margin-bottom: 10px; }
        .stat-label { color: #666; font-size: 1.1em; }
        .chart-container { background: #f8f9fa; padding: 20px; border-radius: 8px; margin-bottom: 20px; }
        .user-activity { margin-top: 30px; }
        .activity-item { background: #fff; border: 1px solid #ddd; padding: 15px; margin-bottom: 10px; border-radius: 5px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>System Statistics</h1>
            <div>
                <a href="/php-todo-router/admin" class="btn btn-secondary">Back to Dashboard</a>
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
            <div class="stat-card">
                <div class="stat-number"><?php echo $stats['completed_todos']; ?></div>
                <div class="stat-label">Completed Todos</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo $stats['pending_todos']; ?></div>
                <div class="stat-label">Pending Todos</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo number_format($stats['completion_rate'], 1); ?>%</div>
                <div class="stat-label">Completion Rate</div>
            </div>
        </div>

        <div class="chart-container">
            <h3>User Registration Over Time</h3>
            <p>Detailed analytics would go here with charts/graphs</p>
        </div>

        <div class="user-activity">
            <h3>Recent User Activity</h3>
            <?php foreach ($recentActivity as $activity): ?>
                <div class="activity-item">
                    <strong><?php echo htmlspecialchars($activity['username']); ?></strong>
                    <?php echo $activity['action']; ?>
                    <span style="color: #666; float: right;">
                        <?php echo date('M d, Y g:i A', strtotime($activity['created_at'])); ?>
                    </span>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>