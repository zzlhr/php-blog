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
use Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;


class ArticleController extends Controller
{

    public $public_util;

    function __construct() {
        $this->public_util = new PublicData();
        return $this;
    }

    public function index($id){



        $domain = $this->public_util->getDomain();

        $article_info = DB::select('select * from article WHERE `id` = ?', [$id]);

        DB::update('update `article` set `article_click`='.($article_info[0]->article_click  +1).' where `id`='.$id);
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


        //评论
        $comments = DB::select('select `comment_name`,`comment_text`,`create_time`,`comment_fid` from `article_comment` WHERE `article_id`=? AND comment_status=0 ORDER BY `id` DESC ',[$id]);


        return view(
            'index',
            [
                'site' => $site,
                'friends' => $frined_links,
                'article' => $article_info[0],
                'type' => 2,
                'articles_new' => $newArticle,
                'domain' => $domain,
                'comments' => $comments,
            ]
        );
    }

    public function comment(Request $request)
    {
        $fid = $request->get('fid');
        $id = $request->get('id');
        $name = $request->get('name');
        $content = $request->get('content');
        if ($id == null){
            $alertstr = '<script>alert("id不能为空！");location.href="'.$id.'"</script>';
            return response($alertstr, 200);
        }
        if ($name == null){
            $alertstr = '<script>alert("昵称不能为空！");location.href="'.$id.'"</script>';
            return response($alertstr, 200);
        }
        if ($content == null){
            $alertstr = '<script>alert("内容不能为空！");location.href="'.$id.'"</script>';
            return response($alertstr, 200);
        }

        if (!$fid >= 0){
            $fid = 0;
        }
        try{
            DB::insert('insert into `article_comment` (`article_id`, `comment_fid`,`comment_name`,`comment_text`,`comment_ip`) VALUE (?,?,?,?,?)',[$id, $fid, $name, $content, $request->getClientIp()]);
            $alertstr = '<script>alert("评论成功！");location.href="'.$id.'"</script>';
            return response($alertstr, 200);

        }catch (Exception $e){
            echo 'Error: '.$e->getMessage();
            DB::rollBack();
            $alertstr = '<script>alert("评论失败！");location.href="'.$id.'"</script>';
            return response($alertstr, 200);
        }

    }


}