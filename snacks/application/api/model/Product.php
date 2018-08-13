<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/8/7
 * Time: 11:19
 */

namespace app\api\model;


class Product extends BaseModel
{
    protected $hidden = [
        'delete_time', 'main_img_id', 'pivot', 'from', 'category_id',
        'create_time', 'update_time','img_id'
    ];

    public function property()
    {
        return $this->hasMany("ProductProperty","product_id","id");
    }

    public function productImg()
    {
        return $this->hasMany("ProductImage","product_id","id");
    }

    public function getMainImgUrlAttr($value,$data)
    {
        return $this->prefixImgUrl($value,$data);
    }

    public static function getMostRecent($count)
    {
        $products = self::limit($count)
            ->order('create_time desc')
            ->select();
        return $products;
    }

    public static function getProductsByCategoryID($id)
    {
        $products = self::where('category_id','=',$id)->select();
        return $products;
    }

    public static function getProductsDetails($id)
    {
        $products = self::with(["productImg" => function($query){
            $query->with("img")->order("order","asc");
        }])->with(["property"])->find($id);
        return $products;
    }
}