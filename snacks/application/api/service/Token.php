<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/8/7
 * Time: 13:50
 */

namespace app\api\service;


use app\lib\enum\ScopeEnum;
use app\lib\exception\ForbiddenException;
use app\lib\exception\ParamException;
use app\lib\exception\TokenException;
use think\Cache;
use think\Exception;
use think\Request;

class Token
{
    public static function generateToken()
    {
        //32个字符组成一组随机字符串
        $randChars = getRandChar(32);
        //用三组字符串进行md5加密
        $timeStamp = $_SERVER['REQUEST_TIME'];
        $salt = config('secure.token_salt');

        return md5($randChars.$timeStamp.$salt);
    }

    public static function getCurrentTokenVar($key)
    {
        $token = Request::instance()->header('token');
        $vars = Cache::get($token);
        if (!$vars){
            throw new TokenException();
        }else{
            if (!is_array($vars)){
                $vars = json_decode($vars,true);
            }
            if (array_key_exists($key,$vars)){
                return $vars[$key];
            }else{
                throw new Exception("尝试获取的Token变量并不存在");
            }
        }
    }

    public static function getCurrentUid()
    {
        //token
        $uid = self::getCurrentTokenVar('uid');
        return $uid;
    }

    public static function verifyToken($token)
    {
        $exist = Cache::get($token);
        if ($exist){
            return true;
        }else{
            return false;
        }
    }
    //用户和CMS管理员都可以访问的权限
    public static function needPrimaryScope()
    {
        $scope = self::getCurrentTokenVar('scope');
        if ($scope){
            if ($scope >= ScopeEnum::User){
                return true;
            }else{
                throw new ForbiddenException();
            }
        }else{
            throw new TokenException();
        }
    }
    //只有用户才能访问的接口权限
    public static function needExclusiveScope()
    {
        $scope = self::getCurrentTokenVar('scope');
        if ($scope){
            if ($scope == ScopeEnum::User){
                return true;
            }else{
                throw new ForbiddenException();
            }
        }else{
            throw new TokenException();
        }
    }

    public static function isValidOperate($checkedUID)
    {
        if (!$checkedUID){
            throw new Exception('检查UID时必须传入一个被检查的UID');
        }
        $currentOperateUID = self::getCurrentUid();
        if ($checkedUID == $currentOperateUID){
            return true;
        }
        return false;
    }
}
