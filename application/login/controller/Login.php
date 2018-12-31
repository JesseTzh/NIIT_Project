<?php
/**
 * Created by PhpStorm.
 * User: life0
 * Date: 2018/12/31
 * Time: 22:54
 */

namespace app\login\controller;
use think\Controller;

class Login extends Controller{
    public function login(){
//        dump(config());
        return view('login', ['name'=> 'aaa']);
    }
}