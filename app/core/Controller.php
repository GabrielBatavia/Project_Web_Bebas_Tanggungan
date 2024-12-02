<?php

abstract class Controller
{
    public function view($view, $data = [])
    {
        if (file_exists("../app/views/" . $view . ".php")) {
            require_once "../app/views/" . $view . ".php";
        } else {
            die("View does not exist.");
        }
    }

    public function model($model)
    {
        if (file_exists("../app/models/" . $model . ".php")) {
            require_once "../app/models/" . $model . ".php";
            return new $model();
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