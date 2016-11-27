<?php
/**
 * 图灵聊天机器人
 */
include './net.php';

/** 图灵聊天机器人
 * @param $content 输入的文字内容
 * @return mixed 图灵机器人返回的内容
 */
function chat($content)
{
    $url = 'http://www.tuling123.com/openapi/api?key=873ba8257f7835dfc537090fa4120d14&info=' . $content;
    $content = dopost($url);
    $json = json_decode($content, true);
    $text = $json['text'];
    return $text;
}

// 获取get请求参数为content的内容
$content = $_GET['content'];
if (!empty($content)) {
    echo chat($content);
}
?>