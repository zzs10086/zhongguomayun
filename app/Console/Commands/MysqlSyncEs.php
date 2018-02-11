<?php

namespace App\Console\Commands;

use App\Model\Article;
use App\Model\SyncEsLastId;
use Illuminate\Console\Command;
use Elasticsearch;

class MysqlSyncEs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:mysqltoes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        set_time_limit(0);
        
        $last_id_arr = SyncEsLastId::getSyncEsLastid();

        if(empty($last_id_arr)){

            return false;
        }

        $last_id = empty($last_id_arr) ? 0 : $last_id_arr['last_id'];

        while (1){

            $list = Article::getEsArcList($last_id);

            if(empty($list)) return false;
            //上次同步最后的id
        }
    }
}
