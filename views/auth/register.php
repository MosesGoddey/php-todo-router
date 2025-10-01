<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <title>Register - Todo App</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f4f4f4; padding: 20px; display: flex; align-items: center; justify-content: center; min-height: 100vh; }
        .container { max-width: 500px; width: 100%; background: white; padding: 40px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"], input[type="email"], input[type="password"] { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; font-size: 16px; }
        .btn { padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block; margin-right: 10px; border: none; cursor: pointer; font-size: 16px; width: 100%; }
        .btn-primary { background: #007bff; color: white; }
        .alert { padding: 15px; margin-bottom: 20px; border-radius: 5px; }
        .alert-error { background: #f8d7da; color: #721c24; }
        .alert-success { background: #d4edda; color: #155724; }
        h1 { text-align: center; margin-bottom: 30px; color: #333; }
        .login-link { text-align: center; margin-top: 20px; }
        .login-link a { color: #007bff; text-decoration: none; }

        .password-wrapper {
      position: relative;
      width: 100%;
    }


    .password-wrapper input {
      width: 100%;
      padding: 10px;
      padding-right: 40px;
      border: 1px solid #ccc;
      border-radius: 5px;
      /* background-color: #e6f4f8ff; */
    }

    .button-show {
      position: absolute;
      top: 45%;
      right: 10px;
      transform: translateY(-50%);
      border: none;
      background: none;
      cursor: pointer;
      color: #5a4e4eff;
      display: none;
      font-size: 16px;
      padding: 0;
    }

    .button-show:hover {
      opacity: 0.6;
    }

    /* Validation styles */
.invalid {
  border: 1px solid red !important;
}
.valid {
  border: 1px solid green !important;
}


    </style>
</head>
<body>
    <div class="container">
        <h1>Create Account</h1>

        <?php if (isset($_SESSION['errors'])): ?>
            <div class="alert alert-error">
                <ul style="margin: 0; padding-left: 20px;">
                    <?php foreach ($_SESSION['errors'] as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
                <?php unset($_SESSION['errors']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-error">
                <?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="/php-todo-router/register">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($_SESSION['old']['username'] ?? ''); ?>" required>
            </div>

            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($_SESSION['old']['email'] ?? ''); ?>" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>

                <div class="password-wrapper">
                  <input type="password" id="password" name="password" class="js-input-password" required>

                  <button type="button" class="button-show js-show-password">
                    <i class="fa-solid fa-eye"></i>

                  </button>  
                </div>
            </div>

            <div class="form-group">

                <label for="confirm_password">Confirm Password</label>
                <div class="password-wrapper">
                 <nput type="password" id="confirm_password" name="confirm_password" class="js-input-password" required>
                
                  <button onclick="display()" type="button" class="button-show js-show-password">
                    <i class="fa-solid fa-eye"></i>

                  </button>
                </div>
                </div>

            <button type="submit" class="btn btn-primary">Create Account</button>
        </form>
        
        <div class="login-link">
            Already have an account? <a href="/php-todo-router/login">Sign in here</a>
        </div>
        
        <?php unset($_SESSION['old']); ?>

    </div>

        
<script>


      // Select ALL password fields + buttons
      const passwordWrappers = document.querySelectorAll(".password-wrapper");

      passwordWrappers.forEach(wrapper => {
        const passwordField = wrapper.querySelector(".js-input-password");
        const buttonElement = wrapper.querySelector(".js-show-password");

        // Show button only when input has text
        passwordField.addEventListener("input", function () {
          if (passwordField.value.length > 0) {
            buttonElement.style.display = "block";
          } else {
            buttonElement.style.display = "none";
          }
        });

        // Toggle visibility on click
        buttonElement.addEventListener("click", function () {
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
        });
      });


      // Confirm password validation
      const password = document.getElementById("password");
      const confirmPassword = document.getElementById("confirm_password");

      confirmPassword.addEventListener("input", () => {
        if (confirmPassword.value === "") {
          confirmPassword.classList.remove("valid", "invalid");
        } else if (confirmPassword.value !== password.value) {
          confirmPassword.classList.add("invalid");
          confirmPassword.classList.remove("valid");
        } else {
          confirmPassword.classList.add("valid");
          confirmPassword.classList.remove("invalid");
        }
      });

</script>


</body>
</html>