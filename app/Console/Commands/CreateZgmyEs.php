<?php

namespace App\Console\Commands;

use App\Lib\Util;
use Illuminate\Console\Command;
use Elasticsearch;

class CreateZgmyEs extends Command
{
    /**
     *
     * 生成es的 mapping
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:zgmy-es';

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

    private $client = null;

    private $esHost = '';

    private $esIndex = '';

    private $esType ='';

    public function __construct()
    {

        $this->esHost = config('app.es_host');

        $this->esIndex = config('app.es_index');

        $this->esType = config('app.es_type');

       /* $hosts = array(
            $this->esHost
        );

        $this ->client = Elasticsearch\ClientBuilder::create()
                        ->setHosts([$hosts])
                        ->setRetries(2)
                        ->build();*/
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
        //创建mapping
        $mapParam = array(
            'index' => $this->esIndex,
            'body' =>[
                'settings' => [
                    'number_of_shards' => 6,
                    'number_of_replicas' =>0
                ],
                'mappings' =>[
                    $this->esType =>[
                        'properties' => array(
                            'id' => array(
                                'type' => 'integer',
                            ),
                            'title'=>array(
                                'type' => 'text',
                                'analyzer' => 'ik_smart'
                            ),
                            'description'=>array(
                                'type' => 'text',
                                'analyzer' => 'ik_smart'
                            ),
                            'keywords'=>array(
                                'type' => 'text',
                                'analyzer' => 'ik_smart'
                            ),
                            'thumb'=>array(
                                'type' => 'text',
                                'analyzer' => 'ik_smart'
                            ),
                            'is_img'=>array(
                                'type' => 'integer',
                            ),
                            'created_at'=>array(
                                'type' => 'date',
                            ),
                            'catid'=>array(
                                'type' => 'integer',
                            ),
                            'click'=>array(
                                'type' => 'integer',
                            ),
                            'status'=>array(
                                'type' => 'integer',
                            ),
                            'addtime'=>array(
                                  'type' => 'integer',
                             ),
                            'content' => array(
                                'type' => 'text',
                                'analyzer'=> 'ik_smart'
                            )
                        )
                    ]
                ]
            ],

        );


        try{

            $this->client->indices()->create($mapParam);

        }catch (Elasticsearch\Common\Exceptions\TransportException $e){

            Util::debug_log($e, 'createEsMapping');
            
        }

        Util::debug_log("createEsMapping success", 'createEsMapping');


    }
}
