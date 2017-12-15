<?php
/**
 * Created by PhpStorm.
 * User: lhr
 * Date: 2017/12/12
 * Time: 下午5:41
 */


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\PublicData;
use Illuminate\Cookie\CookieJar;
use Illuminate\Http\Request;
use DB;
use Mockery\Exception;


class AdminController extends Controller
{

    public $public_util;

    public $adminObj;

    function __construct() {
        $this->public_util = new PublicData();
        return $this;
    }



    function getAdmin(Request $request){
        $this->adminObj['name'] = $request->cookie('name');
        $this->adminObj['token'] = $request->cookie('token');
    }


    function init(Request $request, $title){
        $this->getAdmin($request);
        $this->adminObj['fmenu'] = DB::select('select * from auth_model');
        $this->adminObj['cmenu'] = DB::select('select * from auth_operate WHERE `operate_type`=1');


        $result = [
            'title'=>$title,
            'name'=>$this->adminObj['name'],
            'token'=>$this->adminObj['token'],
            'fmenu'=>$this->adminObj['fmenu'],
            'cmenu'=>$this->adminObj['cmenu'],
        ];

        return $result;

    }


    public function index(Request $request){
        try{
            $site = $this->public_util->getsite();

            $result = $this->init($request,$site[0]->website_title);

        }catch (Exception $e){
            return redirect("/admin/login.html");
        }


        if ($this->adminObj['name'] == null || $this->adminObj['token']  == null || !$this->public_util->tokenIsTrue($request)){
            return redirect("/admin/login.html");
        }

        return view('admin/index', $result);
    }


    public function login(CookieJar $cookieJar, Request $request){
        $name = $request->get('name');
        $password = $request->get('password');

        if ($name == null){
            $alertstr = '<script>alert("账号不能为空！");location.href="login.html"</script>';
            return response($alertstr, 200);
        }
        if ($password == null){
            $alertstr = '<script>alert("密码不能为空！");location.href="login.html"</script>';
            return response($alertstr, 200);
        }


        $admin = DB::select("select * from `admin` WHERE `admin_name`='".$name."'")[0];
//        echo md5($password);
        if ($admin->admin_password == md5($password)){
            $site = $this->public_util->getsite();
            $title = $site[0]->website_title;


            $admin->admin_token = md5($this->public_util->guid());
            DB::update('update `admin` set `admin_token`=\''.$admin->admin_token.'\'');

            $admin_name = $admin->admin_name;
            $admin_token = $admin->admin_token;
            $admin_id = $admin->id;
//            $cookieJar->make('name',$name);
//            $cookieJar->make(cookie());

            $cookieJar->queue($cookieJar->forever('name',$admin_name));
            $cookieJar->queue($cookieJar->forever('token',$admin_token));
            $cookieJar->queue($cookieJar->forever('id',$admin_id));

            return response()->view('admin/login_success',[
                'name'=>$name,
            ]);

//                response($alertstr, 200)
//                        ->cookie('name', $admin->admin_name)
//                        ->cookie('token', $admin->admin_token)


        }else{
            $alertstr = '<script>alert("账号或密码错误！");location.href="login.html"</script>';
            return response($alertstr, 200);
        }


    }


    public function articlelist(Request $request){


        $article_title = $request->get('title');
        $article_keyword = $request->get('keyword');
        $clazz = $request->get('clazz');
        $page = $request->get('page');



        $result = $this->init($request,'文章列表');

        $result['clazz_dorpdown'] = $this->getClass();

        $result['page'] = $page;

        $result['articles'] = DB::table('article')
                        ->when($article_title, function ($query) use ($article_title){
                            return $query->where('article_title', 'like', '%'.$article_title.'%');
                        })
                        ->when($article_keyword, function ($query) use ($article_keyword){
                            return $query->where('article_keyword', 'like', '%'.$article_keyword.'%');
                        })
                        ->when($clazz, function ($query) use ($clazz){
                            return $query->where('article_class', $clazz);
                        })
                        ->orderBy('id', 'desc')
                        ->paginate(15);

        return view('admin/articlelist',$result);
    }



    public function getClass(){
        return DB::select('select `class_name` from article_class');

    }



    public function articleadd(Request $request){


        $result = $this->init($request, '添加文章');


        $result['class'] = $this->getClass();

        return view('admin/articleadd',$result);
    }

    public function add_article(Request $request){

        $title = $request->get('title');
        $class= $request->get('class');
        $keyword = $request->get('keyword');
        $describe = $request->get('describe');
        $content = $request->get('content');



        if ($title == '' || $class == '' || $keyword == '' || $describe == '' || $content == ''){
            return response('<script>alert(\'非法参数！\');</script>',200);
        }

        $url = '/article/'.(DB::select('select max(id) AS id from `article`')[0]->id+1);



        try{
            DB::insert('insert into `article` (`article_title`, `article_class`, `article_keyword`,`article_describe`, `article_text`, `article_url`) VALUES (?,?,?,?,?,?)',[$title, $class, $keyword, $describe, $content,$url]);
        }catch (Exception $e) {
            return response('<script>alert(\'添加失败！\');</script>',200);
        }

        return response('<script>alert(\'添加成功！\');</script>',200);




    }



    public function test(){
        $url = '/article/'.(DB::select('select max(id) AS id from `article`')[0]->id+1);
        return response('<script>alert(\''.
            $url
            .'\');</script>', 200);
    }
}