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
            $top_five_employee = Statistics::department_employee_top5();
            $goal = Statistics::department_goal();

            $monthly_goal = (int)(($goal[0]['total']/$goal[0]['goal'])*100);
            $quart_goal = (int)(($goal[1]['total']/$goal[1]['goal'])*100);
            $year_goal = (int)(($goal[2]['total']/$goal[2]['goal'])*100);


            $this->assign('monthly_profit', $monthly_profit);
            $this->assign('quart_profit', $quart_profit);
            $this->assign('sale_room', $sale_room);
            $this->assign('star_employee', $star_employee);
            $this->assign('monthly_goal',$monthly_goal);
            $this->assign('quart_goal',$quart_goal);
            $this->assign('year_goal',$year_goal);
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
            $product_top_five = Statistics::company_product_top5();
            $produce_bottom_five = Statistics::company_product_last5();
            $problem_product_top_five = Statistics::defective_product_top();
            $problem_product_bottom_five = Statistics::defective_product_last();
            $this->assign('product_top_five', $product_top_five);
            $this->assign('product_bottom_five', $produce_bottom_five);
            $this->assign('problem_product_top_five', $problem_product_top_five);
            $this->assign('problem_product_bottom_five', $problem_product_bottom_five);
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