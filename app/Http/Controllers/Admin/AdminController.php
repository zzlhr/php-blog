<?php
/**
 * Created by PhpStorm.
 * User: lhr
 * Date: 2017/12/12
 * Time: 下午5:41
 */


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function index(){

    }


    public function login(){
        return view('admin/login');
    }


}