<?php
    $db_connect = new mysqli("127.0.0.1","root","root","mydb");

    if(mysqli_connect_errno()){
        echo "Error:Could not connect to database.Please try again later.";
        exit;
    }
    @ini_set('memory_limit', '1024M');
    mysqli_query($db_connect,'SET NAMES UTF8');

    function query($db_connect,$query_sql){
        $db_connect->query("set names utf8");
        $result = $db_connect->query($query_sql);
        $num_rows = $result->num_rows;
        $return_list = array();
        for($i =0;$i<$num_rows;$i++){
            $row = $result->fetch_assoc();
            array_push($return_list,$row);
        }
        return $return_list;
    }

    function query_prams($db_connect,$query_sql,$params){
        $stmt = $db_connect->prepare($query_sql);
        $stmt->bind_param();
        $stmt->execute();
    }

    $query_sql = 'select * from devices where deviceid>0 limit 100';

    $rows = query($db_connect,$query_sql);
    header("Content-Type: text/html;charset=utf-8");
    echo var_dump($rows);
?>