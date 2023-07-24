<?php 

function env(string $envVariable) 
{
    return $_ENV[$envVariable];
}

/**
 * @param string $viewName
 * @return string
 */
function viewsPath(string $viewName) 
{
    return __DIR__ . '/../../' . $_ENV['APP_VIEWS_PATH'] . '/' . $viewName . $_ENV['APP_VIEWS_EXT'];
}

/**
 * @param string $path
 * @return string
 */
function url(string $path) 
{
    return $_ENV['APP_URL'] . ($path[0] == '/' ? $path : '/' . $path);
}

/**
 * @param string $path
 * @return string
 */
function requireItem(string $path) 
{
    return __DIR__ . '/../../' . ($path[0] == '/' ? $path : '/' . $path);
}

/**
 * @param string $path
 * @return string
 */
function assets(string $path) 
{
    return $_ENV['APP_URL'] . "/resources/assets" . ($path[0] == '/' ? $path : '/' . $path);
}

/**
 * @param array|string $data
 * @param string|null $mode | null or 'enc' to json_encode and 'dec' to json_decode
 * @return array|string
 */
function json(array|string $data, string $mode = null) 
{
    if ($mode === 'dec') {
        return json_decode($data);
    }

    return json_encode($data);
}
