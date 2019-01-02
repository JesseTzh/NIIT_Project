<?php
namespace app\insert_data\controller;

use think\Controller;
use Faker;
use app\insert_data\model\Customer;
use think\Db;

define('NUM',10);

class Index extends Controller
{
    public function ct_generate()
    {
        $insert_ct_data = new Customer;
        $sql1 = 'max(cast(right(customer_id,5) as  UNSIGNED))';
        $sql = "select ".$sql1."  from customer;";
        $last = $insert_ct_data->query($sql);
//        dump($last);
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
            $grade[$i] = mt_rand(0,1);
        }
//        dump($grade);
        for ($j=1;$j<=NUM;$j++) {
            $res = Customer::create([
                'customer_id' => $id[$j],
                'customer_name' => $name[$j],
                'customer_contact' => $tele[$j],
                'customer_address' => $address[$j],
                'customer_grade' => $grade[$j],
            ]);
            dump($res);
//            dump(Customer::getLastSql());
        }

    }
    public function pd_generate(){
        $faker = Faker\Factory::create();
        $pd_num = 1;
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
            $name[$i] = ucfirst($faker->word);
        }
//        dump($name);
        for ($i=1;$i<=NUM;$i++){
            $img[$i] = $faker->imageUrl($width = 640, $height = 480);
        }
//        dump($img);

    }
}