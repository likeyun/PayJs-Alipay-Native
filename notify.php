<?php
error_reporting(E_ALL ^ E_DEPRECATED);
//引入配置文件
require_once("config.php");

//获取POST过来的数据
$return_code = $_POST["return_code"];
$total_fee = $_POST["total_fee"];
$out_trade_no = $_POST["out_trade_no"];
$payjs_order_id = $_POST["payjs_order_id"];
$time_end = $_POST["time_end"];
$openid = $_POST["openid"];
$transaction_id = $_POST["transaction_id"];
$sign = $_POST["sign"];

$data = [
    'mchid'           => $mchid,
    'return_code'     => $return_code,
    'payjs_order_id'  => $payjs_order_id,
    'total_fee'       => $total_fee,
    'time_end'        => $time_end,
    'out_trade_no'    => $out_trade_no,
    'openid'          => $openid,
    'transaction_id'  => $transaction_id,
    'sign'            => $sign
];

if($return_code == 1){
    // 1.验签逻辑
	function sign($data, $key)
	{
	    array_filter($data);
	    ksort($data);
	    return strtoupper(md5(urldecode(http_build_query($data) . '&key=' . $key)));
	}

	//连接数据库
	$conn = mysql_connect($localhost,$dbuser,$dbpwd) or die("连接数据库失败");
	mysql_select_db($dbname, $conn);
	mysql_query("set names 'UTF-8'");

    // 2.验重逻辑
    $yanchong = mysql_query("SELECT * FROM $tbname WHERE payjs_order_id = '$payjs_order_id'");
    $yanchongs = mysql_num_rows($yanchong);
    if($yanchongs){
    	//如果接收到重复的通知，则不插入数据库
    }else{

	//插入数据库
	mysql_query("INSERT INTO $tbname (payjs_order_id,time_end,total_fee,openid) VALUES ('$payjs_order_id','$time_end','$total_fee','$openid')");
	mysql_close($conn);
    }
    
    // 4.返回 success
    echo 'success';
}
?>