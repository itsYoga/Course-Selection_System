<?php
    //連接資料庫
    include_once "db_conn.php";
    //設定想要新增入資料庫的資料內容如下
    $id = "01";
    $name = "sean tseng";
    $dept_name = "Comp.Ci.";
    $salary = "5000";

    //使用預處理寫法是為了防止「sql injection」
    //設定要使用的SQL指令
    $query = ("insert into instructor values(?,?,?,?)");
    $stmt = $db->prepare($query);
    //執行SQL語法
    $result = $stmt->execute(array($id,$name,$dept_name,$salary));

    //以下為一般直接執行而沒有預處理的寫法，與上面的程式碼一起跑會因//為重複輸入而出現錯誤
    // $full_query = "insert into student values('01','sean tseng','Comp.Ci.','5000')";
    // $stmt = $db->query($full_query);
?>