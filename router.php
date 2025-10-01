<?php
class Router {
    private $routes = [];
    private $basePath;

    public function __construct($basePath = '') {
        $scriptName = dirname($_SERVER['SCRIPT_NAME']);
        $this->basePath = $scriptName !== '/' ? $scriptName : '';
    }

    public function get($route, $callback) {
        $this->addRoute('GET', $route, $callback);
    }

    public function post($route, $callback) {
        $this->addRoute('POST', $route, $callback);
    }

    private function addRoute($method, $route, $callback) {
        $route = trim($route, '/');
        $this->routes[] = [
            'method' => $method,
            'route' => $route,
            'callback' => $callback
        ];
    }

    public function dispatch() {
        $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $requestUri = trim($requestUri, '/');
        
        // Remove base path from request URI
        if ($this->basePath) {
            $basePathClean = trim($this->basePath, '/');
            if (strpos($requestUri, $basePathClean) === 0) {
                $requestUri = substr($requestUri, strlen($basePathClean));
                $requestUri = trim($requestUri, '/');
            }
        }

        $requestMethod = $_SERVER['REQUEST_METHOD'];

        foreach ($this->routes as $route) {
            if ($route['method'] !== $requestMethod) {
                continue;
            }

            $pattern = $this->buildPattern($route['route']);
            
            if (preg_match($pattern, $requestUri, $matches)) {
                array_shift($matches); // Remove full match
                return $this->callCallback($route['callback'], $matches);
            }
        }

        $this->show404();
    }

    private function buildPattern($route) {
        // Convert {id} to ([^/]+) to capture parameters
        $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '([^/]+)', $route);
        return '#^' . $pattern . '$#';
    }

    private function callCallback($callback, $params = []) {
        if (is_callable($callback)) {
            return call_user_func_array($callback, $params);
        }

        if (is_string($callback) && strpos($callback, '@') !== false) {
            [$controller, $method] = explode('@', $callback);
            $controllerFile = __DIR__ . "/controllers/{$controller}.php";

            if (file_exists($controllerFile)) {
                require_once $controllerFile;

                if (class_exists($controller)) {
                    $controllerInstance = new $controller();

                    if (method_exists($controllerInstance, $method)) {
                        return call_user_func_array([$controllerInstance, $method], $params);
                    }
                }
            }
        }

        $this->show404();
    }

    private function show404() {
        http_response_code(404);
        echo "<h1>404 - Page Not Found</h1>";
        echo "<p>The requested page could not be found.</p>";
        echo "<a href='{$this->basePath}/todos'>Go to Todos</a>";
        exit;
    }
}