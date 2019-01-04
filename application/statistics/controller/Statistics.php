<?php
/**
 * Created by PhpStorm.
 * User: 86744
 * Date: 2019/1/4
 * Time: 13:30
 */

namespace app\statistics\controller;
use think\Controller;
use think\Db;
use think\Session;

class Statistics extends Controller
{
    public function sql(){
        $sql_se = \session('employee_num');
        $sql_new = new Statistics;
        $sql = "这里填SQL语句";
        $sql_res = $sql_new->query($sql);
        dump($sql_res);
        //会输出一个二维数组，注意是0开始
        $res[$i] = $sql_res[0]["这里是select后面的字段"];
        //查询特定员工本月利润,员工编码即为$sql_se
        echo json.encode($res);
        //如果前端是Echart的话
        return "一个数组";
        //如果前端是表格的话
        return "一个数字";
        //如果是只返回一个数字的话
    }

}
