<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/8/7
 * Time: 10:09
 */

namespace app\api\model;


class Banner extends BaseModel
{
    public function item()
    {
        return $this->hasMany("BannerItem","banner_id","id");
    }

    public static function getBannerByID($id)
    {
        $banner = self::with(["item","item.img"])->find($id);
        return $banner;
    }
}