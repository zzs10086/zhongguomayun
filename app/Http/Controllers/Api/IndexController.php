<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Model\Article;

class IndexController extends Controller
{

    /**
     * 点赞或取消
     */
    public function agree(){

        $id = Input::post('id');

        $field = Input::post('field');

        $field_name = $field == 1? 'bad' : 'good';

        Article::setArcLike($id, $field_name);
    }

}
