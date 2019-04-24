<?php
//消除错误提示
error_reporting(E_ALL ^ E_DEPRECATED);
header("content-type:application/json");
//引入配置文件
require_once("config.php");

//获取订单号
$payjs_order_id = $_GET["payjs_order_id"];

if(empty($payjs_order_id)){
	echo "{\"result\":\"0\",\"payjs_order_id\":\"empty\"}";
}else{
//查询数据
	$conn = mysql_connect($localhost,$dbuser,$dbpwd) or die("连接数据库失败");
	mysql_select_db($dbname, $conn);
	mysql_query("set names 'UTF-8'");
	$result = mysql_query("SELECT * FROM $tbname WHERE payjs_order_id = $payjs_order_id");
	$exits = mysql_num_rows($result);
	if($exits){
    	//如订单号相同，则返回
    	echo "{\"result\":\"1\",\"payjs_order_id\":\"$payjs_order_id\"}";
    }else{
    	echo "{\"result\":\"0\",\"payjs_order_id\":\"$payjs_order_id\"}";
    }

    //关闭数据库链接
	mysql_close($conn);
}
?>