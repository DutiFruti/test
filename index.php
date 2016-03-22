#!/usr/bin/php
<?php
/**
 * Created by PhpStorm.
 * User: progr5
 * Date: 10.3.16
 * Time: 16.27
 */

function autoloader($class)
{
    $class = str_replace('\\', '/', $class);
    $filepath = $_SERVER['DOCUMENT_ROOT'] . $class . '.php';

    if (file_exists($filepath)) {
        require_once($filepath);
    }
}



spl_autoload_register('autoloader');

$config = require(__DIR__ . '/config.php');

$application = new Application($config);
$application->run();