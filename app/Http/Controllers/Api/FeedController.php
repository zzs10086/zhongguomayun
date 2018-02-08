<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Article;
use Illuminate\Support\Facades\Input;
use App\Lib\Util;

class FeedController extends BaseController
{
    //
    public function index(){

        $page = Input::get('page');
        $category_id = Input::get('category_id') ? Input::get('category_id') : 0;
        $_callback = Input::get('_callback');
        $limit = Input::get('limit') ? Input::get('limit') : 10;

        $list = Article::getArcList($category_id, $page, $limit);

        $data = [];

        if($list){

            foreach ($list as $k=>$v){

                $data[] = array(
                    'title' => $v['title'],
                    'imgurl' => config('app.upload_url') . $v['thumb'],
                    'id' => $v['id'],
                    'url' => Util::createArcUrl($v['id'],$v['created_at'],$v['is_img'],'m'),
                    'click' => $v['click'],
                    'created_at' => date('Y-m-d', strtotime($v['created_at'])),
                    'catid' => $v['catid'],
                    'is_img'=> $v['is_img'],
                    'video_url'=> $v['video_url'],
                );

            }

        }else{

            Util::output($data, -1, '暂无数据', $_callback);
        }

        Util::output($data, 0, 'ok', $_callback);

    }

    public function detail(){

        $id = Input::get('id');
        $_callback = Input::get('_callback');

        $data = Article::getArcInfo($id);

        if(!$data){

            Util::output($data, -1, '暂无数据', $_callback);
        }

        $data['created_at'] = date('Y-m-d', strtotime($data['created_at']));
        
        Util::output($data, 0, 'ok', $_callback);

    }
}
