<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Elasticsearch;
use Illuminate\Support\Facades\Input;
use App\Lib\Util;

class EsController extends Controller
{
    //
     private $client = null;

     private $esHost = '';

     private $esIndex = '';

     private $esType ='';

     public function __construct()
     {

          $time = Input::get('time');
          $token = Input::get('token');

          $error = [
               'data' =>[],
               'msg' =>'',
               'status' =>1,
          ];
          //判断验证
          if(empty($time) || empty($token)){
               $error['status'] =0;
               $error['msg'] ='缺少验证';
          }
          elseif(time()-600>$time){
               $error['status'] =0;
               $error['msg'] ='请求超时';
          }elseif($token!=md5($time.config('app.token_salt'))){
               $error['status'] =0;
               $error['msg'] ='token错误';
          }
          //非法请求
          if($error['status'] ==0 ){
               Util::output([], -1, $error['msg']);
          }


          $this->esHost = config('app.es_host');

          $this->esIndex = config('app.es_index');

          $this->esType = config('app.es_type');

          $this ->client = Elasticsearch\ClientBuilder::create()
               ->setRetries(2)
               ->build();
     }


     /**
      * es查询接口
      */
     public function query(){

          $keywords = Input::get('keywords');
          $limit = Input::get('limit', 10);
          $page = Input::get('page', 1);
          $_callback = Input::get('_callback');

          $key = 'search:'.$keywords.":".$page.":".$limit;
          $data = Util::getRedis($key, true);

          if (!$data) {

               $offset = ($page-1)*$limit;
               if(!$keywords){
                    Util::output($data, -1, '参数为空', $_callback);
               }
               $param = [
                    'keywords'=>$keywords,
                    'offset'=>$offset,
                    'limit'=>$limit
               ];

               $data = $this->queryEs($param);

               Util::setRedis($key, $data);

          }

         // Util::debug_log($data, 'esapi');

          Util::output($data, 0, 'success', $_callback);
     }

     /**
      * 最底层api接口
      * @param $param
      * @return array
      */
     private function queryEs($param){

          $keywords = $param['keywords'];
          $from = $param['offset'];
          $size = $param['limit'];

          $params = [
               'index' =>$this->esIndex,
               'type' => $this->esType,
               'from'=>$from,
               'size'=>$size,
               'body' => [
                    'query' => [
                         'bool'=>[
                              "should"=>[
                                   [
                                        'match'=>[
                                             'title'=>[
                                                  'query'=>$keywords,
                                                  'boost'=>2,
                                             ]
                                        ]
                                   ],
                                   [
                                        'match'=>[
                                             'keywords'=>[
                                                  'query'=>$keywords,
                                                  'boost'=>2,
                                             ]
                                        ]
                                   ],
                                   [
                                        'match'=>[
                                             'description'=>[
                                                  'query'=>$keywords,
                                                  'boost'=>1,
                                             ]
                                        ]
                                   ],
                                   [
                                        'match'=>[
                                             'content'=>[
                                                  'query'=>$keywords,
                                                  'boost'=>1,
                                             ]
                                        ]
                                   ],

                              ],

                             /* 'filter'=>[
                                   "range"=>[
                                        "inputtime"=>[
                                             "gte"=>time()-7776000,
                                             "lte" =>time(),
                                        ],
                                   ]
                              ]*/
                         ],

                    ],
                    'sort'=>[
                         '_score'=>[
                              'order'=>'desc',
                         ],
                         'created_at'=>[
                              'order'=>'desc',
                         ],
                    ],
                    'min_score'=>0.3
               ],
          ];

          $results = $this->client->search($params);

          $data=array();
          if(!empty($results['hits']))
          {
               $data['total']=($results['hits']['total']>500?500:$results['hits']['total']);
               foreach ($results['hits']['hits'] as $key=>$value)
               {
                    $data['item'][]=[
                         'id'=>$value['_source']['id'],
                         'score'=>$value['_score'],
                         'title'=>$value['_source']['title'],
                         'description'=>$value['_source']['description'],
                         'created_at'=>$value['_source']['created_at'],
                         'is_img'=>$value['_source']['is_img'],
                         'thumb'=>$value['_source']['thumb'],
                         'click'=>$value['_source']['click'],
                    ];
               }
          }

          return $data;

     }
}
