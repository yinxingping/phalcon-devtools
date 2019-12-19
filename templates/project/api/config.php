<?php

defined('BASE_PATH') || define('BASE_PATH', getenv('BASE_PATH') ?: realpath(dirname(__FILE__) . '/../..'));
defined('APP_PATH') || define('APP_PATH', BASE_PATH . '/app');
defined('LOG_PATH') || define('LOG_PATH', getenv('LOG_PATH', '/var/log/phalcon'));

$appName = getenv('APP_NAME', '@@name@@');

return new \Phalcon\Config([
    'version' => '1.0',
    'appName' => $appName,

    'application' => [
        'controllersDir' => APP_PATH . '/controllers/',
        'libraryDir'     => APP_PATH . '/library/',
    ],

    'session' => [
        'host'     => getenv('SESSION_REDIS_HOST') ?: '127.0.0.1',
        'port'     => getenv('SESSION_REDIS_PORT') ?: '6379',
        'lifetime' => 86400,//1天
        'prefix'   => ':' . $appName . ':',
        'adapter'  => 'redis',
    ],

    'redis' => [
        'host'           => getenv('STORAGE_REDIS_HOST') ?: 'localhost',
        'port'           => getenv('STORAGE_REDIS_PORT') ?: '6380',
        'timeout'        => 2, //s
        'retry_interval' => 100, //ms
        'read_timeout'   => 1, //s
        'database'       => getenv('STORAGE_REDIS_INDEX') ?: 15,
        'prefix'         => $appName . ':',
    ],

    'logger' => [
        'adapter' => 'file',
        'name'    => LOG_PATH . '/' . $appName . '_info_' . date('Ymd') . '.log',
    ],
]);

