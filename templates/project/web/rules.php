<?php
//命名空间组合为PHP7.2+的新功能，需要兼容PHP7.0
use Phalcon\Validation\Validator\Digit;
use Phalcon\Validation\Validator\StringLength;
use Phalcon\Validation\Validator\Regex;
use Phalcon\Validation\Validator\InclusionIn;
use Phalcon\Validation\Validator\Between;
use Phalcon\Validation\Validator\Numericality;
use Phalcon\Validation\Validator\Date as ValidDate;

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

