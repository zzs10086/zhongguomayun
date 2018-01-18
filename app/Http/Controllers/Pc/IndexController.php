<?php

namespace App\Http\Controllers\Pc;

use App\Model\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Lib\Paginate;
use App\Lib\Pager;
use App\Model\Category;

class IndexController extends Controller
{
    /**
     * 首页
     * @return mixed
     */
    public function index(){

        //幻灯
        $foucsNews = Article::getFlagArc('f', 6);

        //马云语录
        $mayunNews = Article::getArcList(1, 1, 8);

        //热度排行
        $hotNews = Article::getArcList(0, 1, 9, 'click');

        $data = array(
            'title' => '中国马云民族骄傲',
            'keyword' => '马云,Jack.Ma,中国马云,阿里巴巴',
            'description' => '中国马云是全面介绍名族优秀企业家马云的资讯网站',
            'foucsNews' => $foucsNews,
            'mayunNews' => $mayunNews,
            'hotNews' => $hotNews,
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

        $limit = 2;

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
            'current' =>$category['category_name']
        );

        return view('pc.category', $data);
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

        if(date('Ymd', $article['addtime']) !== $time) abort(404);

        //处理分页

        $content = $article['content']['content'];

        $content = ltrim($content, '#p#');

        $contentArr = explode('#p#',$content);

        $count = count($contentArr);

        if($page > $count)  abort(404);

        $paginate = Paginate::_detailPage([
            'current_page' => $page,    // 当前页
            'per_page' => 10,       // 每页数量
            'total_page' => $count,      // 总页数
            'path_deep' => 3,
            'ul_class' =>'page over_hidden',
            'current_class' => 'thisclass'
        ]);

        $data = array(
            'title' => $article['title'] . '_' . config('app.name'),
            'keyword' =>'keywords',
            'description' => 'description',
            'article' => $article,
            'content' => $contentArr[$page - 1],
            'paginate' => $paginate,
            'count' => $count
        );

        //文章阅读量+1
        Article::findOrFail($id)->increment('click');

        return view('pc.show', $data);
    }

    public function video($time, $id){

        $article = Article::getArcInfo($id);

        if(date('Ymd', $article['addtime']) !== $time) abort(404);
        
        $data = array(
            'title' => $article['title'] . '_' . config('app.name'),
            'keyword' =>'keywords',
            'description' => 'description',
            'article' => $article,
        );
        return view('pc.video',$data);
    }
}
