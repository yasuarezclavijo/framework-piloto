<?php
class Launcher {
    private $route;

    public function __construct($path) {
        $this->route = explode("/", $path);
        $this->controllerInvoke();
    }

    private function controllerInvoke () {
        $name_controller = $this->route[0];
        $name_function = $this->route[1] ?? 'index';
        $filename_controller = 'application/controllers/' . ucfirst($name_controller) . "Controller.php";
        if (is_readable($filename_controller)) {
            require_once $filename_controller;
            $className = ucfirst($name_controller) . "Controller";
            $controller = new $className;
            
            if (is_callable([$controller, $name_function])) {
                call_user_func([$controller, $name_function]);
            } else {
                throw new Exception("Method not defined");
            }
        } else {
            throw new Exception("Ruta no encontrada");
        }
    }
}