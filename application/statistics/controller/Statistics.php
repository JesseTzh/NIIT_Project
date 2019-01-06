<?php
/**
 * Created by PhpStorm.
 * User: 86744
 * Date: 2019/1/4
 * Time: 13:30
 */

namespace app\statistics\controller;
use think\Controller;
use think\Db;
use think\session;
use app\statistics\model\Statistic;


class Statistics extends Controller
{



    static public function department_monthly_profit()
    {
        $sql_se = \session('employee_department_num');
        $sql_new = new Statistic;
        $sql = "SELECT sum(tmp.order_total_price-tmp.order_number*a.product_cost) as 利润
        FROM product a 
        RIGHT JOIN (
        SELECT order_total_price,order_number,order_product_id,order_date,order_unit_price
        FROM `order` 
        where order_date BETWEEN '2018-11-30' AND '2018-12-31' AND
        order_department= ".$sql_se.") tmp 
        ON a.product_num = tmp.order_product_id";
        $sql_res = $sql_new->query($sql);
        //dump($sql_res);
        //会输出一个二维数组，注意是0开始
        $res = $sql_res[0]["利润"];
        //查询特定员工本月利润,员工编码即为$sql_se
        return $res;
    }//本部门月利润

    static public function department_quarter_profit()
    {
        $sql_se = \session('employee_department_num');
        $sql_new = new Statistic;
        $sql = "SELECT sum(tmp.order_total_price-tmp.order_number*a.product_cost) as 利润
        FROM product a 
        RIGHT JOIN (
        SELECT order_total_price,order_number,order_product_id,order_date,order_unit_price
        FROM `order` 
        where order_date BETWEEN '2018-9-30' AND '2018-12-31' AND
        order_department = ".$sql_se.") tmp
        ON a.product_num = tmp.order_product_id";
        $sql_res = $sql_new->query($sql);
        //dump($sql_res);
        //会输出一个二维数组，注意是0开始
        $res = $sql_res[0]["利润"];
        return $res;
        //如果是只返回一个数字的话
    }//本部门季度利润

    static public function department_saleroom()
    {
        $sql_se = \session('employee_department_num');
        $sql_new = new Statistic;
        $sql = "select SUM(order_total_price) as saleroom FROM `order` 
        where order_date BETWEEN '2017-12-31' AND '2018-12-31' AND
        order_department = ".$sql_se;
        $sql_res = $sql_new->query($sql);
        //dump($sql_res);
        //会输出一个二维数组，注意是0开始
        $res = $sql_res[0]["saleroom"];
        //查询特定员工本月利润,员工编码即为$sql_se
        //echo json . encode($res);
        //如果前端是Echart的话
        // return "一个数组";
        //如果前端是表格的话
        return $res;
        //如果是只返回一个数字的话
    }//本部门一整年销售额

