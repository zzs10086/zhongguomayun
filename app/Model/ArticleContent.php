<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ArticleContent extends Model
{
    //
    protected $table = 'article_content';

    public $timestamps = false;

    protected $fillable = ['aid','content'];
}
