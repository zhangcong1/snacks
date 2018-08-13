<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/8/7
 * Time: 10:36
 */

namespace app\api\controller\v1;


use app\api\validate\IDCollection;
use app\api\model\Theme as ThemeModel;
use app\api\validate\IDMustPositiveInt;
use app\lib\exception\MissException;

class Theme
{
    public function getSimpleList($ids)
    {
        (new IDCollection())->goCheck();
        $ids = explode(",",$ids);
        $result = ThemeModel::with('topicImg,headImg')->select($ids);
        if (!$result){
            throw new MissException([
                "msg" => '指定主题不存在，请检查主题ID',
                "errorCode" => 30000
            ]);
        }
        return json($result);
    }

    public function getComplexOne($id)
    {
        (new IDMustPositiveInt())->goCheck();
        $theme = ThemeModel::getThemeWithProducts($id);
        if(!$theme){
            throw new MissException([
                "msg" => '指定主题不存在，请检查主题ID',
                "errorCode" => 30000
            ]);
        }
        return json($theme);
    }
}