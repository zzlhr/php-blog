<?php
/**
 * Created by PhpStorm.
 * User: lhr
 * Date: 2017/12/5
 * Time: 上午10:02
 */

namespace App\Http\Controllers;

use DB;
use Log;

class HomeController extends Controller
{


    /**
     * 获取站点信息。
     * @return mixed
     */
    public function getsite(){

        $site = DB::select('select 
                    `website_title`, `website_subhead`, 
                    `website_keyword`, `website_describe` 
                  from `website`
                  WHERE `id`=1');

        return $site;
    }


    public function index(){

        //查询推荐文章
        $commend_article_list = DB::select('select *  from article WHERE article_commend=1 ORDER BY `id` DESC limit 0,10 ');


        //标题等网站基本信息
        $site = $this->getsite();

        //友情链接
        $frined_links = $this->getFriendLink();

        for ($i=0;$i<count($commend_article_list);$i++){
            $keyword = $commend_article_list[$i]->article_keyword;
            $keyarray = explode(",", $keyword);
            $commend_article_list[$i]->article_keyword = $keyarray;
        }

//        Log::info($site[0]->$commend_article_list);
//        Log::info($site[0]->website_subhead);

        return view('index', ['site' => $site, 'commends' => $commend_article_list, 'friends' => $frined_links, 'type' => 1]);

    }


    public function getFriendLink(){
        $links = DB::select('select * from `friend_link` WHERE `link_status`=0 ORDER BY `link_location` DESC ');
        return $links;
    }


}