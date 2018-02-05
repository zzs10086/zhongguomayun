<?php

namespace App\Http\Controllers\M;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Article;
use App\Lib\Util;
use App\Model\Category;

class IndexController extends Controller
{
    //
    public function index(){

        //幻灯
        $foucsNews = Article::getFlagArc('f', 6);


        $data = array(
            'title' => '【马云】马云资料大全_马云演讲视频整理_马云的最新消息、动态',
            'keyword' => '马云资料大全、马云演讲视频、马云的最新消息、Jack Ma',
            'description' => '马云是中国的骄傲，也是世界上著名的成功企业家。中国马云网为你提供马云全部资料、演讲视频、马云最新动态相关新闻！想了解最新最全的马云消息，关注中国马云网zhongguomayun.com！',
            'foucsNews' => $foucsNews,
        );

        return view('m.index', $data);
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


        $data = array(
            'title' => $category['seo_title'],
            'keyword' =>$category['seo_keywords'],
            'description' => $category['seo_description'],
            'category_id'=>$category_id,
            'current' =>$category['category_name']
        );

        return view('m.category', $data);
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

        $category_id = $article['catid'];

        $category = Category::getCategoryById($category_id );

        $preBtn = [];

        $nextBtn = [];

        if($count == 1){

            $preArr = Article::preArc($id, $category_id);

            $preBtn = $preArr ? array('title'=> '上一篇', 'url'=> Util::createArcUrl($preArr['id'],  date('Ymd',strtotime($preArr['created_at'])), $preArr['is_img'], 'm')) : array('title'=>'', 'url'=>'');

            $nextArr = Article::nextArc($id, $category_id);

            $nextBtn = $nextArr ? array('title'=> '下一篇', 'url'=> Util::createArcUrl($nextArr['id'],  date('Ymd',strtotime($nextArr['created_at'])), $nextArr['is_img'], 'm')) : array('title'=>'', 'url'=> '');
        }elseif($count > 1 && $page == 1){//第一页

            $preArr = Article::preArc($id, $category_id);

            $preBtn = $preArr ? array('title'=> '上一篇', 'url'=> Util::createArcUrl($preArr['id'],  date('Ymd',strtotime($preArr['created_at'])), $preArr['is_img'], 'm')) : array('title'=>'', 'url'=>'');

            $nextBtn =  array('title'=> '下一页', 'url'=> Util::createArcUrl($id,  date('Ymd',strtotime($article['created_at'])), $article['is_img'], 'm', $page +1)) ;

        }elseif($count > 1 && $page == $count){//最后一页

            $preBtn = array('title'=> '上一页', 'url'=> Util::createArcUrl($id,  date('Ymd',strtotime($article['created_at'])), $article['is_img'], 'm', $page -1)) ;

            $nextArr = Article::nextArc($id, $category_id);
            $nextBtn = $nextArr ? array('title'=> '下一篇', 'url'=> Util::createArcUrl($nextArr['id'],  date('Ymd',strtotime($nextArr['created_at'])), $nextArr['is_img'], 'm')) : array('title'=>'', 'url'=> '');
        }else{
            $preBtn = array('title'=> '上一页', 'url'=> Util::createArcUrl($id,  date('Ymd',strtotime($article['created_at'])), $article['is_img'], 'm', $page -1)) ;
            $nextBtn =  array('title'=> '下一页', 'url'=> Util::createArcUrl($id,  date('Ymd',strtotime($article['created_at'])), $article['is_img'], 'm', $page +1)) ;


        }

        //阅读数量 +1
        Article::setArcRead($id);

        $clickArr = Article::getArcRead($id);

        //相关文章
        $relevant = Article::getArcRelevant($article['catid'], $id, 6);

        $data = array(
            'title' => $article['title'] . '_' . config('app.name'),
            'keyword' =>$article['keywords'],
            'description' => $article['description'],
            'article' => $article,
            'content' => $contentArr[$page - 1],
            'count' => $count,
            'preBtn' => $preBtn,
            'nextBtn' => $nextBtn,
            'relevant' => $relevant,
            'current' =>$category['category_name'],
            'category_id' =>$category_id,
            'click' => $clickArr['click']

        );

        return view('m.show', $data);
    }

    /**
     * 视频
     * @param $time
     * @param $id
     */
    public function video($time, $id){

        $article = Article::getArcInfo($id);

        if(date('Ymd', strtotime($article['created_at'])) !== $time) abort(404);

        $category = Category::getCategoryById($article['catid'] );

        //阅读数量 +1
        Article::setArcRead($id);

        $clickArr = Article::getArcRead($id);

        //相关文章
        $relevant = Article::getArcRelevant($article['catid'], $id, 6);

        $data = array(
            'title' => $article['title'] . '_' . config('app.name'),
            'keyword' =>$article['keywords'],
            'description' => $article['description'],
            'article' => $article,
            'relevant' => $relevant,
            'current' => $category['category_name'],
            'category_id' =>$article['catid'],
            'click' => $clickArr['click']
        );
        return view('m.video',$data);
    }
}
