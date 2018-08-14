<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/8/13
 * Time: 14:45
 */

namespace app\api\validate;


use app\lib\exception\ParamException;

class OrderPlace extends BaseValidate
{
    protected $rule = [
        'products' => 'checkProducts'
    ];

    protected $singRule = [
        'product_id' => 'require|IsPositiveInt',
        'counts' => 'require|IsPositiveInt'
    ];

    protected function checkProducts($values)
    {
        if (!is_array($values)){
            throw new ParamException([
                'msg' => '商品参数不正确'
            ]);
        }
        if (empty($values)){
            throw new ParamException([
                'msg' => '商品列表不能为空'
            ]);
        }
        foreach ($values as $value){
            $this->checkProduct($value);
        }
        return true;
    }
    protected function checkProduct($value)
    {
        $validate = new BaseValidate($this->singRule);
        $result = $validate->check($value);
        if (!$result){
            throw new ParamException([
                'msg' => '商品列表参数错误'
            ]);
        }
    }
}