<?php
class App {
    protected $controller = 'MahasiswaController'; // Default controller
    protected $method = 'index'; // Default method
    protected $params = []; // Default params

    public function __construct() {
        $url = $this->parseUrl();

        // Check if controller exists in the URL
        if ($url && isset($url[0]) && file_exists('../app/Controllers/' . $url[0] . 'Controller.php')) {
            $this->controller = $url[0] . 'Controller';
            unset($url[0]);
        }

        require_once '../app/Controllers/' . $this->controller . '.php';
        $this->controller = new $this->controller;

        // Check if method exists in the URL and in the controller
        if ($url && isset($url[1]) && method_exists($this->controller, $url[1])) {
            $this->method = $url[1];
            unset($url[1]);
        }

        // Get remaining URL parameters
        $this->params = $url ? array_values($url) : [];

        // Call the method on the controller, passing parameters
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    // Parse the URL to extract controller, method, and parameters
    public function parseUrl() {
        if (isset($_GET['url'])) {
            return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
        return []; // Return empty array if no URL is set
    }
}
