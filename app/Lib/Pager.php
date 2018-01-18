<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/10
 * Time: 14:32
 */
namespace App\Lib;

class Pager{


    public static function _page($options = []) {
        $default_options = [
            'current_page' => 1,    // 当前页
            'per_page' => 10,       // 每页数量
            'total_page' => null,   // 总页数
            'total_item' => 0,      // 元素总数  与 总页数 2选1
            'total_link' => 5,      // 链接总数
            'first_link' => false,   // 是否显示首页
            'last_link' => false,    // 是否显示尾页
            'prev_link' => true,    // 是否显示上一页
            'next_link' => true,    // 是否显示下一页
            'path_deep' => 1,       // 路径深度   category/default/3    => deep = 2
            'path_type' => 0,       // 路径类型   category/default?page=3    => type = 1
            'ul_class' =>'',  //ul 样式
            'current_class' => '', //当前 样式
        ];

        $options = array_merge($default_options, $options);

        $path_deep = $options['path_deep'];
        $path_type = $options['path_type'];

        $current_page = $options['current_page'] > 0 ? $options['current_page'] : 1;
        $per_page = $options['per_page'] > 0 ? $options['per_page'] : 10;
        // 总页数
        if (is_null($options['total_page'])) {  // 未设置总页数
            if ($options['total_item'] > 0) {
                $total_page = intval($options['total_item'] / $per_page);
                if ($options['total_item'] % $per_page > 0) {
                    $total_page += 1;
                }
            } else {
                $total_page = 0;
            }
        } else {
            $total_page = $options['total_page'] > 0 ? $options['total_page'] : 0;
        }

        // 总链接数
        $total_link = $options['total_link'] > 0 ? $options['total_link'] : 0;
        $total_link = $total_link > $total_page ? $total_page : $total_link;


        $links = '';
        if($options['current_page']>1){
            $links .= '<li><a href="' . self::_link(1, $path_deep, $path_type) . '">首页</a></li>';
        }

        // 上一页 第一页
        if (1 < $options['current_page']) {
            if ($options['first_link']) {
                $links .= '<li><a href="' . self::_link(1, $path_deep, $path_type) . '">上一页</a></li>';
            }
            if ($options['prev_link']) {
                $links .= '<li><a href="' . self::_link($current_page - 1, $path_deep, $path_type) . '" rel="prev">上一页</a></li>';
            }
        }

        // 循环起始页
        $start_page = 1;
        if ($total_link > 0) {
            $cut_page = intval($total_link / 2);
            if ($current_page - $cut_page > 0) {
                if ($current_page + $cut_page > $total_page) {
                    $start_page = $total_page - $total_link + 1;
                } else {
                    $start_page = $current_page - $cut_page;
                }
            }
        }
        $start_page = $start_page > 0 ? $start_page : 1;

        for ($i = 0; $i < $total_link; $i++) {
            $the_page = $start_page + $i;
            if ($the_page == $current_page) {
                $links .= '<li class="'.$options['current_class'].'"><a href="javascript:;">' . $the_page . '</a></li>';
            } else {
                $links .= '<li><a href="' . self::_link($the_page, $path_deep, $path_type) . '">' . $the_page . '</a></li>';
            }
        }

        // 下一页 尾页
        if ($total_page > $options['current_page']) {
            if ($options['next_link']) {
                $links .= '<li><a href="' . self::_link($current_page + 1, $path_deep, $path_type) . '" rel="next">下一页</a></li>';
            }
            if ($options['last_link']) {
                $links .= '<li><a href="' . self::_link($total_page, $path_deep, $path_type) . '">下一页</a></li>';
            }
        }
        if($options['current_page']<$total_page){
            $links .= '<li><a href="' . self::_link($total_page, $path_deep, $path_type) . '">尾页</a></li>';
        }

        //$links .="<li><span>共<strong>".$total_page."</strong>页</span></li>";
        return '<ul class="'.$options['ul_class'].'">' . $links . '</ul>';
    }

    /**
     *
     * /cate/demo/2             $type=0 $deep=2 $page=2
     * /cate/demo?page=2        $type=1 $deep=2||null $page=2
     *
     * @param int $page
     * @param int $deep
     * @param int $type
     * @return \Illuminate\Contracts\Routing\UrlGenerator|string
     */
    private static function _link($page = 1, $deep = 1, $type = 0) {
        if (is_null($deep)) {
            $base_uri = \Request::path();
        } else {
            $segments = \Request::segments();
            $base_uri = '';
            if ($segments) {
                $deep_real = count($segments);
                $deep = $deep > $deep_real ? $deep_real : $deep;
                for ($i = 0; $i < $deep; $i ++) {

                    $base_uri .= $segments[$i] . '/';

                }
            }
        }
        $base_uri = rtrim($base_uri, "\/");
        $base_uri = preg_replace('/(\d+).html/','',$base_uri);
        $base_uri = rtrim($base_uri, '/') ."/";



        $query = array();//下下策，因为windows和服务器获取的值不一样，先保证上线

        if (1 == $type) {
            if (1 != $page) {   // 首页hack
                $query['page'] = $page;
            } else {
                if (isset($query['page'])) {
                    unset($query['page']);
                }
            }
        } else {
            $base_uri = 1 == $page ? $base_uri: $base_uri . $page .'.html';
        }

        if (empty($query)) {
            return url($base_uri);
        }

        return url($base_uri . '?' . http_build_query($query));
    }
}