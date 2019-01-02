<?php
/**
 * Created by PhpStorm.
 * User: life0
 * Date: 2019/1/2
 * Time: 14:00
 */

namespace app\common\controller;

use think\Controller;
use think\Session;

class IsLogin extends Controller{
    static public function is_Login(){
        //验证当前用户是否登录
        $employee_num = session('employee_num');
        if(is_null($employee_num)){
            return false;
        }
        else{
            return true;
        }
    }
}