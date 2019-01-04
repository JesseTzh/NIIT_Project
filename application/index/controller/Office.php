<?php

namespace app\index\controller;

use think\Controller;
use Utils\OfficeUtils;

use app\index\model\Customer;

class Office extends Controller
{
    public function upload(){
        if(request()->method()=="GET"){
            return $this->fetch();
        } else {
            // 获取表单上传文件
            $file = request()->file('excel');

            // 移动到框架应用根目录/runtime/uploads/ 目录下
            if($file){
                $info = $file->move(ROOT_PATH . 'runtime' . DS . 'uploads');
                if($info){
                    //return '<script>alert("上传成功");</script>';
                    $path = $info->getPath() . DS . $info->getFileName();
                    $data_array = OfficeUtils::read($path);
                    if($data_array){    
                        $Customer = new Customer;
                        $Customer->saveAll($data_array);
                        $this->success('导入成功');
                    }else{
                        $this->error('导入失败');
                    }
                }else{
                    // 上传失败获取错误信息
                    echo '上传失败';
                    echo $file->getError();
                }
            }
        }
    }
}
