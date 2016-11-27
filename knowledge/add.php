<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>
        知识库管理系统
    </title>
    <link href="http://cdn.bootcss.com/bootstrap/3.3.0/css/bootstrap.min.css"
          rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js">
    </script>
    <script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js">
    </script>
    <![endif]-->
    <style type="text/css">
        .table th, .table td {
            text-align: center;
            vertical-align: middle !important;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-fixed-top navbar-inverse" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="index.php">
                知识库
            </a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
        </div>
        <!-- /.nav-collapse -->
    </div>
    <!-- /.container -->
</nav>
<!-- /.navbar -->
<div class="container" style="margin-top: 60px;">
    <form class="form-horizontal" role="form" method="post" action="add.php">
        <div class="form-group">
            <label for="keyword" class="col-sm-2 control-label">词条</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="keyword" placeholder="词条" name="keyword"/>
            </div>
        </div>
        <div class="form-group">
            <label for="content" class="col-sm-2 control-label">内容</label>
            <div class="col-sm-10">
                <!-- 加载编辑器的容器 -->
                <script id="container" name="content" type="text/plain"></script>
            </div>
        </div>
        <div class="form-group">
            <label for="url" class="col-sm-2 control-label">url</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="url" placeholder="url" name="url"/>
            </div>
        </div>
        <div class="form-group">
            <label for="creator" class="col-sm-2 control-label">收录人</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="creator" placeholder="收录人" name="creator"/>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-default">保存</button>
                <button type="reset" class="btn btn-default">取消</button>
            </div>
        </div>
    </form>
    <?php
    include("conn.php");
    $keyword = isset($_POST['keyword']) ? $_POST['keyword'] : '';
    $content = isset($_POST['content']) ? $_POST['content'] : '';
    $url = isset($_POST['url']) ? $_POST['url'] : '';
    $creator = isset($_POST['creator']) ? $_POST['creator'] : '';
    $createTime = date("Y-m-d H:i:s");
    if ($keyword != "" || $content != "" || $creator != "") {
        $mysqli->query("INSERT INTO content (keyword,content,url,creator,createTime) 
                        VALUES('" . $keyword . "','" . $content . "','" . $url . "','" . $creator . "','" . $createTime . "')");
        $mysqli->close();
        echo "<script>window.location =\"index.php\";</script>";
    }
    ?>
    <footer>
        <p>
            &copy; Company 2016
        </p>
    </footer>
</div>
<!-- 配置文件 -->
<script type="text/javascript" src="ueditor/ueditor.config.js"></script>
<!-- 编辑器源码文件 -->
<script type="text/javascript" src="ueditor/ueditor.all.js"></script>
<!-- 实例化编辑器 -->
<script type="text/javascript">
    var ue = UE.getEditor('container');
</script>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="http://cdn.bootcss.com/jquery/1.11.1/jquery.min.js">
</script>
<!-- Include all compiled plugins (below), or include individual files
as needed -->
<script src="http://cdn.bootcss.com/bootstrap/3.3.0/js/bootstrap.min.js">
</script>
</body>

</html>