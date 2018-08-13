<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/8/7
 * Time: 10:26
 */

namespace app\api\model;


class Image extends BaseModel
{
    protected $hidden = ["delete_time","update_time","from","id"];

    public function getUrlAttr($value,$data)
    {
        return $this->prefixImgUrl($value,$data);
    }
}