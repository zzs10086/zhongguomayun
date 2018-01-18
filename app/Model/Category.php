<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Lib\Util;

class Category extends Model
{
    //
    protected $table = 'category';


    /**
     * 获取所有分类英文名称
     * @return mixed
     */
    public static function getAllCategoryNameEn(){

        $key = "getAllCategoryNameEn";

        $data = Util::getRedis($key, true);

        if(!$data){

            $categorys = self::getAllCategory();

            $data = array_column($categorys, 'category_name_en');

            Util::setRedis($key, $data);

        }

        return $data;
    }

    /**
     * 获取所有分类
     * @return mixed
     */
    public static function getAllCategory(){

        $key = "getAllCategory";

        $data = Util::getRedis($key, true);

        if(!$data){

            $where = [['status', 0]];

            $data = Category::where($where)->get()->toArray();

            Util::setRedis($key, $data);

        }

        return $data;
    }

    /**
     *
     * 通过拼音查询分类
     * @param string $typename_en
     * @return mixed
     */
    public static function getCategoryByPinyin($typename_en = ''){

        $key = "getCategoryByPinyin:". $typename_en;

        $data = Util::getRedis($key, true);

        if(!$data){

            $where = [['status', 0],['category_name_en',$typename_en]];

            $data = Category::where($where)->first();

            Util::setRedis($key, $data);
        }

        return $data;
    }
}
