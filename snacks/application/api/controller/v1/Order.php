<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/8/13
 * Time: 13:39
 */

namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\api\validate\OrderPlace;
use app\api\service\Token as TokenService;
use app\api\service\Order as OrderService;

class Order extends BaseController
{
    protected $beforeActionList = [
        'checkExclusiveScope' => ['only' => 'placeOrder']
    ];
    /*
     * 用户在选择商品后，向API提交包含他所选商品的相关信息
     * API在接收到信息后，需要检查订单相关商品的库存量
     * 有库存，把订单数据存入数据库中=下单成功了，返回客户端消息，进行支付
     * 调用支付接口，进行支付
     * 还需要再次进行库存量检测
     * 服务器就可以调用微信的支付接口进行支付
     * 微信会返回一个支付结果（异步）
     * 成功：进行库存量检查，进行库存量的扣除，失败：返回支付失败的结果
     * */
    public function placeOrder()
    {
        (new OrderPlace())->goCheck();
        $products = input('post.products/a');
        $uid = TokenService::getCurrentUid('uid');

        $order = new OrderService();
        $status = $order->place($uid,$products);
        return $status;
    }
}