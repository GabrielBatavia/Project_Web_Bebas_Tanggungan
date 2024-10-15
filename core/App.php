<?php
class App {
    protected $controller = 'MahasiswaController';
    protected $method = 'index';
    protected $params = [];

    public function __construct() {
        $url = $this->parseUrl();
        
        // Check for controller existence
        if (file_exists('../app/Controllers/' . $url[0] . 'Controller.php')) {
            $this->controller = $url[0] . 'Controller';
            unset($url[0]);
        }
        
        require_once '../app/Controllers/' . $this->controller . '.php';
        $this->controller = new $this->controller;

        // Check for method existence
        if (isset($url[1])) {
            if (method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            }
        }

        // Parameters
        $this->params = $url ? array_values($url) : [];

        // Call the method with parameters
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    public function parseUrl() {
        if (isset($_GET['url'])) {
            return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
    }
}
