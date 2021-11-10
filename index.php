<?php
    require_once 'core/launcher.php';
    try {
        $path = $_GET['url'];
        $router = new Launcher($path);
    } catch (Exception $e) {
        echo $e->getMessage();
    }