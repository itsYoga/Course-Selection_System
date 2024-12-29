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

    $status = "dropped";
    $input = json_decode(file_get_contents('php://input'), true);
    $course_id = $input['course_id'];

    // 將目前的課程狀態改成 dropped
    $query = ("DELETE FROM enrollment_records 
                WHERE course_id = ?");
    $stmt = $db->prepare($query);
    $result = $stmt->execute(array($course_id));
?>