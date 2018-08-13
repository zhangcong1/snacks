<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/8/10
 * Time: 15:05
 */

namespace app\lib\exception;


class UserException extends BaseException
{
    public $code = 404;
    public $msg = "用户不存在";
    public $errorCode = 60000;
}