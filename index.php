<?php
require("./LinkMysql.php");
// 创建连接对象
$conn = connentMysql();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>首页</title>
    <link rel="stylesheet" href="./css/bootstrap.min.css">
</head>

<body>
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">学生管理</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <form class="navbar-form navbar-left" action="./index.php">
        <select name="searchType" class="btn btn-default dropdown-toggle">
            <option value="0">模糊搜索</option>
            <option value="1">学号</option>
            <option value="2">姓名</option>
            <option value="3">性别</option>
            <option value="4">出生日期</option>
            <option value="5">分数</option>
        </select>
        <div class="form-group">
          <input type="text" class="form-control" name="search" placeholder="Search">
        </div>
        <button type="submit" class="btn btn-default">搜索</button>
      </form>
      <ul class="nav navbar-nav">
        <li><a href="./edit.php" class="btn btn-default navbar-btn" style="padding: 6px 12px;">添加</a></li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
    <table id="tlist" class="table table-striped" style="width: 800px;margin: 0 auto;border: 1px solid #c0c0c0;border-radius: 10px;">
        <thead>
            <th>学号</th>
            <th>姓名</th>
            <th>性别</th>
            <th>出生日期</th>
            <th>语文</th>
            <th>数学</th>
            <th>英语</th> 
            <th>操作</th>
        </thead>
        <tbody id="content">
            
        </tbody>
    </table>
<nav aria-label="Page navigation" style="max-width: 800px;margin: 0 auto;">
  <ul class="pagination"></ul>
</nav>

    <script>
        var tlist = document.getElementById("tlist"),
            tcontent = document.getElementById("content");
        var objs = [
            <?php
            $isCheckSec = false;
            $limit = 0;
            $limit = (empty($_GET["limit"])) ? 1 : $_GET["limit"];
            $sql = "select * from students limit ". ($limit-1)*20 . ",20";
        if(!empty($_GET['search'])){
                $search = $_GET['search'];
                $searchType = $_GET['searchType'];
                $stuSex = -1;
                
                if($search=='男'){
                    $stuSex = 1;
                }else if($search=='女') {
                    $stuSex = 0;
                }
                switch ($searchType) {
                    case '0':
                        $sql = "select * from students where stuId like '%$search%' or stuName like '%$search%' or stuBrith like '%$search%' or stuSex like '%$stuSex%'";
                        break;
                    case '1':
                        $sql = "select * from students where stuId like '%$search%'";
                        break;
                    case '2':
                        $sql = "select * from students where stuName like '%$search%'";
                        break;
                    case '3':
                        $sql = "select * from students where stuSex like '%$stuSex%'";
                        break;
                    case '4':
                        $sql = "select * from students where stuBrith like '%$search%'";
                        break;
                    case '5':
                        $sql = "select * from students ";
                        $isCheckSec = true;
                        break;
                }
            }
                    $result = $conn -> query($sql);
                    if($result-> num_rows > 0) {
                    // 输出数据
                    while  ($row = $result -> fetch_assoc()) {
                            $stuSex = $row["stuSex"]==1?'男':'女';
                        if($isCheckSec){
                            $sec = json_decode($row["stuSec"]);
                            $isTrue = false;
                            foreach($sec as $key => $val){
                                if(number_format($val) >= number_format($_GET['search'])){
                                    $isTrue = true;
                                    break;
                                }
                                }
                                if($isTrue){
                                    echo " { stuId:" .$row["stuId"] . ", stuName:'" .$row["stuName"] . "', stuSex:'" . $stuSex . "', stuBrith:'" . $row["stuBrith"] . "',stuSec:'".$row["stuSec"]."'},";
                                }
                        } else {
                            echo " { stuId:" .$row["stuId"] . ", stuName:'" .$row["stuName"] . "', stuSex:'" . $stuSex . "', stuBrith:'" . $row["stuBrith"] . "',stuSec:'".$row["stuSec"]."'},";
                        }
                    }
                } else {
                    echo "";
                }
        ?>
        ];


        var html = '';
        if(JSON.stringify(objs) == "[]"){
            html = '<tr><td>暂无数据</td><td>暂无数据</td><td>暂无数据</td><td>暂无数据</td><td>暂无数据</td><td>暂无数据</td><td>暂无数据</td><td><a href="javascript:;" class="btn modtify">编辑</a><a href="javascript:;" class="btn delete">删除</a></td></tr>';
        }else {
            for(var i=0;i<objs.length;i++){
                stuSec = JSON.parse(objs[i].stuSec);
                html += "<tr><td>"+ objs[i].stuId +
                        "</td><td>"+ objs[i].stuName +
                        "</td><td>"+ objs[i].stuSex +
                        "</td><td>"+ objs[i].stuBrith +
                        "</td><td>"+ stuSec.chinese +
                        "</td><td>"+ stuSec.math +
                        "</td><td>"+ stuSec.english +
                        "</td><td><a href='./edit.php?stuId=" + objs[i].stuId +
                        "' class='btn modtify'>编辑</a><a href='./delete.php?stuId=" + objs[i].stuId +
                        "' class='btn delete'>删除</a></td></tr>";
            }
        }
        tcontent.innerHTML = html;
        var now_rows = <?php
            $sql = "select * from students";
            $result = $conn -> query($sql);
            echo $result->num_rows;
        ?> / 20;
        // 获取数据总行数
        var pagination = document.querySelector(".pagination");
        html = "";
        for(let i=1;i<=now_rows;i++){
            html += `<li><a href="/index?limit=${i}">${i}</a></li>`;
        }
        pagination.innerHTML = html;


    </script>
</body>

</html>