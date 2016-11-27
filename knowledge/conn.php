<?php
$mysqli = new mysqli("127.0.0.1", "root", "root", "knowledge");
if ($mysqli->connect_error) {
    die('Could not connect: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}
$sql = "set names utf8";
$mysqli->query($sql);

class Knowledge
{
    public $id;
    public $keyword;
    public $content;
    public $url;
    public $creator;
    public $createTime;
}

?>