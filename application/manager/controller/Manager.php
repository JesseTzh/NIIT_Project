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
use app\index\controller\Customer;
use app\employee\controller\Employee;
use app\index\controller\Order;
use app\aftersale\controller\AfterSale;
use app\feedback\controller\Feedback;
use app\statistics\controller\Statistics;

class Manager extends Controller{
    public function show(){
        //调用公共函数，验证是否登录
        if(IsLogin::is_login()){
            //已登录
            //显示部门经理页面
            $monthly_profit = Statistics::department_monthly_profit();
            $quart_profit = Statistics::department_quarter_profit();
            $sale_room = Statistics::department_saleroom();
            $star_employee = Statistics::department_star_employee();
            $top_five_employee = json_decode(Statistics::department_employee_top5());
            $this->assign('monthly_profit', $monthly_profit);
            $this->assign('quart_profit', $quart_profit);
            $this->assign('sale_room', $sale_room);
            $this->assign('star_employee', $star_employee);
            $this->assign('top_five_employee', $top_five_employee);
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

    public function manager_customer(){
//        return $this->fetch('admin');
//        dump(config());
        $customer = new Customer;
        $customerList = $customer->lists_val();
        $this->assign('customerList', $customerList);
        return $this->fetch('manager_customer');
    }

    public function manager_order(){
//        return $this->fetch('admin');
//        dump(config());
        $order = new Order;
        $orderlist = $order->lists_val();
        $this->assign('orderList', $orderlist);
        return $this->fetch('manager_order');
    }

    public function manager_employee(){
        //员工管理
        $employee = new Employee;
        $employeerList = $employee->lists_val();
        $this->assign('employeeList', $employeerList);
        return $this->fetch('manager_employee');
    }

    public function manager_aftersale(){
        //员工管理
        $after_sale = new AfterSale;
        $after_List = $after_sale->lists_val();
        $this->assign('after_saleList', $after_List);
        return $this->fetch('manager_aftersale');
    }

    public function manager_feedback(){
        //员工管理
        $feedback = new Feedback;
        $feedback_List = $feedback->lists_val();
        $this->assign('feedbackList', $feedback_List);
        return $this->fetch('manager_feedback');
    }
}