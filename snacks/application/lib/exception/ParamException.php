<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/8/7
 * Time: 10:02
 */

namespace app\lib\exception;


class ParamException extends BaseException
{
    public $code = 400;
    public $msg = "参数错误";
    public $errorCode = 10000;
}