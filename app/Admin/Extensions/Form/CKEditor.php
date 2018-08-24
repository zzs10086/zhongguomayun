<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/19
 * Time: 16:10
 */
namespace App\Admin\Extensions\Form;

use Encore\Admin\Form\Field;

class CKEditor extends Field
{
    public static $js = [
         '/vendor/ckeditor/ckeditor.js',
         '/vendor/ckeditor/adapters/jquery.js',
    ];

    protected $view = 'admin.ckeditor';

    public function render()
    {
        //echo '<pre>';print_r($this->getElementClass()[0]);exit;
        //echo $this->id = str_replace('.', '_', $this->id);
        // $this->script = "$('textarea.{$this->getElementClass()[0]}').ckeditor();";
        //$this->script = "$('textarea.{$this->id}').ckeditor();";
        /* $this->script = <<<EOT
         UE.delEditor('{$this->id}');
         var  ue = UE.getEditor('{$this->id}');
 EOT;*/
        $csrf = csrf_token();
        $this->script = <<<EOT
        config =new Object();
        config.image_previewText=' ';
        config.filebrowserImageUploadUrl= '/admin/upload?_token=$csrf'; 
        config.filebrowserUploadUrl = '/admin/upload?_token=$csrf';
$('textarea.{$this->getElementClass()[0]}').ckeditor(config);

EOT;

        return parent::render();
    }
}