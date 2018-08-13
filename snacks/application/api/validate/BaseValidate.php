<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/8/7
 * Time: 9:41
 */

namespace app\api\validate;


use app\lib\exception\ParamException;
use think\Request;
use think\Validate;

class BaseValidate extends Validate
{
    public function goCheck()
    {
        $request = Request::instance();
        $params = $request->param();
        $result = $this->batch()->check($params);
        if (!$result){
            throw new ParamException([
                "msg" => $this->error
            ]);
        }else{
            return true;
        }
    }

    protected function IsPositiveInt($value)
    {
        if (is_numeric($value) && is_int($value+0) && ($value+0)>0){
            return true;
        }else{
            return false;
        }
    }

    protected function NotEmpty($value)
    {
        if (!empty($value)){
            return true;
        }else{
            return false;
        }
    }

    //没有使用TP的正则验证，集中在一处方便以后修改
    //不推荐使用正则，因为复用性太差
    //手机号的验证规则
    protected function Mobile($value)
    {
        $rule = '^1(3|4|5|7|8)[0-9]\d{8}$^';
        $result = preg_match($rule, $value);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function getDataByRule($arrays)
    {
        if (array_key_exists('user_id',$arrays) | array_key_exists('uid',$arrays)){
            throw new ParamException([
                'msg' => '参数中包含有非法的参数名user_id或者uid'
            ]);
        }
        $newArray = [];
        foreach ($this->rule as $key=>$value){
            $newArray[$key] = $arrays[$key];
        }
        return $newArray;
    }
}