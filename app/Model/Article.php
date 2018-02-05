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
    
    //public $timestamps = false;

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

    public static $flag = [
        '1' => '首页轮播',
        's' => '二级头条',
    ];

    public static $isimg = [
        1 => '图片',
        2 => '视频',
        3 => '文字',
    ];

    public static $category = [
       1 =>'马云动态',
       2 =>'马云视频',
       3 =>'马云语录',
       4 =>'阿里资讯',
       5 =>'阿里故事',
    ];

   /* public function getFlagAttribute($flag){
        $flagList = [];
        if (is_string($flag)) {
            $flagList = explode(',', $flag);
        }
        return $flagList;
    }

    public function setFlagAttribute($flag)
    {
        if (is_array($flag)) {
            $this->attributes['flag'] = implode(',', $flag);
        }
    }*/
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

    /**
     * 获取子分类id
     * @param $cid
     * @return mixed
     */
    public static function getArcRelevant($category_id = 0, $id = 1, $limit = 6){

        $key = "getArcRelevant:". $category_id . '_'. $category_id . '_'. $id . '_'.$limit ;

        $data = Util::getRedis($key, true);

        if(!$data){


            $where = $category_id == 0 ?  [['status', 0]] : [['status', 0], ['catid', $category_id],['id', '<', $id]];

            $query = Article::where($where);

            $data = $query->limit($limit) ->orderBy('id', 'desc') ->get()->toArray();

            Util::setRedis($key, $data);
        }

        return $data;

    }

    public static function preArc($id, $category_id)
    {

        $key = "preArc:" . $id . "_" . $category_id;

        $data = Util::getRedis($key, true);

        if (!$data) {

            $data = Article::where([['status', 0], ['catid', $category_id], ['id', '>', $id]])->orderBy('id', 'asc')->first();
        }


        return $data;
    }

    public static function nextArc($id, $category_id)
    {

        $key = "nextArc:" . $id . "_" . $category_id;

        $data = Util::getRedis($key, true);

        if (!$data) {

            $data = Article::where([['status', 0], ['catid', $category_id], ['id', '<', $id]])->orderBy('id', 'desc')->first();
        }

        return $data;
    }

    /**
     * 获取文章阅读量
     * @param $id
     * @return array|mixed
     */
    public static function getArcRead($id)
    {

        $key = "getArcRead:" . $id;

        $data = Util::getRedis($key, true);

        if (!$data) {

            $where = [['id', $id]];

            $res = Article::where($where)->first()->toArray();

            $data = array(
                'click' => isset($res['click']) ? $res['click'] : 0,
                'count' => 0
            );

            Util::setRedis($key, $data, -1);
        }

        return $data;
    }

    /**
     * 保存文章阅读量
     * @param $id
     */
    public static function setArcRead($id)
    {

        $key = "getArcRead:" . $id;

        $data = self::getArcRead($id);

        $data['click']++;

        //count 超过10次就提交数据库
        if ($data['count'] >= 10) {

            Article::where([['id', $id]])->update(['click' => $data['click']]);

            $data['count'] = 0;

        } else {

            $data['count']++;
        }


        Util::setRedis($key, $data, -1);

    }
}
