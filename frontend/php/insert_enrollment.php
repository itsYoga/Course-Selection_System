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
    include "select_student_id.php";

    $input = json_decode(file_get_contents('php://input'), true);
    $course_id = $input['course_id'];
    $exist_course = false;

    // 看此課程有無加選過 沒有則 insert
    $query = ("SELECT * FROM enrollment_records WHERE course_id = ?");
    $stmt = $db->prepare($query);
    $error = $stmt->execute(array($course_id));
    $result = $stmt->fetchAll();
    if(count($result) != 0){
        $exist_course = true;
    }

    if(!$exist_course){
        // 加入目前的課程到 enrollment_records
        $query = ("INSERT INTO enrollment_records (student_id, course_id) 
                    VALUES (?, ?)");
        $stmt = $db->prepare($query);
        $result = $stmt->execute(array($student_id, $course_id));
    }
?>