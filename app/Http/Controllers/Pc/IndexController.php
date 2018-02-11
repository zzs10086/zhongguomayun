<?php

namespace App\Http\Controllers\Pc;

use App\Lib\Util;
use App\Model\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Lib\Paginate;
use App\Lib\Pager;
use App\Model\Category;
use Illuminate\Support\Facades\Input;

class IndexController extends Controller
{
    private static $mUrl;

    public function __construct(){

        self::$mUrl = config('app.m_url').$_SERVER['REQUEST_URI'];

        //判断是否是手机端
        if(Util::isMobile()){

            header('Location: '.self::$mUrl);
        }
    }
    /**
     * 首页
     * @return mixed
     */
    public function index(){

        //幻灯
        $foucsNews = Article::getFlagArc('f', 6);

        //马云语录
        $mayunNews = Article::getArcList(0, 1, 8);

        //热度排行
        $hotNews = Article::getArcList(0, 1, 9, 'click');

        //视频
        $videoNews = Article::getArcList(2, 1, 6);

        $data = array(
            'title' => '【马云】马云资料大全_马云演讲视频整理_马云的最新消息、动态',
            'keyword' => '马云资料大全、马云演讲视频、马云的最新消息、Jack Ma、阿里巴巴',
            'description' => '马云是中国的骄傲，也是世界上著名的成功企业家。中国马云网为你提供马云全部资料、演讲视频、马云最新动态相关新闻！想了解最新最全的马云消息，关注中国马云网zhongguomayun.com！',
            'foucsNews' => $foucsNews,
            'mayunNews' => $mayunNews,
            'hotNews' => $hotNews,
            'videoNews' => $videoNews,
            'mURL' => self::$mUrl,
        );

        return view('pc.index', $data);

    }

    /**
     * 分类
     * @param string $cateName
     * @param int $page
     * @return mixed
     */
    public function category($cateName='', $page = 1){

        //获取分类
        $categoryEn = Category::getAllCategoryNameEn();

        if(!in_array($cateName, $categoryEn)) abort(404);

        $category = Category::getCategoryByPinyin($cateName );

        $category_id = $category['id'];

        $limit = 10;

        $list = Article::getArcList($category_id, $page, $limit);

        $count = Article::getArcCounts($category_id);

        $paginate = Pager::_page([
            'current_page' => $page,    // 当前页
            'per_page' => $limit,       // 每页数量
            'total_page' => round($count / $limit),      // 总页数
            'path_deep' => 3,
            'ul_class' =>'page over_hidden',
            'current_class' => 'thisclass'
        ]);

        $data = array(
            'title' => $category['seo_title'],
            'keyword' =>$category['seo_keywords'],
            'description' => $category['seo_description'],
            'list'=>$list,
            'paginate' => $paginate,
            'category_id'=>$category_id,
            'current' =>$category['category_name'],
            'mURL' => self::$mUrl,
        );

        return view('pc.category', $data);
    }

    /**
     * 语录
     * @param string $cateName
     * @param int $page
     * @return mixed
     */
    public function yulu( $page = 1){

        //获取分类
        $cateName='yulu';

        $categoryEn = Category::getAllCategoryNameEn();

        if(!in_array($cateName, $categoryEn)) abort(404);

        $category = Category::getCategoryByPinyin($cateName );

        $category_id = $category['id'];

        $limit = 10;

        $list = Article::getArcList($category_id, $page, $limit);

        $count = Article::getArcCounts($category_id);

        $paginate = Pager::_page([
            'current_page' => $page,    // 当前页
            'per_page' => $limit,       // 每页数量
            'total_page' => $count / $limit,      // 总页数
            'path_deep' => 3,
            'ul_class' =>'page over_hidden',
            'current_class' => 'thisclass'
        ]);

        $data = array(
            'title' => $category['seo_title'],
            'keyword' =>$category['seo_keywords'],
            'description' => $category['seo_description'],
            'list'=>$list,
            'paginate' => $paginate,
            'category_id'=>$category_id,
            'current' =>$category['category_name'],
            'mURL' => self::$mUrl,
        );

        return view('pc.yulu', $data);
    }
    /**
     * 文章详情
     * @param $time
     * @param $id
     * @param int $page
     * @return mixed
     */
    public function show($time, $id, $page = 1){

        $article = Article::getArcInfo($id);

        if(date('Ymd', strtotime($article['created_at'])) !== $time) abort(404);

        //处理分页

        $content = $article['content']['content'];

        $content = ltrim($content, '#p#');

        $contentArr = explode('#p#',$content);

        $count = count($contentArr);

        if($page > $count)  abort(404);

        //阅读数量 +1
        Article::setArcRead($id);

        $clickArr = Article::getArcRead($id);

        //相关文章
        $relevant = Article::getArcRelevant($article['catid'], $id, 6);

        $paginate = Paginate::_detailPage([
            'current_page' => $page,    // 当前页
            'per_page' => 10,       // 每页数量
            'total_page' => $count,      // 总页数
            'path_deep' => 3,
            'ul_class' =>'page over_hidden',
            'current_class' => 'thisclass'
        ]);

        $data = array(
            'title' => $article['title'],
            'keyword' =>$article['keywords'],
            'description' => $article['description'],
            'article' => $article,
            'content' => $contentArr[$page - 1],
            'paginate' => $paginate,
            'count' => $count,
            'relevant' => $relevant,
            'mURL' => self::$mUrl,
            'click' => $clickArr['click'],
            'id'=>$id

        );


        return view('pc.show', $data);
    }

    public function video($time, $id){

        $article = Article::getArcInfo($id);
        if(date('Ymd', strtotime($article['created_at'])) !== $time) abort(404);

        //阅读数量 +1
        Article::setArcRead($id);

        $clickArr = Article::getArcRead($id);

        //相关视频
        $relevant = Article::getArcRelevant($article['catid'], $id, 8);

        //热门视频
        //$hotVideo = Article::getArcList($article['catid'], 1, 4, 'click');

        //点赞和踩
        $goodAndBad = Article::getArcLike($id);

        $data = array(
            'title' => $article['title'],
            'keyword' =>$article['keywords'],
            'description' => $article['description'],
            'article' => $article,
            'relevant' => $relevant,
            //'hotVideo' => $hotVideo,
            'mURL' => self::$mUrl,
            'click' => $clickArr['click'],
            'id'=>$id,
            'goodAndBad'=>$goodAndBad,
        );

        return view('pc.video',$data);
    }

    public function search($page = 1){

        $keywords = Input::get('q');

        $limit = 10;

        $time =time();
        $token = md5($time.config('app.token_salt'));
        $apiUrl = config('app.api_app_url')."/api/es/query?keywords=".$keywords."&page=".$page."&limit=".$limit."&time=".$time."&token=".$token;
        $result = json_decode(Util::getCurl($apiUrl),true);

        $count = $result['data']['total'];
        $list = $result['data']['item'];

        $paginate = Pager::_page([
             'current_page' => $page,    // 当前页
             'per_page' => $limit,       // 每页数量
             'total_page' => round($count / $limit),      // 总页数
             'path_deep' => 3,
             'ul_class' =>'page over_hidden',
             'current_class' => 'thisclass'
        ]);

        $data = array(
             'title' => '搜索结果',
             'keyword' =>'搜索',
             'description' => "搜索马云最新资讯",
             'list'=>$list,
             'paginate' => $paginate,
             'current' =>'搜索结果：'.$keywords,
             'mURL' => self::$mUrl,
        );

        return view('pc.search', $data);

    }
}
