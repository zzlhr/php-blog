<?php
/**
 * Created by PhpStorm.
 * User: lhr
 * Date: 2017/12/6
 * Time: 上午9:04
 */

namespace App\Http\Controllers;
use DB;
use Mockery\Exception;
use Illuminate\Http\Request;



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
        $articles = DB::select('select `id`, `article_title`,`article_url` from `article` ORDER BY `id` DESC LIMIT 0,5');
        return $articles;
    }

    /**
     * 获取域名
     * @param Request $request
     * @return mixed
     */
    public function getDomain(){

        $domain = DB::select('select `website_realmname` from `website` WHERE `id`=1');
        return $domain[0]->website_realmname;


    }


    /**
     * 获取uuid
     * @return string
     */
    public function guid(){
        if (function_exists('com_create_guid')){
            return com_create_guid();
        }else{
            mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
            $charid = strtoupper(md5(uniqid(rand(), true)));
            $hyphen = chr(45);// "-"
            $uuid = chr(123)// "{"
                .substr($charid, 0, 8).$hyphen
                .substr($charid, 8, 4).$hyphen
                .substr($charid,12, 4).$hyphen
                .substr($charid,16, 4).$hyphen
                .substr($charid,20,12)
                .chr(125);// "}"
            return $uuid;
        }
    }


    /**
     * 验证token
     * @param Request $request
     * @return bool
     */
    public function tokenIsTrue(Request $request){

        $id = $request->cookie('id');
        $token = $request->cookie('token');

        if ($id == null || $token == null){
            return false;
        }

        try{
            $admin = DB::select('select `admin_token` from `admin` WHERE `id`='.$id)[0];
            if($admin->admin_token == $token){
                return true;
            }
        }catch (Exception $e){
            report($e);
            return false;
        }
        return false;
    }


    public function object_array($array) {
        if(is_object($array)) {
            $array = (array)$array;
        } if(is_array($array)) {
            foreach($array as $key=>$value) {
                $array[$key] = object_array($value);
            }
        }
        return $array;
    }
}