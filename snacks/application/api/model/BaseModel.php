<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/8/7
 * Time: 10:18
 */

namespace app\api\model;


use think\Model;

class BaseModel extends Model
{
    protected $hidden = ['delete_time','update_time'];

    //图片完整路径，添加前缀
    public function prefixImgUrl($value,$data)
    {
        $finalUrl = $value;
        if ($data["from"] == 1){
            $finalUrl = config("setting.img_prefix").$value;
        }
        return $finalUrl;
    }
}