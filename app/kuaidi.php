<?php
/**
 * 快递查询
 */
include './net.php';

/**
 * 根据快递单号查询快递信息
 * @param $number 9890240094396/402222690337
 * @return string 返回该快递单号的快递详情
 */
function kuaidi($number)
{
    $url = "http://www.kuaidi100.com/autonumber/autoComNum?text=" . $number;
    $content = dopost($url);
    $json = json_decode($content);
    $comCode = $json->auto[0]->comCode;
    $url = 'http://www.kuaidi100.com/query?type=' . $comCode . '&postid=' . $number;
    $content = dopost($url);
    $json = json_decode($content);
    $data = $json->data;
    $str = "单号【" . $number . "】快递详情如下：</br>";
    for ($i = 0; $i < count($data); $i++) {
        $str .= $data[$i]->time . $data[$i]->context . '</br>';
    }
    $str = rtrim($str, "</br>");
    return $str;
}

// 获取get请求参数为number的内容
$number = $_GET['number'];
if (!empty($number)) {
    echo kuaidi($number);
}
?>