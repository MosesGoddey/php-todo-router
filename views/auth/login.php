<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Todo App</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f4f4f4; padding: 20px; display: flex; align-items: center; justify-content: center; min-height: 100vh; }
        .container { max-width: 400px; width: 100%; background: white; padding: 40px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"], input[type="password"] { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; font-size: 16px; }
        .checkbox-group { display: flex; align-items: center; margin-bottom: 20px; }
        .checkbox-group input[type="checkbox"] { margin-right: 8px; }
        .btn { padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block; margin-right: 10px; border: none; cursor: pointer; font-size: 16px; width: 100%; }
        .btn-primary { background: #007bff; color: white; }
        .alert { padding: 15px; margin-bottom: 20px; border-radius: 5px; }
        .alert-error { background: #f8d7da; color: #721c24; }
        .alert-success { background: #d4edda; color: #155724; }
        h1 { text-align: center; margin-bottom: 30px; color: #333; }
        .login-info { background: #e9ecef; padding: 15px; border-radius: 5px; margin-bottom: 20px; font-size: 14px; }
        .register-link { text-align: center; margin-top: 20px; }
        .register-link a { color: #007bff; text-decoration: none; }


         .password-wrapper {
      position: relative;
      width: 100%;
    }

    .password-wrapper input {
      width: 100%;
      padding: 10px;
      padding-right: 40px; /* leave space for eye button */
      border: 1px solid #ccc;
      border-radius: 5px;
      /* background-color: #e6f4f8ff; */
      box-sizing: border-box;
    }

    .button-show {
      position: absolute;
      top: 50%;
      right: 10px;
      transform: translateY(-50%); /* vertical centering */
      border: none;
      background: none;
      cursor: pointer;
      color: #5a4e4eff;
      display: none;   /* only shows when typing */
      font-size: 16px;
      padding: 0;
      /* line-height: 1; */
    }

    .button-show:hover {
      opacity: 0.6;
    }

    </style>
</head>
<body>
    <div class="container">
        <h1>Todo App Login</h1>

        <!-- <div class="login-info">
            <strong>Demo Admin Credentials:</strong><br>
            Email: <code>admin@todoapp.com</code><br>
            Password: <code>password</code>
        </div> -->

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-error">
                <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="/php-todo-router/login">
            <div class="form-group">
                <label for="username">Username or Email</label>
                <input type="text" id="username" name="username" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>

                 <div class="password-wrapper">
                <input type="password" id="password" name="password" class="js-input-password">

                <button onclick="display()" type="button" class="button-show js-show-password">
      <i class="fa-solid fa-eye"></i>
    </button>
                </div> 
            </div>
            <div class="checkbox-group">
                <input type="checkbox" id="remember_me" name="remember_me">
                <label for="remember_me">Remember me for 30 days</label>
            </div>

            <button type="submit" class="btn btn-primary">Login</button>
        </form>
        
        <div class="register-link">
            Don't have an account? <a href="/php-todo-router/register">Create one here</a>
        </div>
    </div>


    <script>
          const buttonElement = document.querySelector('.js-show-password');
  const passwordField = document.querySelector('.js-input-password');

  passwordField.addEventListener('input', function () {
    if (passwordField.value.length > 0) {
      buttonElement.style.display = 'block';
    } else {
      buttonElement.style.display = 'none';
    }
  });

  function display() {
    const icon = buttonElement.querySelector("i");
    if (passwordField.type === "password") {
      passwordField.type = "text";
      icon.classList.remove("fa-eye");
      icon.classList.add("fa-eye-slash");
    } else {
      passwordField.type = "password";
      icon.classList.remove("fa-eye-slash");
      icon.classList.add("fa-eye");
    }
  }

    </script>
</body>
</html>