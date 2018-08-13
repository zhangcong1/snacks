<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/8/7
 * Time: 13:20
 */

namespace app\api\controller\v1;


use app\api\service\UserToken;
use app\api\validate\TokenGet;
use app\lib\exception\ParamException;
use app\api\service\Token as TokenService;

class Token
{
    public function getToken($code='')
    {
        (new TokenGet())->goCheck();
        $ut = new UserToken($code);
        $token = $ut->get();
        return json([
            'token' => $token
        ]);
    }

    public function verifyToken($token='')
    {
        if (!$token){
            throw new ParamException([
                'token不允许为空'
            ]);
        }
        $valid = TokenService::verifyToken($token);
        return json([
            'isValid' => $valid
        ]);
    }
}