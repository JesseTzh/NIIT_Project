<?php
/**
 * Created by PhpStorm.
 * User: life0
 * Date: 2018/12/31
 * Time: 22:54
 */

namespace app\login\controller;
use think\Controller;
use think\Request;
use app\login\model\Employee;
use app\login\model\LoginRecord;
use think\Session;
use think\Db;

class Login extends Controller{

    public function index(){
        //展示登录表单
        $this->assign('login_message', 'hello');
        return $this->fetch('index');
    }

    public function login(){
        //登录功能的实现
        //本方法通过输入框name获取值
        $employee_num = Request::instance()->post('employee_num');
        $employee_password = Request::instance()->post('employee_password');
        //调用model层LoginRecord对象check功能，验证是否需要封禁IP
       if(LoginRecord::check($employee_num)){
           //返回true，允许登录
           //调用model层Employee对象下login功能
           if(Employee::login($employee_num, $employee_password)){
               //登陆成功，记录入库
               LoginRecord::record($employee_num, 'success');
               //登录成功，取部门ID，根据部门不同进行转发，并将部门ID写入sessio
               $employee_character_num = Db::table('employee')->where('employee_num', $employee_num)->value('employee_character_num');
               \session('employee_character_num', $employee_character_num);
               $this->redirect('index/Customer/lists');
//               switch ($employee_character_num){
//                   case 1:
//                       $this->redirect('manager/manager/show');
//                   //留空等待补充
//               }
           }
           else{
               //登录失败，记录入库
               LoginRecord::record($employee_num, 'false');
               $this->assign('login_message', 'false');
               return $this->fetch('index');
           }
       }
       else{
           //30秒内连续3次登录失败，停止登录且不记录本次登录操作
           $this->assign('login_message', 'ban');
           return $this->fetch('index');
       }
    }
}