<?php

abstract class Controller
{
    public function view($view, $data = [])
    {
        $viewPath = __DIR__ . '/../views/' . $view . '.php';
        if (file_exists($viewPath)) {
            require_once $viewPath;
        } else {
            die("View does not exist.");
        }
    }

    public function model($model)
    {
        // Sertakan Database.php sebelum memuat model
        require_once __DIR__ . '/Database.php';

        // Gunakan jalur absolut dengan __DIR__
        $modelPath = __DIR__ . '/../models/' . $model . '.php';
        if (file_exists($modelPath)) {
            require_once $modelPath;
            if (class_exists($model)) {
                return new $model();
            } else {
                die("Model class '{$model}' does not exist.");
            }
        } else {
            die("Model does not exist.");
        }
    }

    public function logout()
    {
        Session::destroy();
        header("Location: " . BASE_URL);
        exit();
    }

    public function setUiState()
    {
        foreach ($_POST['set_ui_state'] as $key => $value) {
            Session::set($key, $value);
        }
    }

    public function error($code = 404, $message = "Page not found")
    {
        $this->view('error/index', ["code" => $code, "message" => $message]);
        exit();
    }
}
?>
