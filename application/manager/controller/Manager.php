<?php
/**
 * Created by PhpStorm.
 * User: life0
 * Date: 2019/1/2
 * Time: 0:22
 */
namespace app\manager\controller;

use think\Controller;
use think\Session;
use app\common\controller\IsLogin;

class Manager extends Controller{
    public function show(){
        //调用公共函数，验证是否登录
        if(IsLogin::is_login()){
            //已登录
            //显示部门经理页面
            return $this->fetch('index');
        }
        else{
            //未登录，跳转登录页面
            $this->redirect('login/login/index');
        }
    }

    public function product_dashboard(){
        //产品报表页面
        //调用公共函数，验证是否登录
        if(IsLogin::is_login()){
            //已登录
            //显示产品报表页面
            return $this->fetch('product_dashboard');
        }
        else{
            //未登录，跳转登录页面
            $this->redirect('login/login/index');
        }
    }
}