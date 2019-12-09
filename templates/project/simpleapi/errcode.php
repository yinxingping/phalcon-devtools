<?php
//命名空间组合为PHP7.2+的新功能，需要兼容PHP7.0
use Phalcon\Validation\Validator\Digit;
use Phalcon\Validation\Validator\StringLength;
use Phalcon\Validation\Validator\Regex;
use Phalcon\Validation\Validator\InclusionIn;
use Phalcon\Validation\Validator\Between;
use Phalcon\Validation\Validator\Numericality;
use Phalcon\Validation\Validator\Date as ValidDate;

define('OK', 0);
define('EXCEPTION', 1);
define('DB_ERROR', 2);
define('REDIS_ERROR', 3);
define('VALID_ERROR', 4);
define('UNIQUE_ERROR', 5);
define('INTERFACE_ERROR', 6);
define('SERVER_ERROR', 7);
define('ACCESS_DENIED', 8); //权限限制

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
    'server_error' => [
        'code' => SERVER_ERROR,
        'message' => '服务器错误',
    ],
    /*
     * 自定义错误代码和消息
     */

]);

define('RULES', [
    /*
     * 自定义参数验证规则
     * 如下：
     *  'name' => new StringLength([
     *      'min' => 2,
     *      'max' => 32,
     *      'messageMaximum' => STATUS['name_invalid']['message'],
     *      'messageMinimum' => STATUS['name_invalid']['message'],
     *  ]),
     */
]);

