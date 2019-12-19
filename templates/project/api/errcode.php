<?php

define('OK', 0);
define('EXCEPTION', 1);
define('DB_ERROR', 2);
define('REDIS_ERROR', 3);
define('VALID_ERROR', 4);
define('UNIQUE_ERROR', 5);
define('INTERFACE_ERROR', 6);
define('SERVER_ERROR', 7);

define('ACCESS_DENIED', 8); //权限限制
define('NO_LOGINED', 9);
define('NEED_REGISTER', 10);

/*
 * 自定义错误代码
 */

define('STATUS',[
    'ok' => [
        'code' => OK,
    ],
    'exception' => [
        'code' => EXCEPTION,
    ],
    'db_error' => [
        'code' => DB_ERROR,
    ],
    'redis_error' => [
        'code' => REDIS_ERROR,
    ],
    'valid_error' => [
        'code' => VALID_ERROR,
    ],
    'unique_error' => [
        'code' => UNIQUE_ERROR,
    ],
    'interface_error' => [
        'code' => INTERFACE_ERROR,
    ],
    'record_not_exists' => [
        'code' => VALID_ERROR,
        'message' => '要操作的记录不存在',
        'field' => 'id',
    ],
    'delete_not_empty' => [
        'code' => VALID_ERROR,
        'message' => '无法删除有关联数据的记录'
    ],
    'id_invalid' => [
        'code' => VALID_ERROR,
        'message' => 'ID必须为正整数值',
    ],
    'digit_invalid' => [
        'code' => VALID_ERROR,
        'message' => '字段值必须为合法的数字',
    ],
    'numeric_invalid' => [
        'code' => VALID_ERROR,
        'message' => '字段值必须为合法的数字',
    ],
    'date_invalid' => [
        'code' => VALID_ERROR,
        'message' => '日期格式必须为Y-m-d',
    ],
    'server_error' => [
        'code' => SERVER_ERROR,
        'message' => '服务器错误',
    ],
    'access_denied' => [
        'code' => ACCESS_DENIED,
        'message' => '没有访问权限',
    ],
    'no_logined' => [
        'code' => NO_LOGINED,
    ],
    'need_register' => [
        'code' => NEED_REGISTER,
    ],
    /*
     * 自定义错误代码和消息
     */

]);

