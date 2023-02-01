<?php
function connentMysql()
{
    $servername = "localhost";
    $username = "root";
    $password = "xh72695.";
    $database = "students";
    // 创建连接对象
    $conn = new mysqli($servername, $username, $password,$database);
    if($conn->connect_error){
        die("连接失败：".$conn->connect_error);
    }else {
        return $conn;
    }
}

?>