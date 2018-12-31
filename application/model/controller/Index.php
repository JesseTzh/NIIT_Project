<?php
namespace app\model\controller;

use think\Controller;

class Index extends Controller
{
    public function index()
    {
        //dump(config());
        return $this->fetch('buttons');
    }
}