    static public function department_sale_chart()
    {
        $sql_se = \session('employee_department_num');
        $sql_new = new Statistic;
        $sql = "SELECT 
        SUM(order_total_price) as total_price,
        CONCAT(YEAR(order_date),'-',DATE_FORMAT(order_date,'%m')) AS 月份
        FROM `order`
        where order_date BETWEEN '2018-01-01' AND '2018-12-31' AND
        order_department =".$sql_se."
        GROUP BY 月份";
        $sql_res = $sql_new->query($sql);
        //dump($sql_res);
        //会输出一个二维数组，注意是0开始
        for ($i=0;$i<=11;$i++) {
            $res[$i] = $sql_res[$i]["total_price"];
        }
        //dump($res);
        echo json_encode($res);
        //如果前端是Echart的话
        // return "一个数组";
        //如果前端是表格的话
        //return $res;
        //如果是只返回一个数字的话
    }//按月分的销售额表
    static public function department_goal()
    {
        $sql_se = \session('employee_department_num');
        $sql_new = new Statistic;
        $sql = "SELECT sum(order_total_price) as total,floor(sum(order_total_price)*1.2) as goal
        FROM `order` 
        where order_date BETWEEN '2018-11-30' AND '2018-12-31' 
        AND order_department = ".$sql_se."
        UNION ALL
        SELECT sum(order_total_price) as total,floor(sum(order_total_price)*1.8) as goal
        FROM `order` 
        where order_date BETWEEN '2018-9-30' AND '2018-12-31' 
        AND order_department = ".$sql_se."
        UNION ALL
        SELECT sum(order_total_price) as total,floor(sum(order_total_price)*1.5) AS goal
        FROM `order` 
        where order_date BETWEEN '2018-01-01' AND '2018-12-31' 
        AND order_department = ".$sql_se  ;
        $sql_res = $sql_new->query($sql);
        //dump($sql_res);
        //会输出一个二维数组，注意是0开始
        for ($i=0;$i<=2;$i++) {
            $y=$sql_res[$i]["total"];
            $res[$i][$y] = $sql_res[$i]["goal"];
        }
        //dump($res);
        return json_encode($res);

    }//月季年目标销售额
    static public function department_star_employee()
    {
        $sql_se = \session('employee_department_num');
        $sql_new = new Statistic;
        $sql = "SELECT (a.employee_name)as 明星 from employee a
        RIGHT JOIN
        (SELECT (order_empolyee_id) AS id,sum(order_total_price) AS total
        from `order`
        where order_date BETWEEN '2018-11-30' AND '2018-12-31'
        AND
        order_department = " . $sql_se . "
        GROUP BY order_empolyee_id
        ) tmp 
        ON a.employee_num=tmp.id
        ORDER BY total DESC
        LIMIT 1";
        $sql_res = $sql_new->query($sql);
        //dump($sql_res);
        //会输出一个二维数组，注意是0开始
        $res = $sql_res[0]["明星"];
        return $res;
        //如果是只返回一个数字的话
    }//本部门明星员工
    static public function department_employee_top5()
    {
        $sql_se = \session('employee_department_num');
        $sql_new = new Statistic;
        $sql = "SELECT a.employee_num,(a.employee_name)as 明星 ,tmp.total from employee a
        RIGHT JOIN
        (SELECT (order_empolyee_id) AS id,sum(order_total_price) AS total
        from `order`
        where order_date BETWEEN '2018-11-30' AND '2018-12-31'
        AND
        order_department = ".$sql_se."
        GROUP BY order_empolyee_id
        ) tmp 
        ON a.employee_num=tmp.id
        ORDER BY total DESC
        LIMIT 5";
        $sql_res = $sql_new->query($sql);
        //dump($sql_res);
        //会输出一个二维数组，注意是0开始
        return json($sql_res);
        //如果是只返回一个数字的话
    }//本部门明星员工
    //
    //
    //
    //部门经理和公司的分界线
    static public function company_product_top5()
    {
        $sql_se = \session('employee_department_num');
        $sql_new = new Statistic;
        $sql = "SELECT (a.product_name)产品名称,tmp.总销售额 from product a
        RIGHT JOIN
       (SELECT (order_product_id) AS id,sum(order_total_price) AS 总销售额
        from `order` 
        GROUP BY order_product_id
        ) tmp 
        ON a.product_num=tmp.id
        ORDER BY 总销售额 DESC
        LIMIT 5";
        $sql_res = $sql_new->query($sql);
        //dump($sql_res);
        //会输出一个二维数组，注意是0开始
        return json($sql_res);
        //如果是只返回一个数字的话
    }//产品销量前五
    static public function company_product_last5()
    {
        $sql_se = \session('employee_department_num');
        $sql_new = new Statistic;
        $sql = "SELECT (a.product_name)产品名称,tmp.总销售额 from product a
        RIGHT JOIN
       (SELECT (order_product_id) AS id,sum(order_total_price) AS 总销售额
        from `order` 
        GROUP BY order_product_id
        ) tmp 
        ON a.product_num=tmp.id
        ORDER BY 总销售额 DESC
        LIMIT 5";
        $sql_res = $sql_new->query($sql);
        //dump($sql_res);
        //会输出一个二维数组，注意是0开始
        return json($sql_res);
        //如果是只返回一个数字的话
    }//产品销量后5
    static public function comppany_chart()
    {
        $sql_se = \session('employee_department_num');
        $sql_new = new Statistic;
        $sql = "SELECT order_channel,SUM(order_total_price)AS 销售额
        from `order`
        GROUP BY order_channel"  ;
        $sql_res = $sql_new->query($sql);
        //dump($sql_res);
        //会输出一个二维数组，注意是0开始
        for ($i=0;$i<=5;$i++) {
            $y=$sql_res[$i]["order_channel"];
            $res[$i][$y] = $sql_res[$i]["销售额"];
        }
        //dump($res);
        return json($res);

    }//不同销售渠道订单量图标
    static public function feedback()
    {
        $sql_se = \session('employee_department_num');
        $sql_new = new Statistic;
        $sql = "select (feedback_processing_type) as 形式,COUNT(*) as total 
        FROM feedback
        GROUP BY feedback_processing_type"  ;
        $sql_res = $sql_new->query($sql);
        //dump($sql_res);
        //会输出一个二维数组，注意是0开始
        for ($i=0;$i<=3;$i++) {
            $y=$sql_res[$i]["形式"];
            $res[$i][$y] = $sql_res[$i]["total"];
        }
        //dump($res);
        return json($res);

    }//饼图
    static public function company_star_product()
    {
        $sql_se = \session('employee_department_num');
        $sql_new = new Statistic;
        $sql = "SELECT (a.product_name) as 产品名称
        FROM product a
        LEFT JOIN
        (SELECT order_product_id,SUM(order_total_price) AS total
         FROM `order`
         GROUP BY order_product_id) tmp
         on a.product_num = tmp.order_product_id
         ORDER BY total DESC
         LIMIT 1";
        $sql_res = $sql_new->query($sql);
        //dump($sql_res);
        //会输出一个二维数组，注意是0开始
        $res = $sql_res[0]["产品名称"];
        return $res;
        //如果是只返回一个数字的话
    }//本公司明星产品
    static public function defective_product_top()
    {
        $sql_se = \session('employee_department_num');
        $sql_new = new Statistic;
        $sql = "SELECT (a.product_name) as 产品名称,(tmp.total)as 问题订单数
        FROM product a
        LEFT JOIN
        (SELECT c.order_product_id,COUNT(*) as total
        from after_sale b
        LEFT JOIN
       (SELECT order_product_id,order_id 
        from `order` ) c
        on b.after_sale_order_id =c.order_id 
        GROUP BY c.order_product_id ) tmp
        on a.product_num=tmp.order_product_id
        ORDER BY total DESC
        LIMIT 5"  ;
        $sql_res = $sql_new->query($sql);
        //dump($res);
        return json($sql_res);

    }//问题产品最多5个
    static public function defective_product_last()
    {
        $sql_se = \session('employee_department_num');
        $sql_new = new Statistic;
        $sql = "SELECT (a.product_name) as 产品名称,(tmp.total)as 问题订单数
        FROM product a
        LEFT JOIN
        (SELECT c.order_product_id,COUNT(*) as total
        from after_sale b
        LEFT JOIN
       (SELECT order_product_id,order_id 
        from `order` ) c
        on b.after_sale_order_id =c.order_id 
        GROUP BY c.order_product_id ) tmp
        on a.product_num=tmp.order_product_id
        ORDER BY total asc
        LIMIT 5"  ;
        $sql_res = $sql_new->query($sql);
        //dump($res);
        return json($sql_res);

    }//问题产品最少5个
}
