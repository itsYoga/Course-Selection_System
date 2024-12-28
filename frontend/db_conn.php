<?php
    $user = 'root'; //資料庫使用者名稱
    $password = 'sean930516'; //資料庫的密碼
    try{
        //之後若要結束與資料庫的連線，則使用「$db = null;」
        $db = new PDO('mysql:host=localhost;dbname=school_db;charset=utf8', $user, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    }catch(PDOException $e){
        Print "ERROR!: " . $e->getMessage();
        die();
    }
?>