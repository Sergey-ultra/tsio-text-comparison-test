<?php

if (!isset($_SESSION)) {
    session_start();
}

function flash($name, $message)
{
    if (!empty($name) && !empty($message)) {
        $_SESSION[$name] = $message;
    }
}

function message($name, $class)
{
    if (isset($_SESSION[$name])) {
        echo '<div class="' . $class . '" ><p>' . $_SESSION[$name] . '</p></div>';
        unset($_SESSION[$name]);
    }
}

function redirect($location)
{
    header("location: " . $location);
    exit();
}

function render($path, $args = [])
{
    foreach ($args as $key => $arg){
        $$key = $arg;
    }


    ob_start();
    require __DIR__ . "/../view/" . $path . ".php";
    $content = ob_get_clean();
    require "../view/layout/" . $layout . ".php";

}
