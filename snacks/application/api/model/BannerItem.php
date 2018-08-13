<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/8/7
 * Time: 10:18
 */

namespace app\api\model;

class BannerItem extends BaseModel
{
    protected $hidden = ["delete_time","update_time","img_id","banner_id","id"];

    public function img()
    {
        return $this->belongsTo("Image","img_id","id");
    }
}