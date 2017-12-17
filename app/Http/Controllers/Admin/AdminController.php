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
use Illuminate\Support\Facades\Log;
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

        //验证登录
        if (!$this->public_util->tokenIsTrue($request)){
//            Log::info('#################未通过验证！####################');
            throw new Exception('未通过验证');
        }
//        Log::info('#################通过验证！####################');

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


    /**
     * 后台首页渲染。
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
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


    /**
     * 登录方法
     * @param CookieJar $cookieJar
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response|\Symfony\Component\HttpFoundation\Response
     */
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


    /**
     * 文章列表页
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function articlelist(Request $request){

        try{
            $result = $this->init($request,'文章列表');

        }catch (Exception $e){
            return redirect("/admin/login.html");
        }


        $article_title = $request->get('title');
        $article_keyword = $request->get('keyword');
        $clazz = $request->get('clazz');
        $page = $request->get('page');

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


    /**
     * 添加文章页面
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function articleadd(Request $request){

        try{
            $result = $this->init($request,'添加文章');

        }catch (Exception $e){
            return redirect("/admin/login.html");
        }

//        $result = $this->init($request, '添加文章');

        //该参数没啥用，只是为了兼容修改页面。
        $result['id'] = 0;

        $result['class'] = $this->getClass();

        //type 判断是: 添加1，修改2，详情3
        $result['type'] = 1;


        return view('admin/articleadd',$result);
    }

    /**
     * 添加文章post提交方法。
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function add_article(Request $request){


        if (!$this->public_util->tokenIsTrue($request)){
            return redirect('/admin/login.html');
        }

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


    /**
     * 修改文章get页面方法。
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function articleupdate(Request $request){
        try{
            $result = $this->init($request,'修改文章');

        }catch (Exception $e){
            return redirect("/admin/login.html");
        }


        $id = $request->get('id');


        $result['id'] = $id;

        $result['type'] = 2;

        $result['class'] = $this->getClass();

        $result['article'] =
            DB::table('article')
                ->where('id',$id)
                ->get()[0];

        return view('admin/articleadd', $result);
    }


    /**
     * 修改文章post提交方法。
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function update_article(Request $request){

        if (!$this->public_util->tokenIsTrue($request)){
            return redirect("/admin/login.html");
        }


        $id = $request->get('id');
        $title = $request->get('title');
        $class= $request->get('class');
        $keyword = $request->get('keyword');
        $describe = $request->get('describe');
        $content = $request->get('content');


        if ($id == null || $id == 0){
            return response('<script>alert(\'修改失败,id不能为空\');</script>',200);
        }
        if ($title == null || $title == ""){
            return response('<script>alert(\'修改失败,标题不能为空\');</script>',200);
        }
        if ($class == null || $class == ""){
            return response('<script>alert(\'修改失败,分类不能为空\');</script>',200);
        }
        if ($content == null || $content == ""){
            return response('<script>alert(\'修改失败,内容不能为空\');</script>',200);
        }

        DB::table('article')
            ->where('id',$id)
            ->update([
                'article_title' => $title,
                'article_class' => $class,
                'article_text' => $content,
                'article_keyword' => $keyword,
                'article_describe' => $describe
            ]);
        return response('<script>alert(\'修改成功！\');</script>',200);

    }


    /**
     * 文章详情页面。
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function articleinfo(Request $request){


        try{
            $result = $this->init($request,'文章详情');

        }catch (Exception $e){
            return redirect("/admin/login.html");
        }


        $id = $request->get('id');

        $result['id'] = $id;

        $result['type'] = 0;

        $result['class'] = $this->getClass();

        $result['article'] =
            DB::table('article')
                ->where('id',$id)
                ->get()[0];

        return view('admin/articleadd', $result);
    }



    /**
     * 删除文章。
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function articledelect(Request $request){


        if (!$this->public_util->tokenIsTrue($request)){
            return redirect("/admin/login.html");
        }

        $id = $request->get('id');

        if($id == null || $id ==0){
            return response('<script>alert(\'删除失败！\');</script>',200);
        }

        DB::table('article')->where('id', $id)->delete();

        return response('<script>alert(\'删除成功！\');location.href=\'articlelist.html\';</script>',200);

    }



    public function test(){
        $url = '/article/'.(DB::select('select max(id) AS id from `article`')[0]->id+1);
        return response('<script>alert(\''.
            $url
            .'\');</script>', 200);
    }
}