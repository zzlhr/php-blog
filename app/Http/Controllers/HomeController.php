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
use App\Http\Controllers\PublicData;

class HomeController extends Controller
{
    public $public_util;

    function __construct() {
        $this->public_util = new PublicData();
    }

    public function index(){

        //查询推荐文章
        $commend_article_list = DB::select('select *  from article WHERE article_commend=1 ORDER BY `id` DESC limit 0,10 ');


        //标题等网站基本信息
        $site = $this->public_util->getsite();

        //最新文章
        $newArticle = $this->public_util->getNewArticle();


        //友情链接
        $frined_links = $this->public_util->getFriendLink();

        for ($i=0;$i<count($commend_article_list);$i++){
            $keyword = $commend_article_list[$i]->article_keyword;
            $keyarray = explode(",", $keyword);
            $commend_article_list[$i]->article_keyword = $keyarray;
        }


        return view('index', ['site' => $site, 'commends' => $commend_article_list, 'friends' => $frined_links, 'type' => 1, 'articles_new' => $newArticle]);

    }




}