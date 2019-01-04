<?php
//由ThinkphpHelper自动生成,请根据需要修改
namespace app\index\model;

use think\Model;
use think\Session;

class Order extends Model {
		    //新增
    public function add($request){
        $data = $request->param();
        foreach($data as $key=>$val){
            if(is_array($val)){    //处理checkbox情况
                $data[$key] = implode("#op#", $val);
            }
        }
        return $this->data($data)->allowField(true)->save();
    }
	    //修改
    public function edit($request){
        $data = $request->param();
        foreach($data as $key=>$val){
            if(is_array($val)){    //处理checkbox情况
                $data[$key] = implode("#op#", $val);
            }
        }
        return $this->allowField(true)->save($data, ['id' => $data['id']]);
    }
	    //删除
    public function del($request){
        $id = $request->param('id');
        return $this->where('id',  $id)->delete();
    }
	    //批量删除
    public function delList($request){
        $condition = $request->request('condition');
        return $this->destroy(json_decode($condition));
    }
	    //id单个查询
    public function info($request){
        $id = $request->param('id');		
        return $this->where('id', $id)->find();
    }
	    //列表
    public function lists($request, $itemNum = 12){	//每页显示12条数据
        if(session('employee_character_num')>1){
            return $this->where("order_empolyee_id","=",session('employee_num'))->paginate($itemNum);
        }else if(session('employee_character_num')==1){
            //select a.* from `order` a inner join employee b on a.order_empolyee_id = b.employee_num where b.employee_department_num = 7;
            return $this
                ->table('order')
                ->alias('a')
                ->field('a.*')
                ->join('employee b','a.order_empolyee_id=b.employee_num')
                ->where("b.employee_department_num","=",session('employee_department_num'))->paginate($itemNum);
        }else{
            $condition = $request->param('condition');
            return $this->where(json_decode($condition))->paginate($itemNum);
        }
    }

}	
