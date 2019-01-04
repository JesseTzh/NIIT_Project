<?php
namespace app\insert_data\controller;

use app\insert_data\model\Employee;
use app\insert_data\model\Order;
use app\insert_data\model\Product;
use app\insert_data\model\Record;
use think\Controller;
use Faker;
use app\insert_data\model\Customer;
use think\Db;

define('NUM',100);

class Index extends Controller
{
    public function ct_generate()
    {
        $insert_ct_data = new Customer;
        $sql1 = 'max(cast(right(customer_num,5) as  UNSIGNED))';
        $sql = "select ".$sql1."  from customer;";
        $last = $insert_ct_data->query($sql);
        dump($last);
        if($last[0][$sql1] == null){
            $ct_num=1;
        }
        else{
            $ct_num=$last[0][$sql1]+1;
        }
//        echo $ct_num;
        for ($i=1;$i<=NUM;$i++){
            $zero=0;
            $num_len=strlen($ct_num);
            $ct_type="0" .mt_rand(1,2);
            for ($j=5-$num_len;$j>1;$j--){
                $zero .="0";
            }
            $ct_id="CT" .$ct_type .$zero .$ct_num;
            $id[$i] = $ct_id;
            $type[$i] = $ct_type;
            $no[$i] = $ct_num;
            $ct_num++;
        }
//        dump($id);
//        dump($type);
        $faker = Faker\Factory::create();
        for ($i=1;$i<=NUM;$i++){
            $name[$i] = $faker->name;
        }
//        dump($name);
        for ($i=1;$i<=NUM;$i++){
            $tele[$i] = $faker->tollFreePhoneNumber;
        }
//        dump($tele);
        for ($i=1;$i<=NUM;$i++){
            $address[$i] = $faker->streetAddress;
        }
//        dump($address);
        for ($i=1;$i<=NUM;$i++){
            $grade1 = mt_rand(0,1);
            if($grade1){
                $grade[$i] = "VIP客户";
            }
            else{
                $grade[$i] = "普通客户";
            }

        }
//        dump($grade);
        for ($j=1;$j<=NUM;$j++) {
            $res = Customer::create([
                'customer_num' => $id[$j],
                'customer_name' => $name[$j],
                'customer_contact' => $tele[$j],
                'customer_address' => $address[$j],
                'customer_grade' => $grade[$j],
            ]);
//            dump($res);
//            dump(Customer::getLastSql());
        }

    }
    //客户生成
    public function pd_generate(){
        $faker = Faker\Factory::create();
        $insert_ct_data = new Product();
        $sql1 = 'max(cast(right(product_num,5) as  UNSIGNED))';
        $sql = "select ".$sql1."  from product;";
        $last = $insert_ct_data->query($sql);
        if($last[0][$sql1] == null){
            $pd_num=1;
        }
        else{
            $pd_num=$last[0][$sql1]+1;
        }
        dump($pd_num);
        for ($i=1;$i<=NUM;$i++){
            $zero=0;
            $num_len=strlen($pd_num);
            $pd_year=$faker->year($max = 'now');
            for ($j=5-$num_len;$j>1;$j--){
                $zero .="0";
            }
            $pd_id="PD" .$pd_year .$zero .$pd_num;
            $id[$i] = $pd_id;
            $no[$i] = $pd_num;
            $pd_num++;
        }
//        dump($id);
        for ($i=1;$i<=NUM;$i++){
            $name[$i] = ucfirst($faker->word) ." Super Machine";
        }
//        dump($name);
        for ($i=1;$i<=NUM;$i++){
            $img[$i] = $faker->imageUrl($width = 640, $height = 480);
        }
//        dump($img);
        $type = array(
            "电视"=>array(
                "55寸",
                "65寸",
                "曲面电视",
                "超薄电视",
                "OLED电视",
                "4K超清电视",
                "电视配件",
            ),
            "空调"=>array(
                "一级能效空调",
                "变频空调",
                "1.5匹空调",
                "以旧换新",
                "壁挂式空调",
                "柜式空调",
                "中央空调",
            ),
            "洗衣机"=>array(
                "滚筒洗衣机",
                "洗烘一体机",
                "波轮洗衣机",
                "迷你洗衣机",
                "烘干机",
                "洗衣机配件",
            ),
            "冰箱"=>array(
                "多门",
                "对开门",
                "三门",
                "双门",
                "冷柜/冰吧",
                "酒柜",
                "冰箱配件",
            ),
            "厨卫大电"=>array(
                "油烟机",
                "燃气灶",
                "烟灶套装",
                "集成套装",
                "消毒柜",
                "洗碗机",
                "电热水器",
                "燃气热水器",
                "嵌入式厨电",
            ),
            "厨房小电"=>array(
                "破壁机",
                "电烤箱",
                "电饭煲",
                "电压力锅",
                "咖啡机",
                "豆浆机",
                "料理机",
                "电炖锅",
                "电饼铛",
                "多用途锅",
                "电水壶/热水瓶",
                "微波炉",
                "榨汁机/原汁机",
                "养生壶",
                "电磁炉",
                "面包机",
                "空气炸锅",
                "面条机",
                "电陶炉",
                "煮蛋器",
                "电烧烤炉",
            ),
            "生活电器"=>array(
                "取暖电器",
                "吸尘器/除螨仪",
                "空气净化器",
                "扫地机器人",
                "蒸汽拖把/拖地机",
                "干衣机",
                "电话机",
                "饮水机",
                "净水器",
                "除湿机",
                "挂烫机/熨斗",
                "加湿器",
                "电风扇",
                "冷风扇",
                "毛球修剪器",
                "生活电器配件",
            ),
            "个护健康"=>array(
                "剃须刀",
                "电动牙刷",
                "电吹风",
                "按摩器",
                "健康秤",
                "卷/直发器",
                "剃/脱毛器",
                "理发器",
                "足浴盆",
                "足疗机",
                "美容器",
                "洁面仪",
                "按摩椅",
            ),
            "家庭影院"=>array(
                "KTV音响",
                "家庭影院",
                "迷你音响",
                "DVD",
                "功放",
                "回音壁",
                "影音配件",
            ),
        );
        for ($i=1;$i<=NUM;$i++){
            $main_num = mt_rand(1,9);
            switch ($main_num){
                case 1:
                    $main_ty[$i] = "电视";
                    $se_num = mt_rand(0,6);
                    $se_ty[$i] = $type[$main_ty[$i]][$se_num];
                    break;
                case 2:
                    $main_ty[$i] = "空调";
                    $se_num = mt_rand(0,6);
                    $se_ty[$i] = $type[$main_ty[$i]][$se_num];
                    break;
                case 3:
                    $main_ty[$i] = "洗衣机";
                    $se_num = mt_rand(0,5);
                    $se_ty[$i] = $type[$main_ty[$i]][$se_num];
                    break;
                case 4:
                    $main_ty[$i] = "冰箱";
                    $se_num = mt_rand(0,5);
                    $se_ty[$i] = $type[$main_ty[$i]][$se_num];
                    break;
                case 5:
                    $main_ty[$i] = "厨卫大电";
                    $se_num = mt_rand(0,8);
                    $se_ty[$i] = $type[$main_ty[$i]][$se_num];
                    break;
                case 6:
                    $main_ty[$i] = "厨房小电";
                    $se_num = mt_rand(0,20);
                    $se_ty[$i] = $type[$main_ty[$i]][$se_num];
                    break;
                case 7:
                    $main_ty[$i] = "生活电器";
                    $se_num = mt_rand(0,15);
                    $se_ty[$i] = $type[$main_ty[$i]][$se_num];
                    break;
                case 8:
                    $main_ty[$i] = "个护健康";
                    $se_num = mt_rand(0,12);
                    $se_ty[$i] = $type[$main_ty[$i]][$se_num];
                    break;
                case 9:
                    $main_ty[$i] = "家庭影院";
                    $se_num = mt_rand(0,6);
                    $se_ty[$i] = $type[$main_ty[$i]][$se_num];
                    break;
            }
        }
//        dump($main_ty);
//        dump($se_ty);
        for ($i=1;$i<=NUM;$i++){
            $cost[$i] = mt_rand(50,200) ."99";
            $sale[$i] = $cost[$i]*1.2;
            $unit[$i] = "件";
            $detail[$i] = $faker->colorName;
        }
//        dump($cost);
//        dump($sale);
//        dump($unit);
//        dump($detail);
        for ($j=1;$j<=NUM;$j++) {
            $res = Product::create([
                'product_num' => $id[$j],
                'product_name' => $name[$j],
                'product_pic' => $img[$j],
                'product_main_type' => $main_ty[$j],
                'product_secondary_type' => $se_ty[$j],
                'product_cost' => $cost[$j],
                'product_sale' => $sale[$j],
                'product_unit' => $unit[$j],
                'product_detail' => $detail[$j],
            ]);
//            dump($res);
            dump(Record::getLastSql());
        }

    }
    //产品生成
    public function rd_generate(){
        $res = Employee::column('employee_num');
        $res_num = count($res);
        for ($i=1;$i<=NUM;$i++){
            $em_num = mt_rand(1,$res_num);
            $zero = 0;
            $num_len = strlen($em_num);
            for ($j = 5 - $num_len; $j > 1; $j--) {
                $zero .= "0";
            }
            $em_id="EM" .$zero .$em_num;
            $id[$i]=$em_id;
        }
//        dump($id);
        $faker = Faker\Factory::create();
        for ($i=1;$i<=NUM;$i++){
            $time[$i] = $faker->iso8601;
        }
//        dump($time);
        for ($i=1;$i<=NUM;$i++){
            $ip[$i] = $faker->ipv4;
        }
        for ($i=1;$i<=NUM;$i++){
            $agent[$i] = $faker->userAgent;
        }
        for ($i=1;$i<=NUM;$i++){
            $stat = mt_rand(0,1);{
                if($stat == 0){
                    $state[$i] = "false";
                }
                else{
                    $state[$i] = "success";
                }
            }
        }
//        dump($state);
        for ($j=1;$j<=NUM;$j++) {
            $res = Record::create([
                'login_employee_num' => $id[$j],
                'login_time' => $time[$j],
                'login_ip' => $ip[$j],
                'login_user_agent' => $agent[$j],
                'login_state' => $state[$j],
            ]);
//            dump($res);
            dump(Record::getLastSql());
        }

    }
    //登录记录生成(待优化)
    public function em_generate(){
        $insert_ct_data = new Customer;
        $sql1 = 'max(cast(right(employee_num,5) as  UNSIGNED))';
        $sql = "select ".$sql1."  from employee;";
        $last = $insert_ct_data->query($sql);
//        dump($last);
        $em_num=$last[0][$sql1]+1;
//        echo $em_num;
        for ($i=1;$i<=NUM;$i++) {
            $zero = 0;
            $num_len = strlen($em_num);
            for ($j = 5 - $num_len; $j > 1; $j--) {
                $zero .= "0";
            }
            $em_id="EM" .$zero .$em_num;
            $em_num++;
            $id[$i]=$em_id;
        }
//        dump($id);
        $faker = Faker\Factory::create();
        for ($i=1;$i<=NUM;$i++){
            $name[$i] = $faker->name;
        }
//        dump($name);
        for ($i=1;$i<=NUM;$i++){
            $pass[$i] = $faker->md5;
        }
        for ($i=1;$i<=NUM;$i++){
            $img[$i] = $faker->imageUrl($width = 640, $height = 480);
        }
        for ($i=1;$i<=NUM;$i++){
            $ch_num[$i] = mt_rand(1,3);
        }
        for ($i=1;$i<=NUM;$i++){
            $de_num[$i] = mt_rand(1,9);
        }
        for ($j=1;$j<=NUM;$j++) {
            $res = Employee::create([
                'employee_num' => $id[$j],
                'employee_name' => $name[$j],
                'employee_password' => $pass[$j],
                'employee_head_portrait' => $img[$j],
                'employee_character_num' => $ch_num[$j],
                'employee_department_num' => $de_num[$j],
            ]);
//            dump($res);
//            dump(Employee::getLastSql());
        }
    }
    //员工生成
    public function od_generate(){
        $insert_od_data = new Order;
        $sql1 = 'max(cast(right(order_id,5) as  UNSIGNED))';
        $sql = "select ".$sql1."  from `order`;";
        $last = $insert_od_data->query($sql);
//        dump($last);
        if($last[0][$sql1] == null){
            $od_num=1;
        }
        else{
            $od_num=$last[0][$sql1]+1;
        }
//        dump($od_num);
        for ($i=1;$i<=NUM;$i++) {
            $zero = 0;
            $num_len = strlen($od_num);
            for ($j = 5 - $num_len; $j > 1; $j--) {
                $zero .= "0";
            }
            $faker = Faker\Factory::create();
            $date_s = $faker->dateTimeThisYear;
            $date_n = $this->object_to_array($date_s);
            $date[$i] = $date_n['date'];
            //销售日期
            $od_id="OD" .substr($date[$i],0,4) .substr($date[$i],5,2) .$zero .$od_num;
            $od_num++;
            $id[$i]=$od_id;
            //订单ID
            $sql_em = "select employee_num from employee where employee_character_num=2 order by rand() limit 1;";
            $rand_em = $insert_od_data->query($sql_em);
            $em_id[$i] = $rand_em[0]["employee_num"];
            //生成雇员ID
            $de_num_sql = "select employee_department_num from employee where employee_num='".$em_id[$i]."';";
            $de_num_ob = $insert_od_data->query($de_num_sql);
            $de_num = $de_num_ob[0]["employee_department_num"];
            $de[$i] = 0;
            switch ($de_num){
                case 1:
                    $de[$i] = "电视";
                    break;
                case 2:
                    $de[$i] = "空调";
                    break;
                case 3:
                    $de[$i] = "洗衣机";
                    break;
                case 4:
                    $de[$i] = "冰箱";
                    break;
                case 5:
                    $de[$i] = "厨卫大电";
                    break;
                case 6:
                    $de[$i] = "厨房小电";
                    break;
                case 7:
                    $de[$i] = "生活电器";
                    break;
                case 8:
                    $de[$i] = "个护健康";
                    break;
                case 9:
                    $de[$i] = "家庭影院";
                    break;
            }
            //生成产品分类
            $sql_pd = "select product_num from product where product_main_type='".$de[$i]."' order by rand() limit 1;";
            $rand_pd = $insert_od_data->query($sql_pd);
            $pd_id[$i] = $rand_pd[0]["product_num"];
            //生成产品ID

            $sql_ct = "select customer_num from customer order by rand() limit 1;";
            $rand_ct = $insert_od_data->query($sql_ct);
            $ct_id[$i] = $rand_ct[0]["customer_num"];
            //生成客户ID
            $ch_num = mt_rand(1,6);
            switch ($ch_num){
                case 1:
                    $ch[$i] = "官方商城";
                    break;
                case 2:
                    $ch[$i] = "电商自营店";
                    break;
                case 3:
                    $ch[$i] = "电商加盟店";
                    break;
                case 4:
                    $ch[$i] = "自营实体店";
                    break;
                case 5:
                    $ch[$i] = "加盟实体店";
                    break;
                case 6:
                    $ch[$i] = "分销商";
                    break;
            }
            //销售渠道
            $num[$i] = mt_rand(1,10);
            //销售数量
            $sql_price = "select product_sale from product where product_num='".$pd_id[$i]."';";
            $price_res = $insert_od_data->query($sql_price);
            $price_sale[$i] = $price_res[0]["product_sale"];
            $rand_num = $this->randFloat();
            $price[$i] = (int)($price_sale[$i] * $rand_num);
            //销售单价
            $total[$i] = (int)$num[$i] * $price[$i];
            //订单总价
        }
        for ($j=1;$j<=NUM;$j++) {
            $res2 = Order::create([
                'order_id' => $id[$j],
                'order_product_id' => $pd_id[$j],
                'order_customer_id' => $ct_id[$j],
                'order_date' => $date[$j],
                'order_channel' => $ch[$j],
                'order_number' => $num[$j],
                'order_unit_price' => $price[$j],
                'order_empolyee_id' => $em_id[$j],
                'order_total_price' => $total[$j],
            ]);
        }
    }
    //订单生成
    public function af_generate(){

    }
    //售后服务单生成
    public function fe_generate(){

    }
    //售后反馈单生成
    public function randFloat($min = 0.8, $max = 1) {
        return $min + mt_rand() / mt_getrandmax() * ($max - $min);
    }
    //随机小数生成
    function object_to_array($obj) {
        $obj = (array)$obj;
        foreach ($obj as $k => $v) {
            if (gettype($v) == 'resource') {
                return;
            }
            if (gettype($v) == 'object' || gettype($v) == 'array') {
                $obj[$k] = (array)object_to_array($v);
            }
        }

        return $obj;
    }
    //对象 转 数组
}