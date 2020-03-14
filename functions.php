<?php

function route($action, Closure $callback)
{
    global $routes;
    $action = trim($action, '/');
    $routes[$action] = $callback;
}
function dispatch($action)
{
    global $routes;
    $action = trim($action, '/');

    $callback = $routes[$action];

    print call_user_func($callback);
}
function view($data, $layout = 'views/main.tpl.php')
{
    extract((array)$data);
    ob_start();
    require($layout);
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
}
function loadView($filename, $data){
    return view($data, $filename);
}

function pre($array, $die = false, $pre = true) {
    if (is_array($array) or is_object($array)) {
        if ($pre) print "<pre>";
        print_r($array);
        if ($pre) print "</pre>";
    } else {
        if (!$die) {
            print $array . "<br>";
        } else {
            print $array;
        }
    }
    if ($die) {
        die(1);
    }
}
