<?php
require ('init.php');
header("content-Type:text/html;charset=utf-8");
session_start();

if(isset($_GET['type'])){
    $type = $_GET['type'];
}else if(isset($_POST['type'])){
    $type = $_POST['type'];
}
// $type = 'getRoutesData';

$con = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
mysql_set_charset("utf8",$con);
if (!$con) {
    die('连接失败 ' . mysql_error());
} else {
    mysql_select_db(DB_NAME, $con);
    //echo("链接数据库成功");

    // 推荐课程
    if($type === 'recommend'){
        $sql = "SELECT courseName,courseDesc FROM course ";
        $result = mysql_query($sql);
        if(!$result){
            $arr = array("status" => "0");
        }else{
            $cont=array();
            while($row = mysql_fetch_array($result, MYSQL_ASSOC)){
                $cont[]=$row;
            }
            $arr = array(
                "status" => "200",
                "content" => $cont
                );
        }
        echo json_encode($arr,JSON_UNESCAPED_UNICODE);
    }

    //已参加课程
    else if( $type === 'getCoursesId'){
        $uid = $_GET['userId'];
        $sql = "SELECT * FROM collectcourse WHERE userID='$uid'";
        $result = mysql_query($sql);
        $cont = array();
        if( !$result ){
            $arr = array( "status" => "0");
        }else{
            while($row = mysql_fetch_array($result, MYSQL_ASSOC)){
                $cont[] = $row;
            }
            $arr = array(
                "status" => "200",
                "content" => $cont
            );
        }
        echo json_encode($arr, JSON_UNESCAPED_UNICODE);
    }
    //拉取已参与课程信息
    else if( $type === 'getCoursesData'){
        $cidStr = $_GET['courseStr'];
        //拆分字符串
        $cids = explode("&",$cidStr);
        //串接cids
        $sql = "SELECT * FROM course WHERE courseID='".implode("' OR courseID='", $cids)."'";
        $result = mysql_query($sql);
        $cont = array();
        if(!$result){
            $arr = array("status" => "0");
        }else{
            while($row = mysql_fetch_array($result, MYSQL_ASSOC)){
                $cont[] = $row;
            }
            $arr = array(
                "status" => "200",
                "content" => $cont
            );
        }
        echo json_encode($arr, JSON_UNESCAPED_UNICODE);
    }
    //已参加轨迹
    else if( $type === 'getRoutesId'){
        $uid = $_GET['userId'];
        $cid = $_GET['courseId'];
        $sql = "SELECT *FROM learningrecord WHERE userID='$uid' AND pathID IN (SELECT pathID FROM learningpath WHERE courseID='$cid')";
        $result = mysql_query($sql);
        $cont = array();
        if( !$result ){
            $arr = array( "status" => "0");
        }else{
            while($row = mysql_fetch_array($result, MYSQL_ASSOC)){
                $cont[] = $row;
            }
            $arr = array(
                "status" => "200",
                "content" => $cont
            );
        }
        echo json_encode($arr, JSON_UNESCAPED_UNICODE);
    }
    //拉取已参与估计信息
    else if( $type === 'getRoutesData'){
        $ridStr = $_GET['routeStr'];

        //拆分字符串
        $rids = explode("&",$ridStr);
        //串接cids
        $sql = "SELECT * FROM learningpath WHERE pathID='".implode("' OR pathID='", $rids)."'";
        $result = mysql_query($sql);
        $cont = array();
        if(!$result){
            $arr = array("status" => "0");
        }else{
            while($row = mysql_fetch_array($result, MYSQL_ASSOC)){
                $cont[] = $row;
            }
            $arr = array(
                "status" => "200",
                "content" => $cont
            );
        }
        echo json_encode($arr, JSON_UNESCAPED_UNICODE);
    }
    //取消关注课程
        else if ($type === 'removeCourses'){
            $uid = $_GET['userId'];
            $cidStr = $_GET['courseStr'];
            $cids = explode("&", $cidStr);
            //$count = count($cids);
            $sql = "DELETE * FROM  collectcourse  where userID = '$uid'  and courseID in ('$cids') ";
            $res = mysql_query($sql);
            if (!$res) {
                $arr = array("status" => "0");
            }else {
                    $arr = array("status" => "200");
            }
        }
        // 推荐课程
    else if($type === 'recommendCourse'){
        $sql = "SELECT * FROM course ORDER BY courseHeat DESC LIMIT 4 ";
        $result = mysql_query($sql);
        if(!$result){
            $arr = array("status" => "0");
        }else{
            $cont=array();
            while($row = mysql_fetch_array($result, MYSQL_ASSOC)){
                $cont[]=$row;
            }
            $arr = array(
                "status" => "200",
                "content" => $cont
                );
        }
        echo json_encode($arr,JSON_UNESCAPED_UNICODE);
    }

    //推荐轨迹
    else if($type === 'recommendPath'){
        $cid = $_GET['courseId'];
        $sql = "SELECT * FROM learningPath WHERE courseID='$cid' ORDER BY pathHeat DESC LIMIT 4";
        $result = mysql_query($sql);
        if(!$result){
            $arr = array("status" => "0");
        }else{
            $cont=array();
            while($row = mysql_fetch_array($result, MYSQL_ASSOC)){
                $cont[]=$row;
            }
            $arr = array(
                "status" => "200",
                "content" => $cont
            );
        }
        echo json_encode($arr,JSON_UNESCAPED_UNICODE);
    }
    //取得最近观看轨迹id
    else if($type === 'getLastRoute'){
        $uid = $_GET['userId'];
        $sql = "SELECT * FROM learningrecord WHERE userID='$uid' ORDER BY recordUpdateTime DESC LIMIT 1";

         $result = mysql_query($sql);
        if(!$result){
            $arr = array("status" => "0");
        }else{
            $cont=array();
            while($row = mysql_fetch_array($result, MYSQL_ASSOC)){
                $cont[]=$row;
            }
            $arr = array(
                "status" => "200",
                "content" => $cont
            );
        }
        echo json_encode($arr,JSON_UNESCAPED_UNICODE);
    }

}
mysql_close($con);
?>

