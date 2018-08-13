<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/8/7
 * Time: 9:37
 */

namespace app\api\controller\v1;


use app\api\validate\IDMustPositiveInt;
use app\api\model\Banner as BannerModel;
use app\lib\exception\MissException;

class Banner
{
    public function getBanner($id)
    {
        (new IDMustPositiveInt())->goCheck();
        $result = BannerModel::getBannerByID($id);
        if (!$result){
            throw new MissException([
                'msg' => '请求banner不存在',
                'errorCode' => 40000
            ]);
        }
        return json($result);
    }
}