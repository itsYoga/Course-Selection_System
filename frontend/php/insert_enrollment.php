<?php
    require_once("../../db_conn.php");

    header('Content-Type: application/json');

    session_start();

    // 檢查是否已登入
    if (!isset($_SESSION['username'])) {
        header("Location: http://localhost/db_final_project_git/Course-Selection_System/login.php");
        exit;
    }

    // 從 session 中取得使用者名稱
    $username = $_SESSION['username'];  

    // 查詢此使用者的 student_id
    $query = ("SELECT student_id FROM users WHERE username = ?");
    $stmt = $db->prepare($query);
    $error = $stmt->execute(array($username));
    $result = $stmt->fetchAll();
    for($i = 0; $i < count($result); $i++){
        $student_id = $result[$i]['student_id'];
    }

    $status = "enrolled";
    $input = json_decode(file_get_contents('php://input'), true);
    $course_id = $input['course_id'];

    // 加入目前的課程到 enrollment_records
    $query = ("INSERT INTO enrollment_records (student_id, course_id, status) 
                    VALUES (?, ?, ?)");
    $stmt = $db->prepare($query);
    $result = $stmt->execute(array($student_id, $course_id, $status));
?>