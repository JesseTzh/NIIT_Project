<?php
namespace application\model\controller;

use think\Controller;

class Index extends Controller
{
    public function index()
    {
        dump(config());
    }
}
