<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Lib\Util;
use App\Model\Article;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use Encore\Admin\Grid;
use Encore\Admin\Form;
use App\Model\ArticleContent;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use App\Services\OSS;
use Illuminate\Support\Facades\Storage;


class ArticleController extends Controller
{
    use ModelForm;

    public function index(){

        return Admin::content(function (Content $content) {

            $content->header('文章');
            $content->description('列表');

            $content->body($this->grid());
        });
    }

    public function show($id)
    {
        return $this->edit($id);
    }
    /**
     * Edit interface.
     *
     * @param $id
     * @return Content
     */
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('文章');
            $content->description('编辑');
            $content->body($this->form()->edit($id));
        });
    }
    /**
     * 在存储器中更新指定文章
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update($id)
    {
        $result = $this->form()->update($id);
        //admin_toastr('laravel-admin 提示','success');
        // 界面的跳转逻辑
        return $result;
    }

    /**
     * Create interface.
     *
     * @return Content
     */
    public function create()
    {
        return Admin::content(function (Content $content) {

            $content->header('文章');
            $content->description('新增');

            $content->body($this->form());
        });
    }
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(Article::class, function (Grid $grid) {

            $grid->id('ID')->sortable();

            $grid->column('title','标题')->limit(80)->editable();

            $grid->category()->category_name('分类');

            $grid->click('浏览');

            $grid->thumb('封面')->image('http://s1.zhongguomayun.com/', 100, 100);

            /*$grid->addtime('新增时间')->display(function ($addtime) {
                return date('Y-m-d H:i:s',$addtime);
            });*/

            $grid->is_img('类型')->display(function($is_img){
                if($is_img == 1){
                   return '图片';
                }elseif($is_img == 2){
                    return '<span style="color:#ff0000 ">视频</span>';
                }elseif($is_img == 3){
                    return '<span style="color:#00ff00 ">文字</span>';
                }

            });

            $grid->status('状态')->switch(Article::$status);

            $grid->created_at();
            $grid->updated_at();

            $grid->filter(function ($filter) {
                // 设置created_at字段的范围查询
                $filter->between('addtime', '添加时间')->datetime();
                #$filter->equal('title');//相等
                $filter->like('title')->placeholder('请输入标题');

            });

            $grid->model()->orderBy('id', 'desc');

            $grid->paginate(20);
        });
    }

    protected function form()
    {
        return Admin::form(Article::class, function (Form $form) {
            $form->display('id', 'ID');
            $form->text('title', '文章标题')->rules('required|min:3');
            $form->text('source', '来源');
            $form->text('keywords', '关键词');
            $form->textarea('description', '简介');
            $form->image('thumb', '缩略图')->uniqueName()->removable();
            //$form->checkbox('flag', '标志位')->options(Article::$flag);
            $form->radio('is_img', '是否图片')->options(Article::$isimg)->default(1);
            $form->text('video_url', '视频地址');
            $form->text('original_url', '源网址');
            $form->select('catid', '分类')->options(Article::$category)->default(1);
            $form->ckeditor('content.content', '文章内容');
            $form->switch('status', '状态')->states(Article::$status);
            $form->datetime('created_at','添加时间');
            $form->datetime('updated_at','修改时间');
            $form->saving(function (Form $form) {


            });


            $form->saved(function(Form $form){

                $id = $form->model()->getKey();

                $content = $form->content['content'];

                $imgUrlArr = Util::getImageUrl($content);

                //上传oss
                $ossImgUrlArr = Util::saveOssImg($imgUrlArr);

                if($ossImgUrlArr){

                    $content = str_replace($imgUrlArr,$ossImgUrlArr, $content);

                    $info = ArticleContent::where('aid',$id)->first();

                    $info->content = $content;

                    $info->save();

                }


            });


        });
    }
}
