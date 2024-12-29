<?php
    // 查詢此使用者的 student_id
    $query = ("SELECT student_id FROM users WHERE username = ?");
    $stmt = $db->prepare($query);
    $error = $stmt->execute(array($username));
    $result = $stmt->fetchAll();
    for($i = 0; $i < count($result); $i++){
        $student_id = $result[$i]['student_id'];
    }
?>