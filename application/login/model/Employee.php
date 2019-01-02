<?php
/**
 * Created by PhpStorm.
 * User: life0
 * Date: 2019/1/1
 * Time: 14:17
 */

namespace app\login\model;

use think\Model;

class Employee extends Model{
    /**
     * @param $employee_num
     * @param $employee_password
     * @return bool
     * @throws \think\exception\DbException
     */
    static public function login($employee_num, $employee_password){
        //员工登录
//        $employee = new Employee();
        $Employee = self::get(array('employee_num' => $employee_num));
        if(!is_null($Employee)){
            //存在当前用户，验证密码
            if($Employee->checkPassword($employee_password)){
                //密码正确，id写入session
                session('employee_num', $employee_num);
                return true;
            }
            else{
                //密码错误，返回false
                return false;
            }
        }
        else{
            //用户不存在，返回false
            return false;
        }
    }

    public function checkPassword($employee_password){
        //验证密码
        if(($this->getAttr('employee_password')) === md5($employee_password)){
            //密码正确
            return true;
        }
        else{
            //密码错误
            return false;
        }
    }
}