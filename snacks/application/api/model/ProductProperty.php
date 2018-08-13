<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/8/8
 * Time: 18:03
 */

namespace app\api\model;


class ProductProperty extends BaseModel
{
    protected $hidden = ['id','product_id','delete_time','update_time'];
}