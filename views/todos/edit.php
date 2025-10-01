<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Todo</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f4f4f4; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"], textarea, select { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; font-size: 16px; }
        textarea { height: 100px; resize: vertical; }
        .btn { padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block; margin-right: 10px; border: none; cursor: pointer; font-size: 16px; }
        .btn-primary { background: #007bff; color: white; }
        .btn-secondary { background: #6c757d; color: white; }
        .alert { padding: 15px; margin-bottom: 20px; border-radius: 5px; }
        .alert-error { background: #f8d7da; color: #721c24; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit Todo</h1>

        <?php if (isset($_SESSION['errors'])): ?>
            <div class="alert alert-error">
                <ul style="margin: 0; padding-left: 20px;">
                    <?php foreach ($_SESSION['errors'] as $error): ?>
                        <li><?php echo $error; ?></li>
                    <?php endforeach; ?>
                </ul>
                <?php unset($_SESSION['errors']); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="/php-todo-router/todos/update/<?php echo $todo['id']; ?>">
            <div class="form-group">
                <label for="title">Title *</label>
                <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($_SESSION['old']['title'] ?? $todo['title']); ?>" required>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" placeholder="Optional description..."><?php echo htmlspecialchars($_SESSION['old']['description'] ?? $todo['description']); ?></textarea>
            </div>

            <div class="form-group">
                <label for="status">Status</label>
                <select id="status" name="status">
                    <option value="pending" <?php echo ($_SESSION['old']['status'] ?? $todo['status']) === 'pending' ? 'selected' : ''; ?>>Pending</option>
                    <option value="completed" <?php echo ($_SESSION['old']['status'] ?? $todo['status']) === 'completed' ? 'selected' : ''; ?>>Completed</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Update Todo</button>
            <a href="/php-todo-router/todos" class="btn btn-secondary">Cancel</a>
        </form>
        
        <?php unset($_SESSION['old']); ?>
    </div>
</body>
</html>