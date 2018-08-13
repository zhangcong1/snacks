<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/8/7
 * Time: 13:31
 */

namespace app\api\service;


use app\lib\enum\ScopeEnum;
use think\Exception;
use app\api\model\User as UserModel;

class UserToken extends Token
{
    protected $code;
    protected $wxappID;
    protected $wxappSecret;
    protected $wxLoginUrl;
    public function __construct($code)
    {
        $this->code = $code;
        $this->wxappID = config("wx.app_id");
        $this->wxappSecret = config("wx.app_secret");
        $this->wxLoginUrl = sprintf(
            config("wx.login_url"),
            $this->wxappID, $this->wxappSecret, $this->code
        );
    }

    public function get()
    {
        $result = curl_get($this->wxLoginUrl);
        $wxResult = json_decode($result,true);
        if (empty($wxResult)){
            throw new Exception('获取session_key及openID时异常，微信内部错误');
        }else{
            $loginFail = array_key_exists('errorcode',$wxResult);
            if ($loginFail){
                $this->processLoginError($wxResult);
            }else{
                return $this->grantToken($wxResult);
            }
        }
    }

    private function grantToken($wxResult)
    {
        //拿到oppenid
        //数据库里看一下这个openid是不是已经存在
        //如果存在则不处理，否则新增一条user
        //准备缓存数据，写入缓存
        //把令牌返回到客户端去
        //key: 令牌
        //value： wxResult, uid, scope
        $openid = $wxResult['openid'];
        $user = UserModel::getByOpenID($openid);
        if ($user){
            $uid = $user->id;
        }else{
            $uid = $this->newUser($openid);
        }
        $cacheValue = $this->prepareCacheValue($wxResult, $uid);
        $token = $this->saveToCache($cacheValue);
        return $token;
    }

    private function saveToCache($cacheValue)
    {
        $key = self::generateToken();
        $value = json_encode($cacheValue);
        $expire_in = config('setting.token_expire_in');

        $request = cache($key,$value,$expire_in);
        if (!$request){
            throw new TokenException([
                "msg" => '服务器缓存异常',
                'errorCode' => 10005
            ]);
        }
        return $key;
    }

    private function prepareCacheValue($wxResult, $uid)
    {
        $cacheValue = $wxResult;
        $cacheValue['uid'] = $uid;
        //16 代表App用户权限数值
        //32 代表CMS（管理员）权限数值
        $cacheValue['scope'] = ScopeEnum::User;
        return $cacheValue;
    }

    private function newUser($openid)
    {
        $user = UserModel::create([
            'openid' => $openid
        ]);
        return $user->id;
    }

    private function processLoginError($wxResult)
    {
        throw new WeChatException([
            'msg' => $wxResult['errmsg'],
            'errorCode' => $wxResult['errCode']
        ]);
    }
}