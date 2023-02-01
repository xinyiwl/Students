<?php
require("./LinkMysql.php");
$conn = connentMysql();
if(!empty($_POST['stuId']) &&
    !empty($_POST['stuName']) &&
    !empty($_POST['stuBrith']) &&
    !empty($_POST['stuSec_chinese']) &&
    !empty($_POST['stuSec_math']) &&
    !empty($_POST['stuSec_english']))
        {
            $stuSec = '{"chinese":'.$_POST['stuSec_chinese'].',"math":'.$_POST['stuSec_math'].',"english":'.$_POST['stuSec_english'].'}';
            $sqlstr = "update students set stuName='".$_POST['stuName']."',stuSex=".$_POST['stuSex'].
            ",stuBrith='".$_POST['stuBrith']."',stuSec='".$stuSec."' where stuId=".$_POST['stuId'];
            if($conn->query($sqlstr)){
                echo "<script>alert('修改成功!');location.href='./index.php'</script>";
            }else {
                echo $conn->error;
                echo "<script>alert('修改失败!原因已打印');</script>";
            }
            
    }else {
        echo "<script>alert('修改失败，请检查信息完整性!');location.href='./index.php'</script>";
    }
$conn->close();

?>