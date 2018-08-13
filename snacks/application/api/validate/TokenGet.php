<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/8/7
 * Time: 13:22
 */

namespace app\api\validate;


class TokenGet extends BaseValidate
{
    protected $rule = [
        "code" => "require|NotEmpty"
    ];

    protected $message = [
        'msg' => '没有Token'
    ];
}