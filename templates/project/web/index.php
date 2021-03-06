<?php

use Phalcon\Di;
use Phalcon\Mvc\Application;

define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');

include(BASE_PATH . '/vendor/autoload.php');
$dotenv = \Dotenv\Dotenv::create(BASE_PATH);
$dotenv->load();

include APP_PATH . '/config/constants.php';
include APP_PATH . '/config/errcode.php';
include APP_PATH . '/config/rules.php';

define('LOG_PATH', getenv('LOG_PATH') ?: BASE_PATH . '/logs');
ini_set('display_errors', 'off');
ini_set('error_log', LOG_PATH . '/' .getenv('APP_NAME') . '_error_' . date('Ymd') . '.log');
if (getenv('APP_ENV') == 'production') {
    error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT);
} else {
    error_reporting(E_ALL);
}
ini_set('date.timezone', 'Asia/Shanghai');

try {
    $di = new Di();

    include APP_PATH . '/config/services.php';
    $config = $di->getConfig();
    include APP_PATH . '/config/loader.php';
    include APP_PATH . '/config/router.php';

    $app = new Application($di);
    echo $app->handle()->getContent();
} catch (\Exception $e) {
    echo $e->getMessage() . '<br>';
    echo '<pre>' . $e->getTraceAsString() . '</pre>';
}

