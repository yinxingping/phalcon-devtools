<?php

defined('BASE_PATH') || define('BASE_PATH', getenv('BASE_PATH') ?: realpath(dirname(__FILE__) . '/../..'));
defined('APP_PATH') || define('APP_PATH', BASE_PATH . '/app');
defined('LOG_PATH') || define('LOG_PATH', getenv('LOG_PATH') ?: BASE_PATH . '/logs');

$appName = getenv('APP_NAME', '@@name@@');

return new \Phalcon\Config([
    'version' => '1.0',
    'appName' => $appName,

    /*
     * model生成时还不支持.env，所以只能以系统getenv方式，且项目生成后这里的默认值要设置成开发环境的相应值
     * ??支持null, ?:支持false
     */
    'database' => [
        'adapter'    => 'Mysql',
        'host'     => getenv('DB_HOST') ?: 'localhost',
        'username' => getenv('DB_USERNAME') ?: 'root',
        'password' => getenv('DB_PASSWORD') ?: 'Test123456',
        'dbname'   => getenv('DB_DATABASE') ?: '',
        'charset'    => 'utf8mb4',
    ],

    'metaDataConfig' => [
        'host'       => getenv('CACHE_REDIS_HOST') ?: 'localhost',
        'port'       => getenv('CACHE_REDIS_PORT') ?: '6379',
        'lifetime'   => 86400,//1天
        'statsKey'   => $appName . '_metadata',
        'index'      => getenv('CACHE_REDIS_INDEX') ?: 2,
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

    'application' => [
        'modelsDir'      => APP_PATH . '/models/',
        'controllersDir' => APP_PATH . '/controllers/',
        'migrationsDir'  => APP_PATH . '/migrations/',
    ],

    'logger' => [
        'adapter' => 'file',
        'name'    => LOG_PATH . '/' . $appName . '_info_' . date('Ymd') . '.log',
    ],

    'dbLogger' => [
        'adapter' => 'file',
        'name'    => LOG_PATH . '/' . $appName . '_db_' . date('Ymd') . '.log',
    ],
]);

