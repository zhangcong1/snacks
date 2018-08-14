<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/8/14
 * Time: 14:30
 */

namespace app\lib\enum;


class OrderStatusEnum
{
    // 待支付
    const UNPAID = 1;
    // 已支付
    const PAID = 2;
    // 已发货
    const DELIVERD = 3;
    // 已支付，但库存不足
    const PAID_BUT_OUT_OF = 4;
}