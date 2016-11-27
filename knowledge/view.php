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
        .table th {
            text-align: right;
            vertical-align: middle !important;
            width: 12%;
        }

        .table td {
            text-align: left;
            vertical-align: middle !important;
            width: 88%;
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
    <?php
    include("conn.php");
    $results = $mysqli->query(" SELECT id,keyword,content,url,creator,createTime FROM content WHERE  id = '" . $_GET['id'] . "'");
    $row = $results->fetch_object();
    ?>
    <table class="table table-striped table-bordered table-hover" style="margin-top: 10px;">
        <tr>
            <th>
                编号
            </th>
            <td><?php echo $row->id ?></td>
        </tr>
        <tr>
            <th>
                词条
            </th>
            <td><?php echo $row->keyword ?></td>
        </tr>
        <tr>
            <th>
                内容
            </th>
            <td>
                <!-- 加载编辑器的容器 -->
                <script id="container" name="content" type="text/plain"><?php echo $row->content ?></script>
            </td>
        </tr>
        <tr>
            <th>
                url
            </th>
            <td><?php echo $row->url ?></td>
        </tr>
        <tr>
            <th>
                创建者
            </th>
            <td><?php echo $row->creator ?></td>
        </tr>
        <tr>
            <th>
                创建时间
            </th>
            <td><?php echo $row->createTime ?></td>
        </tr>
    </table>
    <?php $mysqli->close(); ?>
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