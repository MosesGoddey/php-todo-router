# Custom PHP Router Todo App

A simple Todo application built with a custom PHP router, MySQL database, and MVC architecture.

## Features

- ✅ Custom routing system with dynamic parameters
- ✅ Full CRUD operations for todos
- ✅ Simple authentication system
- ✅ Input validation
- ✅ Responsive design
- ✅ Session management
- ✅ Status toggle (pending/completed)

## Requirements

- PHP 7.4 or higher
- MySQL 5.7 or higher
- Apache/Nginx web server
- XAMPP/WAMP (for local development)

## Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/yourusername/php-todo-router.git
   cd php-todo-router
   ```

2. **Database Setup**
   - Create a MySQL database named `todo_app`
   - Import the SQL file: `mysql -u root -p todo_app < todo_app.sql`
   - Or run the SQL commands manually in phpMyAdmin

3. **Configure Database Connection**
   - Edit `config/database.php`
   - Update database credentials if needed:
     ```php
     $host = 'localhost';
     $db = 'todo_app';
     $user = 'root';
     $password = '';
     ```

4. **Setup Web Server**
   
   **For XAMPP:**
   - Copy project folder to `C:\xampp\htdocs\php-todo-router`
   - Start Apache and MySQL in XAMPP Control Panel
   - Access: `http://localhost/php-todo-router`

   **For development server:**
   ```bash
   php -S localhost:8000 -t public
   ```

5. **Login Credentials**
   - Username: `admin`
   - Password: `password`

## Project Structure

```
project/
├── index.php              # Entry point
├── router.php             # Custom router class
├── todo_app.sql          # Database dump
├── README.md             # This file
├── config/
│   └── database.php      # Database connection
├── controllers/
│   ├── TodoController.php # Todo CRUD operations
│   └── AuthController.php # Authentication logic
├── models/
│   └── Todo.php          # Todo model with database methods
└── views/
    ├── todos/
    │   ├── index.php     # List all todos
    │   ├── create.php    # Create todo form
    │   └── edit.php      # Edit todo form
    └── auth/
        └── login.php     # Login form
```

## How It Works

### Custom Router

The router (`router.php`) handles URL routing:

```php
// Static routes
$router->get('/todos', 'TodoController@index');

// Dynamic routes with parameters
$router->get('/todos/edit/{id}', 'TodoController@edit');
$router->post('/todos/update/{id}', 'TodoController@update');
```

### MVC Architecture

- **Models**: Handle database operations (`models/Todo.php`)
- **Views**: Display HTML templates (`views/`)
- **Controllers**: Handle business logic (`controllers/`)

### Authentication

Simple session-based authentication:
- Username: `admin`, Password: `password`
- Protected routes redirect to login if not authenticated
- Session management for login state

## API Routes

| Method | Route | Description |
|--------|-------|-------------|
| GET | `/` | Redirect to todos |
| GET | `/todos` | List all todos |
| GET | `/todos/create` | Show create form |
| POST | `/todos/store` | Save new todo |
| GET | `/todos/edit/{id}` | Show edit form |
| POST | `/todos/update/{id}` | Update todo |
| GET | `/todos/delete/{id}` | Delete todo |
| GET | `/todos/complete/{id}` | Toggle todo status |
| GET | `/login` | Show login form |
| POST | `/login` | Authenticate user |
| GET | `/logout` | Logout user |

## Database Schema

```sql
CREATE TABLE todos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    status ENUM('pending', 'completed') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

## Features Implemented

### ✅ Part 1: Custom Router
- [x] Reads current request URI
- [x] Matches against defined routes
- [x] Supports static routes (`/todos`)
- [x] Supports dynamic routes (`/todos/edit/{id}`)
- [x] Calls correct controller methods
- [x] Returns 404 for unmatched routes

### ✅ Part 2: Database Setup
- [x] MySQL database `todo_app`
- [x] `todos` table with required fields
- [x] PDO connection with error handling

### ✅ Part 3: Todo App Routes
- [x] GET `/todos` - List todos
- [x] GET `/todos/create` - Create form
- [x] POST `/todos/store` - Save todo
- [x] GET `/todos/edit/{id}` - Edit form
- [x] POST `/todos/update/{id}` - Update todo
- [x] GET `/todos/delete/{id}` - Delete todo

### ✅ Part 4: Project Structure
- [x] Organized MVC structure
- [x] Proper file separation
- [x] Clean code organization

### ✅ Bonus Features
- [x] Toggle complete status (`/todos/complete/{id}`)
- [x] Input validation (title required)
- [x] Simple login system
- [x] Session management
- [x] Responsive design
- [x] Flash messages
- [x] CSRF protection considerations

## Troubleshooting

### Common Issues

1. **Database Connection Error**
   ```
   Error: Database connection failed
   ```
   - Check MySQL is running
   - Verify database credentials in `config/database.php`
   - Ensure `todo_app` database exists

2. **404 Errors**
   ```
   Error: 404 - Page Not Found
   ```
   - Check Apache mod_rewrite is enabled
   - Verify .htaccess file exists (if using Apache)
   - Ensure routes are properly defined in `index.php`

3. **Permission Issues**
   ```
   Error: Permission denied
   ```
   - Set proper file permissions (755 for directories, 644 for files)
   - Ensure web server has read access to project files

### Apache Configuration

If using Apache, create `.htaccess` file in project root:

```apache
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.+)$ index.php [QSA,L]
```

## Learning Objectives Achieved

1.  **Custom Routing**: Built from scratch without frameworks
2.  **MVC Pattern**: Proper separation of concerns
3.  **Database Integration**: PDO with prepared statements
4.  **CRUD Operations**: Complete Create, Read, Update, Delete
5.  **Security**: Input validation, authentication, XSS protection
6.  **Session Management**: Login/logout functionality
7.  **Error Handling**: Proper error messages and 404 handling

## Next Steps

To extend this application:

1. **Enhanced Security**
   - Password hashing
   - CSRF tokens
   - SQL injection prevention
   - Input sanitization

2. **Advanced Features**
   - User registration
   - Multiple users
   - Categories/tags
   - Due dates
   - File attachments

3. **Modern Improvements**
   - Composer autoloading
   - Environment variables
   - Database migrations
   - Unit testing
   - API endpoints (JSON responses)

## License

MIT License - Feel free to use this code for learning purposes.

## Contributing

1. Fork the repository
2. Create feature branch (`git checkout -b feature/new-feature`)
3. Commit changes (`git commit -am 'Add new feature'`)
4. Push to branch (`git push origin feature/new-feature`)
5. Create Pull Request

