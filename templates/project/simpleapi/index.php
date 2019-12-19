<?php

use Phalcon\Di;
use Phalcon\Mvc\Micro;

define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');

include(BASE_PATH . '/vendor/autoload.php');
$dotenv = new Dotenv\Dotenv(BASE_PATH);
$dotenv->load();

define('LOG_PATH', getenv('LOG_PATH', '/var/log/phalcon'));
include APP_PATH . '/config/errcode.php';

ini_set('date.timezone', 'Asia/Shanghai');
ini_set('display_errors', 'off');
ini_set('error_log', LOG_PATH . '/' .getenv('APP_NAME', '@@name@@') . '_error_' . date('Ymd') . '.log');
if (getenv('APP_ENV') == 'production') {
    error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT);
} else {
    error_reporting(E_ALL);
}

try {
    $app = new Micro();
    $di = new Di();

    $di->setShared('request', function () {
        return new \Phalcon\Http\Request();
    });
    $di->setShared('response', function () {
        return new \Phalcon\Http\Response();
    });
    $di->setShared('router', function () {
        return new \Phalcon\Mvc\Router();
    });
    $di->setShared('config', function () use ($appName) {
        return include APP_PATH . "/config/config.php";
    });
    $di->setShared('api', function () {
        $loader = new \Phalcon\Loader();
        $loader->registerClasses([
            'API' => APP_PATH . '/library/API.php',
        ]);
        return new \API();
    });

    $config = $di->getConfig();
    $di->setShared('logger', function () use ($config) {
        return \Phalcon\Logger\Factory($config->logger);
    });

    $app->setDi($di);
    include APP_PATH . '/app.php';

    $app->handle();

} catch (\Throwable $t) {
    $app->response->setJsonContent([
        'code'   => STATUS['exception']['code'],
        'status' => 'exception',
        'detail' => [
            'file' => $t->getFile(),
            'line' => $t->getLine(),
            'code' => $t->getCode(),
            'message' => $t->getMessage(),
        ]
    ]);
    $app->response->send();
}

