<?php
/**
 * Created by PhpStorm.
 * User: lhr
 * Date: 2017/12/5
 * Time: 下午2:52
 */

namespace App\Http\Controllers\Article;


use DB;

use App\Http\Controllers\Controller;
use Mockery\Exception;

class ArticleController extends Controller
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


    public function index($id){

//        $param = $request->all();
//        echo $param;

//        Log::info("param", $param);
//        Log::info("id={}",$id);


        $article_info = DB::select('select *  from article WHERE `id` = ?', [$id]);

        if (count($article_info) == 0){
            // todo: 文章找不到
            return 404;
        }

        $keyword = $article_info[0]->article_keyword;
        $keyarray = explode(",", $keyword);
        $article_info[0]->article_keyword = $keyarray;

        $site = $this->getsite();

        //友情链接
        $frined_links = $this->getFriendLink();

        return view('index', ['site' => $site,'friends' => $frined_links, 'article' => $article_info[0], 'type' => 2]);
    }


    public function test(){
        return "Test";
    }

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

}