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
            $sqlstr = "insert students values (".$_POST['stuId'].",'".$_POST['stuName']."',".$_POST['stuSex'].
            ",'".$_POST['stuBrith']."','".$stuSec."')";
            
            if($conn->query($sqlstr)){
                echo "<script>alert('添加成功!');location.href='./index.php'</script>";
            }else {
                echo $conn->error;
                echo "<script>alert('添加失败，原因已打印!');</script>";
            }
    }else {
        echo "<script>alert('添加失败，请检查信息完整性!');location.href='./index.php';</script>";
    }
?>