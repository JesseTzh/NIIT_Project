<?php

//由ThinkphpHelper自动生成,请根据需要修改
namespace app\product\controller;

use think\Controller;

class Product extends Controller{
	protected $model = null;

	public function _initialize(){	//初始化
		$this->model = new \app\product\model\Product;
	}
	    //默认入口
    public function index(){
        $this->redirect('lists');
    }
		//新增
	public function add(){
		if($this->request->isPost()){
			$flag = $this->model->add($this->request);
			if($flag){
				$this->success('添加成功', url('lists'));
			}else{
				$this->error('添加失败');
			}
		}else{
			return $this->fetch();
		}
	}
		//修改
	public function edit(){
		if($this->request->isPost()){
			$flag = $this->model->edit($this->request);
			if($flag){
				$this->success('编辑成功', url('lists'));
			}else{
				$this->error('编辑失败');
			}
		}else{
			$product = $this->model->info($this->request);
			$this->assign('product', $product);
			return $this->fetch();
		}
	}
		//删除
	public function delete(){
		$flag = $this->model->del($this->request);
		if($flag){
			$this->success('删除成功', url('lists'));
		}else{
			$this->error('删除失败');
		}
	}
	    //批量删除
    public function delList(){
        $flag = $this->model->delList($this->request);
        if($flag){
			$this->success('删除成功', url('lists'));
		}else{
			$this->error('删除失败');
		}
    }
	    //id单个查询
    public function info(){
        $product = $this->model->info($this->request);
        $this->assign('product', $product);
        return $this->fetch();
    }
		//列表
	public function lists(){
		$productList = $this->model->lists($this->request, 12);	
		$this->assign('productList', $productList);
		return $this->fetch();
	}
    public function sort(){
        return $this->fetch();
    }
    public function getPost(){
	    $request = request();
	    $result = $request->post();
	    dump($result);
    }
}
