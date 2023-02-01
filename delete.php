<?php
require("./LinkMysql.php");
$conn = connentMysql();
if(isset($_GET['stuId']))
{
    $stuId = $_GET['stuId'];
    $sql = "delete from students where stuId = $stuId";
    if($conn->query($sql)){
        echo "<script>alert('删除成功!');location.href='./index.php'</script>";
    }else 
    {
        echo "<script>alert('删除失败!');console.log('".$conn->error."');location.href='./index.php'</script>";
    }
}else {
    echo "<script>alert('非法请求!');location.href='./index.php'</script>";
}
?>