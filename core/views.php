<?php


class Views {

    private $template;
    private $route_views = 'application/views/';
    private $route_pages;
    public function __construct($name_template) {
        $this->template = $name_template;
        $this->route_pages  = $this->route_views . 'pages/';
    }

    public function render($path_file, $context) {
        if (is_readable($this->route_pages . $path_file)) {
            foreach ($context as $nameValue => $value) {
                $$nameValue = $value;
            }
            $absolute_domain = "http://localhost:8080/framework-piloto/";
            include_once $this->route_views . 'template/' . $this->template . '/header.php';
            include $this->route_views . 'pages/' . $path_file;
            include_once $this->route_views . 'template/' . $this->template . '/footer.php';
        } else {
            throw new Exception("View not found");
        }
    }
}