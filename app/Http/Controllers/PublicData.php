<?php
/**
 * Created by PhpStorm.
 * User: lhr
 * Date: 2017/12/6
 * Time: 上午9:04
 */

namespace App\Http\Controllers;
use DB;


class PublicData
{

    public function __construct()
    {
        return $this;
    }

    /**
     * 获取站点信息。
     * @return mixed
     */
    public function getsite(){

        $site = DB::select('select 
                    `website_title`, `website_subhead`, 
                    `website_keyword`, `website_describe`,
                    `website_realmname`
                  from `website`
                  WHERE `id`=1');

        return $site;
    }


    /**
     * 获取友情链接
     * @return mixed
     */
    public function getFriendLink(){
        $links = DB::select('select * from 
                              `friend_link` 
                             WHERE 
                              `link_status`=0 
                             ORDER BY 
                              `link_location` 
                             DESC ');
        return $links;
    }


    public function getNewArticle(){
        $articles = DB::select('select `id`, `article_title` from `article` ORDER BY `update_time` DESC LIMIT 0,5');
        return $articles;
    }

}