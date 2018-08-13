<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/8/7
 * Time: 11:28
 */

namespace app\api\controller\v1;


use app\api\validate\Count;
use app\api\model\Product as ProductModel;
use app\api\validate\IDMustPositiveInt;
use app\lib\exception\MissException;

class Product
{
    public function getRecent($count=15)
    {
        (new Count())->goCheck();
        $products = ProductModel::getMostRecent($count);
        if (!$products){
            throw new MissException([
                "msg" => "获取最近的新品不存在",
                "error_code" => 50004
            ]);
        }
        return json($products);
    }

    public function getAllInCategory($id)
    {
        (new IDMustPositiveInt())->goCheck();
        $products = ProductModel::getProductsByCategoryID($id);
        if (!$products){
            throw new MissException([
                "msg" => "该分类下没有商品",
                "error_code" => 50004
            ]);
        }
        return json($products);
    }

    public function getOne($id)
    {
        (new IDMustPositiveInt())->goCheck();
        $products = ProductModel::getProductsDetails($id);
        if (!$products){
            throw new MissException([
                "msg" => "请求的产品不存在",
                "error_code" => 60000
            ]);
        }
        return json($products);
    }

    public function deleteOne($id)
    {

    }
}