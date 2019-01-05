<?php
/**
 * Created by PhpStorm.
 * User: life0
 * Date: 2019/1/5
 * Time: 21:14
 */

namespace app\logout\controller;

use think\Controller;
use think\Session;

class Logout extends Controller{
    public function logout(){
        \session(null);
        $this->redirect('/index.php/login/login/index');
    }
}