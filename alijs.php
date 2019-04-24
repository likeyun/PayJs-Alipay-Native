<?php
// 此页面用于创建订单
// TANKING
// LIKEYUNBA.COM
// 2018-12-26

header('Content-type: application/json');
//引入配置文件
require_once("config.php");

// 构造订单参数
$data = [
    'mchid'        => $mchid,
    'body'         => 'PAYJS支付宝订单测试',
    'type'         => 'alipay',
    'total_fee'    => 1,
    'notify_url'   => "http://www.liketube.cn/payjs/notify.php",
    'out_trade_no' => 'payjs_jspay_demo_' . time(),
];

// 添加数据签名
$data['sign'] = sign($data, $key);

//发送请求
$url = 'https://payjs.cn/api/native?' . http_build_query($data);
function post($data, $url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        $rst = curl_exec($ch);
        curl_close($ch);
        return $rst;
}

//发送
$result = post($data, $url);
//返回接口的数据
echo $result;

// 获取签名
function sign($data, $key)
{
    array_filter($data);
    ksort($data);
    return strtoupper(md5(urldecode(http_build_query($data) . '&key=' . $key)));
}
?>