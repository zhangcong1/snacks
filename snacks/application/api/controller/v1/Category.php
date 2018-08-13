<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/8/7
 * Time: 11:55
 */

namespace app\api\controller\v1;
use app\api\model\Category as CategoryModel;
use app\lib\exception\MissException;

class Category
{
    public function getAllCategories()
    {
        $categories = CategoryModel::all([], 'img');
        if(!$categories){
            throw new MissException([
                'msg' => '还没有任何类目',
                'errorCode' => 50000
            ]);
        }
        return json($categories);
    }
}