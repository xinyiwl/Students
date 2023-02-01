<?php
$isModtify = isset($_GET["stuId"]);
$Title = "";
$conn = null;
class Students {
    public $stuId =  '';
    public $stuName =  '';
    public $stuSex =  1;
    public $stuBrith =  '';
    public $stuSec_chinese =  '';
    public $stuSec_math =  '';
    public $stuSec_english =  '';
};
$obj = new Students();

if($isModtify){
    $Title =  "修改";
    require("./LinkMysql.php");
    $conn = connentMysql();
    $conn->query("set names 'utf8'");
    $sql = "select * from students where stuId = ".$_GET["stuId"];
    $result = $conn->query($sql);
    if($result->num_rows > 0){
        $row = $result->fetch_assoc();
        $stuSec = json_decode($row["stuSec"]);
        $obj->stuId = $row["stuId"];
        $obj->stuName = $row["stuName"];
        $obj->stuSex = $row["stuSex"];
        $obj->stuBrith = $row["stuBrith"];
        $obj->stuSec_chinese = $stuSec->chinese;
        $obj->stuSec_math = $stuSec->math;
        $obj->stuSec_english = $stuSec->english;
    }

}else {
    $Title = "添加";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $Title?></title>
    <link rel="stylesheet" href="./css/bootstrap.min.css">
</head>
<body>
<div class="panel panel-default" style="width: 800px;margin: 10px auto;">
  <div class="panel-heading">
    <h3 class="panel-title"><?php echo $Title?>用户</h3>
  </div>
  <div class="panel-body">
  <form action="<?php if($isModtify) echo "./modtify.php"; else echo "./add.php"; ?>" method="post">
  <div class="form-group">
    <label for="exampleInputEmail1">学号</label>
    <input type="text" class="form-control" placeholder="No" name="stuId" value="<?php echo $obj->stuId?>">
  </div>
  <div class="form-group">
    <label for="exampleInputEmail1">姓名</label>
    <input type="text" class="form-control" placeholder="Name" name="stuName" value="<?php echo $obj->stuName?>">
  </div>
  <div class="form-group">
    <label for="exampleInputEmail1">性别</label>
    <select class="form-control" placeholder="Sex" name="stuSex">
        <option value="1" <?php if ($obj->stuSex == 1)
            echo "selected";?>>男</option>
        <option value="0" <?php if ($obj->stuSex == 0)
            echo "selected";?>>女</option>
    </select>
  </div>
  <div class="form-group">
    <label for="exampleInputEmail1">出生日期</label>
    <input type="date" class="form-control" placeholder="时间格式(xxxx-xx-xx)" name="stuBrith" id="date">
  </div>
        <script>
            function setDate(date){
                document.querySelector("#date").value = date;
            }
            window.onload = function(){
                <?php if($isModtify) echo "setDate('$obj->stuBrith')";?>
            }
        </script>
    <div class="form-group">
    <label for="exampleInputEmail1">语文</label>
    <input type="text" class="form-control" placeholder="Chinese" name="stuSec_chinese" value="<?php echo $obj->stuSec_chinese?>">
  </div>
  <div class="form-group">
    <label for="exampleInputEmail1">数学</label>
    <input type="text" class="form-control" placeholder="Math" name="stuSec_math" value="<?php echo $obj->stuSec_math?>">
  </div>
  <div class="form-group">
    <label for="exampleInputEmail1">英语</label>
    <input type="text" class="form-control" placeholder="English" name="stuSec_english" value="<?php echo $obj->stuSec_english?>">
  </div>
        <input type="submit" class="btn btn-primary" value="<?php echo $Title;?>">
        </form>
  </div>
</div>
</body>
</html>