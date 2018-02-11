<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SyncEsLastId extends Model
{
    //
    protected $table = 'sync_es_lastid';

    public $timestamps = false;

    public static function getSyncEsLastid(){

        return SyncEsLastId::find(1);
    }

    public static function updateSyncEsLastid($lastid){

        SyncEsLastId::where('id', 1)->update(['last_id' => $lastid]);
    }
}
