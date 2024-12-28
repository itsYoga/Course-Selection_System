<?php
    include "db_conn.php";
    // $id = "02";   列印指定的 id
    // $query = ("select * from instructor where id = ?");  列印指定的 id
    $query = ("select * from instructor");
    $stmt = $db->prepare($query);
    // $error = $stmt->execute(array($id));  列印指定的 id
    $error = $stmt->execute(array());
    $result = $stmt->fetchAll();
    //以上寫法是為了防止「sql injection」
    for($i = 0; $i < count($result); $i++){
        echo "id:".$result [$i]['id'].'<br>'.
        "name:". $result [$i]['name'].'<br>'.
        "dept_name:".$result[$i]['dept_name'].'<br>'.
        "salary:". $result[$i]['salary'].' '.
        '<br>';
    }

    //一般直接執行而沒有預處理的寫法
    //  where id = ‘02’
    // $query = ("select * from instructor where id = ‘02’");
    // $stmt = $db->query($query);
    // $result = $stmt->fetchAll();
?>