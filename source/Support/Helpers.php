<?php 

function env(string $envVariable) 
{
    return $_ENV[$envVariable];
}

function viewsPath(string $viewName) 
{
    return __DIR__ . '/../../' . $_ENV['APP_VIEWS_PATH'] . '/' . $viewName . $_ENV['APP_VIEWS_EXT'];
}

function url(string $path) 
{
    return $_ENV['APP_URL'] . ($path[0] == '/' ? $path : '/' . $path);
}

function requireItem(string $path) 
{
    return __DIR__ . '/../../' . ($path[0] == '/' ? $path : '/' . $path);
}

function assets(string $path) 
{
    return $_ENV['APP_URL'] . "/resources/assets" . ($path[0] == '/' ? $path : '/' . $path);
}

function dateFormat(string $date)
{
    return (new DateTime($date))->format('d/m/Y - H:i');
}