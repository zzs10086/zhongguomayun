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

    private $client = null;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this ->client = Elasticsearch\ClientBuilder::create()
             ->setRetries(2)
             ->build();

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

        $limit = 50;

        while (1){

            $i=1;

            $list = Article::getEsArcList($last_id, $limit);

            if(empty($list)) return false;
            //上次同步最后的id
            foreach ($list as $k=>$v){

                $last_id = $v['id'];
                $time = time();
                $params['body'][] = [
                     'index' => [
                          '_index' => $this->index,
                          '_type' => $this->type,
                          '_id' => md5($time.$v['id']),
                     ],
                ];

                $params['body'][] = [
                     'id' => (int)$v['id'],
                     'title' => $v['title'],
                     'description' => $v['description'],
                     'keywords' => $v['keywords'],
                     'thumb' => $v['thumb'],
                     'is_img' => (int)$v['is_img'],
                     'created_at' =>$v['created_at'],                    
                     'catid' =>(int)$v['catid'],
                     'click' =>(int)$v['click'],
                     'status' => (int)$v['status'],
                     'addtime' => (int)$time,
                     'content' => $v['content'],
                ];

                if(fmod($i,$limit)==0)
                {
                    $responses = $this->client->bulk($params);
                    $params = ['body' => []];
                    unset($responses);
                    sleep(2);
                }
                $i++;

            }

            if(fmod($i,$limit)>0)
            {
                if(!empty($params['body'])){
                    $responses = $this->client->bulk($params);
                    $params = ['body' => []];
                    unset($responses);
                }

            }
            //更新syncEsLastid
            SyncEsLastId::updateSyncEsLastid($last_id);
            sleep(2);

        }
    }
}
