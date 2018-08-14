<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/8/14
 * Time: 13:43
 */

namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\api\validate\IDMustPositiveInt;
use app\api\service\Pay as PayService;

class Pay extends BaseController
{
    protected $beforeActionList = [
        'checkExclusiveScope' => ['only' => 'getPreOrder']
    ];
    public function getPreOrder($id='')
    {
        (new IDMustPositiveInt())->goCheck();
        $pay = new PayService($id);
        return $pay->pay();
    }

    public function receiveNotify()
    {
        //通知频率为15/15/30/180/1800/1800 单位：秒
    }
}