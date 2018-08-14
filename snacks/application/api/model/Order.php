<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/8/13
 * Time: 17:00
 */

namespace app\api\model;


class Order extends BaseModel
{
    protected $hidden = ['user_id','delete_time','update_time'];
    protected $autoWriteTimestamp = true;
}