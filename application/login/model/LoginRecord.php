<?php
/**
 * Created by PhpStorm.
 * User: life0
 * Date: 2019/1/2
 * Time: 11:47
 */

namespace app\login\model;

use think\Model;

class LoginRecord extends Model{
    protected $table = 'record';

    static public function record($employee_num, $login_state){
        $login_num = NULL;
        $login_employee_num = $employee_num;
        $login_time = date('Y-m-d h:i:sa', time());
        $login_ip = $_SERVER['REMOTE_ADDR'];
        $login_user_agent = $_SERVER['HTTP_USER_AGENT'];
        $login_state = $login_state;
        $login_record = new LoginRecord;
        $login_record->data([
           'login_num' => $login_num,
            'login_employee_num' => $login_employee_num,
            'login_time' => $login_time,
            'login_ip' => $login_ip,
            'login_user_agent' => $login_user_agent,
            'login_state' => $login_state
        ]);
        $login_record->save();
    }

    static public function check($employee_num){
        //验证已经失败的登录次数
        $current_time = date('Y-m-d h:i:sa', time());
        $last_time = date('Y-m-d h:i:sa', time()-30);
        $count = self::where('login_ip', $_SERVER['REMOTE_ADDR'])->where('login_employee_num', $employee_num)->where('login_time', 'between', array($last_time, $current_time))->where('login_state', 'false')->count();
        if($count >= 3){
            //30秒内连续3次登录失败，封禁IP，返回false
            return false;
        }
        else{
            //30秒内连续登录失败不超过3次，返回true,允许登录
            return true;
        }
    }
}