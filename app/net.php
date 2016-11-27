<?php

/**
 * PHP请求公共方法
 * @param $url 请求url
 * @return mixed 返回请求的内容
 */
function dopost($url)
{
    // 初始化
    $ch = curl_init();
    // 设置抓取的url
    curl_setopt($ch, CURLOPT_URL, $url);
    // 设置头文件的信息作为数据流输出
    curl_setopt($ch, CURLOPT_HEADER, 0);
    // 设置获取的信息以文件流的形式返回，而不是直接输出。
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    // 执行命令
    $content = curl_exec($ch);
    // 关闭URL请求
    curl_close($ch);
    return $content;
}

?>