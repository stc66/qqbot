<?php
// 数据库url
define("DB_URL", "127.0.0.1");
// 数据库用户名
define("DB_USER", "root");
// 数据库密码
define("DB_PASSWORD", "root");
// 数据库
define("DB_NAME", "knowledge");
// 目标QQ群
define("QQ_QUN_NUM", "308578890");
// 目前QQ群发消息URL
define("QQ_URL", "http://192.168.31.225:5000/openqq/send_group_message?gnumber=" . QQ_QUN_NUM . "&content=");
// 管理员QQ号
define("ADMIN_QQ_NUM", "184675420");

/**
 * webqq消息上报服务端
 */

set_time_limit(0);

// 接收webqq上报的消息内容
$data = file_get_contents('php://input');
$jsondata = json_decode($data);

// $myfile = fopen("log.txt", "a") or die("Unable to open file!");
// fwrite($myfile, $data);
// fclose($myfile);

/**
 * 封装知识库
 * Class Knowledge
 */
class Knowledge
{
    public $id;
    public $keyword;
    public $content;
    public $url;
    public $creator;
    public $createTime;
}

/**
 * 发送http请求
 * @param $url
 * @return mixed
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

/**
 * 使用webqq发送消息
 * @param $msg
 */
function sendmsg($msg)
{
    $msg = urlencode($msg);
    // PHP文本换行处理
    $msg = str_replace("newline", "%E2%80%A8", $msg);
    $url = QQ_URL . $msg;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_exec($ch);
    curl_close($ch);
}

/**
 * 根据关键字查询知识库
 * @param $keyword
 */
function search($keyword)
{
    $mysqli = new mysqli(DB_URL, DB_USER, DB_PASSWORD, DB_NAME);
    if ($mysqli->connect_error) {
        die('Could not connect: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
    }
    $sql = "set names utf8";
    $mysqli->query($sql);
    $results = $mysqli->query(" SELECT id,keyword,content,url,creator,createTime FROM content WHERE  keyword like '%" . $keyword . "%' ");
    $arr = array();
    while ($row = $results->fetch_object()) {
        $knowledge = new Knowledge();
        $knowledge->id = $row->id;
        $knowledge->keyword = $row->keyword;
        $knowledge->content = $row->content;
        $knowledge->url = $row->url;
        $knowledge->creator = $row->creator;
        $knowledge->createTime = $row->createTime;
        $arr[] = $knowledge;
    }
    foreach ($arr as $knowledge) {
        $msg = "$knowledge->content newline『" . $knowledge->creator . "』于" . $knowledge->createTime . "收录了『" . $knowledge->keyword . "』知识库";
        sendmsg($msg);
        sleep(1);
    }
    $mysqli->close();
}


/**
 * 添加知识库
 * @param $content 内容
 * @param $creator 创建者
 */
function add($content, $creator)
{
    if (!empty($content)) {
        $rule = '/^add\s*\"(.*)\"\s+(.*)/';
        if (preg_match($rule, $content, $matches)) {
            $keyword = $matches[1];
            $content = $matches[2];
            $knowledge = new Knowledge();
            $knowledge->keyword = $keyword;
            $knowledge->content = $content;
            $knowledge->url = "";
            $knowledge->creator = $creator;
            $knowledge->createTime = date("Y-m-d H:i:s");
            addKnowledge($knowledge);
        } else {
            echo "没有匹配到";
        }
    }
}

/**
 * 关键字匹配删除知识库
 * @param $content
 */
function del($content)
{
    if (!empty($content)) {
        $rule = '/^del\s*(.*)/';
        if (preg_match($rule, $content, $matches)) {
            $keyword = $matches[1];
            delKnowledge($keyword);
        } else {
            echo "没有匹配到";
        }
    }
}


/**
 * 添加知识库
 * @param $knowledge
 */
function addKnowledge($knowledge)
{
    $mysqli = new mysqli(DB_URL, DB_USER, DB_PASSWORD, DB_NAME);
    if ($mysqli->connect_error) {
        die('Could not connect: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
    }
    $sql = "set names utf8";
    $mysqli->query($sql);
    $mysqli->query("INSERT INTO content (keyword,content,url,creator,createTime) VALUES('" . $knowledge->keyword . "','" . $knowledge->content . "','" . $knowledge->url . "','" . $knowledge->creator . "','" . $knowledge->createTime . "')");
    $msg = "知识库『" . $knowledge->keyword . "』添加成功！";
    sendmsg($msg);
    $mysqli->close();
}

/**
 * 从知识库中删除内容
 * @param $keyword
 */
function delKnowledge($keyword)
{
    $mysqli = new mysqli(DB_URL, DB_USER, DB_PASSWORD, DB_NAME);
    if ($mysqli->connect_error) {
        die('Could not connect: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
    }
    $sql = "set names utf8";
    $mysqli->query($sql);
    $mysqli->query("DELETE FROM content WHERE keyword like '%" . $keyword . "%'");
    $msg = "知识库『" . $keyword . "』删除成功，共删除" . $mysqli->affected_rows . "条记录！";
    sendmsg($msg);
    $mysqli->close();
}


/**
 * 图灵机器人
 * @param $content
 * @return mixed
 */
function chat($content)
{
    $url = 'http://www.tuling123.com/openapi/api?key=873ba8257f7835dfc537090fa4120d14&info=' . $content;
    $content = dopost($url);
    $json = json_decode($content, true);
    $text = $json['text'];
    return sendmsg($text);
}

/**
 * 快递查询
 * @param $number 9890240094396、402222690337
 * @return mixed
 */
function kuaidi($content)
{
    if (!empty($content)) {
        $rule = '/^快递\s*(.*)/';
        if (preg_match($rule, $content, $matches)) {
            $keyword = $matches[1];
            $url = "http://www.kuaidi100.com/autonumber/autoComNum?text=" . $keyword;
            $content = dopost($url);
            $json = json_decode($content);
            $comCode = $json->auto[0]->comCode;
            $url = 'http://www.kuaidi100.com/query?type=' . $comCode . '&postid=' . $keyword;
            $content = dopost($url);
            $json = json_decode($content);
            $data = $json->data;
            $str = "单号『" . $keyword . "』快递详情如下：newline";
            for ($i = 0; $i < count($data); $i++) {
                $str .= $data[$i]->time . $data[$i]->context . 'newline';
            }
            $str = rtrim($str, "newline");
            return sendmsg($str);
        } else {
            echo "没有匹配到";
        }
    }
}

// 消息类型
$type = $jsondata->{'type'};
// 消息内容
$content = $jsondata->{'content'};
// 发送者
$sender = $jsondata->{'sender'};
// 发送者QQ
$sender_qq = $jsondata->{'sender_qq'};
if ($type = "group_message") {
    $gnumber = $jsondata->{'gnumber'};// 群号
    $group = $jsondata->{'group'};// 群名称
    switch ($gnumber) {
        // 只处理目标QQ群的消息
        case QQ_QUN_NUM:

            // 快递
            kuaidi($content);

            // 图灵机器人
            $rule = '/^@缘来似你\s*(.*)/';
            if (preg_match($rule, $content, $matches)) {
                chat($matches[1]);
                print_r($matches);
            }

            // 查询知识库
            search($content);

            // 添加知识库
            add($content, $sender);

            // 仅仅管理员可以删除
            if ($sender_qq == ADMIN_QQ_NUM) {
                // 删除知识库
                del($content);
            }

            break;
    }
}
?>