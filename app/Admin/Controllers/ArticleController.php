<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Model\Article;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use Encore\Admin\Grid;
use Encore\Admin\Form;
use App\Model\ArticleContent;

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
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(Article::class, function (Grid $grid) {

            $grid->id('ID')->sortable()->sortable();

            $grid->column('title','标题')->limit(80);

            $grid->category()->category_name('分类');

            $grid->click('浏览次数');
            $grid->addtime('新增时间')->display(function ($addtime) {
                return date('Y-m-d H:i:s',$addtime);
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

            $grid->paginate(10);
        });
    }

    protected function form()
    {
        return Admin::form(Article::class, function (Form $form) {
            $form->display('id', 'ID');
            $form->text('title', '文章标题');
            $form->text('keywords', '关键词');
            $form->text('source', '来源');
            $form->textarea('description', '简介');
            $form->checkbox('flag', '标志位')->options(Article::$flagInfo);
            $form->image('thumb', '缩略图')->removable();
            //$form->select('catid', '分类')->options();
            $form->ckeditor('content.content', '文章内容');
            $form->saving(function (Form $form) {
                dump($form); exit;
            });
        });
    }
}
