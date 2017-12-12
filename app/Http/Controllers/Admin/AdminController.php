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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Redirect;
use DB;


class AdminController extends Controller
{

    public $public_util;

    function __construct() {
        $this->public_util = new PublicData();
        return $this;
    }



    public function index(){
        $site = $this->public_util->getsite();
        $title = $site[0]->website_title;

        return view(
            'admin/index',
            [
                'title'=>$title,

            ]
        );
    }


    public function login(Request $request){
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
//            return redirect('/admin/index.html')->with('token', $admin->admin_token)->with('name', $admin->admin_name);
            return response()
                        ->view('admin/index',[
                            'title'=>$title,
                            'name'=>$admin->admin_name,
                            'token'=>$admin->admin_token,
                        ])
                        ->cookie('name', $admin->admin_name)
                        ->cookie('token', $admin->admin_token)
                ;
        }else{
            $alertstr = '<script>alert("账号或密码错误！");location.href="login.html"</script>';
            return response($alertstr, 200);
        }


    }


}