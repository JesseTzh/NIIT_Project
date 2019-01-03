<?php
/**
 * Created by PhpStorm.
 * User: life0
 * Date: 2019/1/3
 * Time: 13:27
 */

namespace app\admin\Controller;

use think\Controller;
use app\index\controller\Customer;
use app\employee\controller\Employee;

class Admin extends Controller{
    public function index(){
        //进入后的主函数，待完善为dashboard
        $this->redirect('admin_customer');
}

    public function admin_customer(){
//        return $this->fetch('admin');
//        dump(config());
        $customer = new Customer;
        $customerList = $customer->lists_val();
        $this->assign('customerList', $customerList);
        return $this->fetch('admin_customer');
    }

    public function admin_employee(){
        //员工管理
        $employee = new Employee;
        $employeerList = $employee->lists_val();
        $this->assign('employeeList', $employeerList);
        return $this->fetch('admin_employee');
    }
}