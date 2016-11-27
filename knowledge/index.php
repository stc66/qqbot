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

    <form class="form-inline" role="form" action="index.php" method="POST">
        <div class="form-group">
            <label class="control-label" for="keyword">关键词</label>
            <input type="text" class="form-control" id="keyword" name="keyword" placeholder="请输入要查询的关键词">
        </div>
        <button type="submit" class="btn btn-default">查询</button>
    </form>
    <?php
    include("conn.php");
    $keyword = isset($_POST['keyword']) ? $_POST['keyword'] : '';
    if ($keyword == "") {
        $results = $mysqli->query(" SELECT id,keyword,content,url,creator,createTime FROM content ");
    } else {
        $results = $mysqli->query(" SELECT id,keyword,content,url,creator,createTime FROM content WHERE  keyword like '%" . $keyword . "%'");
    }
    ?>
    <table class="table table-striped table-bordered table-hover" style="margin-top: 10px;">
        <tr>
            <th>
                编号
            </th>
            <th>
                词条
            </th>
            <th>
                url
            </th>
            <th>
                创建者
            </th>
            <th>
                创建时间
            </th>
            <th>
                操作
            </th>
        </tr>
        <?php while ($row = $results->fetch_object()) { ?>
            <tr>
                <td>
                    <a href="view.php?id=<?php echo $row->id ?>"><?php echo $row->id ?></a>
                </td>
                <td>
                    <a href="view.php?id=<?php echo $row->id ?>"><?php echo $row->keyword ?></a>
                </td>
                <td>
                    <?php echo $row->url ?>
                </td>
                <td>
                    <?php echo $row->creator ?>
                </td>
                <td>
                    <?php echo $row->createTime ?>
                </td>
                <td>
                    <a href="del.php?id=<?php echo $row->id ?>">删除</a>
                </td>
            </tr>
        <?php } ?>
    </table>
    <?php $mysqli->close(); ?>
    <a href="add.php" class="btn btn-primary" role="button">添加</a>
    <hr>
    <footer>
        <p>
            &copy; Company 2016
        </p>
    </footer>
</div>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="http://cdn.bootcss.com/jquery/1.11.1/jquery.min.js">
</script>
<!-- Include all compiled plugins (below), or include individual files
as needed -->
<script src="http://cdn.bootcss.com/bootstrap/3.3.0/js/bootstrap.min.js">
</script>
</body>
</html>