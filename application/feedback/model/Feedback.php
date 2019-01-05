<?php
//由ThinkphpHelper自动生成,请根据需要修改
namespace app\feedback\model;

use think\Model;

class Feedback extends Model {
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
    public function lists($request, $itemNum = 12)
    {    //每页显示12条数据
        $condition = session('employee_num');
        $num = session('employee_character_num');
        $depart_num = session('employee_department_num');
        $kz = $request->param
        ('condition');
        //dump($depart_num);
        if ($num == 0)
            return $this->where(json_decode($kz))->paginate($itemNum);
        else if ($depart_num >= 1 && $depart_num <= 9)
            return $this->where('feedback_department', $depart_num)->paginate($itemNum);
        else
            return $this->where('feedback_after_sale_empolyee', $condition)->paginate($itemNum);
    }

}	