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
use \App\Http\Controllers\PublicData;


class ArticleController extends Controller
{

    public $public_util;

    function __construct() {
        $this->public_util = new PublicData();
    }

    public function index($id){

        $domain = $this->public_util->getDomain();


        $article_info = DB::select('select * from article WHERE `id` = ?', [$id]);

        if (count($article_info) == 0){
            // todo: 文章找不到
            return 404;
        }

        $keyword = $article_info[0]->article_keyword;
        $keyarray = explode(",", $keyword);
        $article_info[0]->article_keyword = $keyarray;

        //获取站点信息
        $site = $this->public_util->getsite();

        //最新文章
        $newArticle = $this->public_util->getNewArticle();

        //友情链接
        $frined_links = $this->public_util->getFriendLink();

        return view(
            'index',
            [
                'site' => $site,
                'friends' => $frined_links,
                'article' => $article_info[0],
                'type' => 2,
                'articles_new' => $newArticle,
                'domain' => $domain,
            ]
        );
    }

    public function comment($id, $name, $content){
        
    }


}