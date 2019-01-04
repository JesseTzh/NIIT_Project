<?php

namespace app\index\controller;

use think\Controller;
use Utils\OfficeUtils;

use app\index\model;

class Office extends Controller
{
    public function upload(){
        if(request()->method()=="GET"){
            $reffer_url = $_SERVER["HTTP_REFERER"];
            $url_array = explode("/",$reffer_url);
            $reffer_controller = $url_array[count($url_array)-2];
            $this->assign('reffer',$reffer_controller);
            return $this->fetch('upload');
        } else {
            // 获取表单上传文件
            $file = request()->file('excel');
            $reffer = $this->request->only('reffer')["reffer"];

            // 移动到框架应用根目录/runtime/uploads/ 目录下
            if($file){
                $info = $file->move(ROOT_PATH . 'runtime' . DS . 'uploads');
                if($info){
                    //return '<script>alert("上传成功");</script>';
                    $path = $info->getPath() . DS . $info->getFileName();
                    $data_array = OfficeUtils::read($path);
                    if($data_array){    
                        //这里添加要导入数据表的model
                        switch($reffer){
                            case 'order':
                            $model = new model\Order;
                            break;
                            case 'customer':
                            $model = new model\Customer;
                            break;
                            default:
                            return $this->error('model未定义');
                        }
                        try{
                            //dump($data_array);
                            $model->saveAll($data_array);
                        }catch(Exception $e){
                            $this->error('导入失败\n'.$e->getMessage());
                        }
                        $this->success('导入成功');
                    }else{
                        $this->error('导入失败');
                    }
                }else{
                    // 上传失败获取错误信息
                    echo '上传失败';
                    echo $file->getError();
                }
            }else{
                $this->error('未选择文件');
            }
        }
    }
}
