<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/8/7
 * Time: 9:41
 */

namespace app\api\validate;


class IDMustPositiveInt extends BaseValidate
{
    protected $rule = [
        "id" => "require|IsPositiveInt"
    ];
}