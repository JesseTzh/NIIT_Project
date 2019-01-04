<?php
namespace Utils;

class OfficeUtils{

    public static function arrayCover($array){
        $keys = $array[0];
        $result = array();
        for($i=1;$i<count($array);$i++){
            $row = array();
            for($j=0;$j<count($keys);$j++){
                $key = $keys[$j];
                $row[$key]=$array[$i][$j];
            }
            $result[] = $row;
        }
        return $result;
    }

    public static function read($file_path){
        $file_format = substr($file_path, strrpos($file_path, '.')+1);
        try{
            if($file_format == 'xlsx'){
                $xlsx = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                $can_read = $xlsx->canRead($file_path);
                if($can_read){
                    $content = $xlsx->load($file_path)->getActiveSheet()->toArray(); 
                    $content = OfficeUtils::arrayCover($content);
                    return $content;
                }else{
                    return false;
                }
            }elseif ($file_format == 'xls'){
                $xls = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
                $can_read = $xls->canRead($file_path);
                if($can_read){
                    $content = $xls->load($file_path)->getActiveSheet()->toArray();
                    return $content;
                }else{
                    return false;
                }
            }else{
                return false;
            } 
        }catch(Exception $e){
            return false;
        }
    }

    public static function wirte(){
    }


}
