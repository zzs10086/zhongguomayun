<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Lib\Util;
use App\Model\Category;
use App\Model\ArticleContent;

class Article extends Model
{
    //
    protected $table = 'article';
    
    public $timestamps = false;

    public function content()
    {
        return $this->hasOne(ArticleContent::class,'aid','id');
    }


    public function category()
    {
        return $this->hasOne(Category::class,'id','catid');
    }

    public static $status = [
        'on' => ['value' => 0, 'text' => '正常', 'color' => 'primary'],
        'off' => ['value' => 1, 'text' => '禁用', 'color' => 'default'],
    ];

    public static $flagInfo = [
        'f' => '首页轮播',
        's' => '二级头条'
    ];

    /**
     * 获取文章详情
     * @param $id
     * @return mixed|void
     */
    public static function getArcInfo($id){

        $key = "getArcInfo:".$id;

        $data = Util::getRedis($key, true);

        if(!$data) {

            $data = Article::with('content')->with('category')->findOrFail($id);

            Util::setRedis($key, $data);
        }
        return $data;
    }
    /**
     * 获取flag标示的文章
     * @param $flag
     * @param int $limit
     * @return mixed
     */
    public static function getFlagArc($flag, $limit = 6){

        $key = "getFlagArc:".$flag . "_". $limit;

        $data = Util::getRedis($key, true);

        if(!$data) {

            $query = Article::where([['flag',$flag]]) ->limit($limit) ->orderBy('id', 'desc');

            $data = $limit == 1 ? $query->first()->toArray() : $query->get()->toArray();

            Util::setRedis($key, $data);
        }

        return $data;
    }

    /**
     * 获取子分类id
     * @param $cid
     * @return mixed
     */
    public static function getArcList($category_id = 0, $page = 1, $limit = 20, $sortOrder = 'id'){

        $key = "getArcList:". $category_id . '_'. $page . '_'.$limit . '_' .$sortOrder;

        $data = Util::getRedis($key, true);

        if(!$data){

            $offset = ($page - 1) * $limit;

            $where = $category_id == 0 ?  [['status', 0]] : [['status', 0], ['catid', $category_id]];

            $query = Article::where($where);

            $data = $query->offset($offset)->limit($limit) ->orderBy($sortOrder, 'desc') ->get()->toArray();

            Util::setRedis($key, $data);
        }

        return $data;

    }

    /**
     * 获取文章总量
     * @return mixed
     */
    public static function getArcCounts($category_id = 0){

        $key = "getArcCounts:" . $category_id;

        $data = Util::getRedis($key, true);

        if(!$data){

            $where = $category_id == 0 ?  [['status', 0]] : [['status', 0], ['catid', $category_id]];

            $query = Article::where($where);

            $data = $query->count();

            Util::setRedis($key, $data);
        }

        return $data;
    }
}
