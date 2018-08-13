<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/8/7
 * Time: 11:56
 */

namespace app\api\model;


class Category extends BaseModel
{
    public function img()
    {
        return $this->belongsTo('Image', 'topic_img_id', 'id');
    }
}