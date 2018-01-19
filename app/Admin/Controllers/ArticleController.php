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

            $grid->id('ID')->sortable();

            $grid->title('标题')->limit(80);

            $grid->category()->category_name('分类');

            $grid->click('浏览次数');

            $grid->status('状态')->switch(Article::$status);

            $grid->created_at();
            $grid->updated_at();
        });
    }

    protected function form()
    {
        return Admin::form(Article::class, function (Form $form) {
            $form->display('id', 'ID');
            $form->text('title', '文章标题')->rules('required|min:3');
            $form->text('keywords', '关键词');
            $form->text('source', '来源')->rules('required');
            $form->textarea('description', '简介')->rows(2);
            $form->checkbox('flag', '标志位')->options(Article::$flagInfo);
            $form->image('thumb', '缩略图')->removable();
            //$form->select('catid', '分类')->options();
            $form->ckeditor('content.content', '文章内容');
            $form->saving(function () {

            });
        });
    }
}
