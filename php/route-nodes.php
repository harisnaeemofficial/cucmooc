<?php
require ('init.php');
header("content-Type:text/html;charset=utf-8");
$nodeStr = $_GET["nodeStr"];
//拆分字符串
$nodes = explode("&",$nodeStr);


$con = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
mysql_set_charset("utf8",$con);

if (!$con) {
    die('连接失败 ' . mysql_error());
} else {
    mysql_select_db(DB_NAME, $con);
    //echo("链接数据库成功");

    //串接nodes
    $sql = "SELECT * FROM node WHERE nodeID='".implode("' OR nodeID='", $nodes)."'";
    $result = mysql_query($sql);
    $cont=array();

    $rows = mysql_num_rows($result);
    if($rows == 0){
        $arr = array(
            "status" => "0"
        );
    }else{
        while($row = mysql_fetch_array($result, MYSQL_ASSOC)){
            array_push($cont,$row);
            $arr = array(
                "status" => "200",
                "content" => $cont
            );
        }

    }

    echo json_encode($arr,JSON_UNESCAPED_UNICODE);

}
mysql_close($con);
?>

