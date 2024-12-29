<?php

// 啟用 session
session_start();
$host = 'localhost'; 
$db = 'school_db'; 
$user = 'root'; 
$pass = ''; 
// Create connection
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// 檢查是否已登入
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// 從 session 中取得使用者名稱
$username = $_SESSION['username'];

// 查詢 student_id
$student_id = getStudentIdByUsername($conn, $username);

if ($student_id) {
    // 查詢課表與總學分
    $schedule = getStudentSchedule($conn, $student_id);
    $total_credits = getTotalCredits($conn, $student_id);
    displaySchedule($schedule, $username, $total_credits);
} else {
    echo "找不到該使用者的學生編號。";
}

// 函數：根據使用者名稱取得 student_id
function getStudentIdByUsername($conn, $username) {
    $query = "SELECT student_id FROM Users WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($student_id);
    $stmt->fetch();
    $stmt->close();
    return $student_id;
}

// 函數：取得學生的課表
function getStudentSchedule($conn, $student_id) {
    $query = "SELECT Courses.course_name, Course_Schedules.day_of_week, Course_Schedules.start_time, Course_Schedules.end_time
              FROM Enrollment_Records
              JOIN Courses ON Enrollment_Records.course_id = Courses.course_id
              JOIN Course_Schedules ON Courses.course_id = Course_Schedules.course_id
              WHERE Enrollment_Records.student_id = ?";

    $stmt = $conn->prepare($query);
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $schedule = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    return $schedule;
}

// 函數：取得總學分
function getTotalCredits($conn, $student_id) {
    $query = "SELECT GetTotalCredits(?) AS total_credits";
    $stmt = $conn->prepare($query);

    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $stmt->bind_result($total_credits);
    $stmt->fetch();
    $stmt->close();

    return $total_credits;
}

// 函數：顯示課表
function displaySchedule($schedule, $username, $total_credits) {
    // 將課表轉換成每週的格式
    $weekly_schedule = [];
    foreach ($schedule as $class) {
        $day = $class['day_of_week'];
        $time_slots = getTimeSlots($class['start_time'], $class['end_time']);
        foreach ($time_slots as $time_slot) {
            $weekly_schedule[$day][$time_slot] = "{$class['course_name']}";
        }
    }

    // 顯示頁面
    echo "<!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css' rel='stylesheet'>
        <title>課表</title>
    </head>
    <body>
        <div class='container mt-5'>
            <h1 class='text-center mb-4'>{$username} 的課表</h1>
            <table class='table table-bordered table-striped'>
                <thead class='table-dark'>
                    <tr>
                        <th>時間</th>
                        <th>星期一</th>
                        <th>星期二</th>
                        <th>星期三</th>
                        <th>星期四</th>
                        <th>星期五</th>
                    </tr>
                </thead>
                <tbody>";

    // 節次對應時間
    $time_slots = [
        1 => "08:20-09:10",
        2 => "09:20-10:10",
        3 => "10:20-11:10",
        4 => "11:15-12:05",
        5 => "12:05-13:00",
        6 => "13:10-14:00",
        7 => "14:10-15:00",
        8 => "15:10-16:00",
        9 => "16:05-16:55",
        10 => "17:30-18:20",
    ];

    foreach ($time_slots as $slot => $time) {
        echo "<tr>";
        echo "<td class='text-center'>{$time}</td>";
        for ($day = 1; $day <= 5; $day++) {
            echo "<td class='text-center'>" . ($weekly_schedule[$day][$slot] ?? "") . "</td>";
        }
        echo "</tr>";
    }

    echo "</tbody></table>";

    // 顯示總學分與返回按鈕
    echo "<div class='text-center'>
            <p class='mt-4'>目前選擇了 <strong>{$total_credits}</strong> 學分的課程。</p>
            <a href='main.php' class='btn btn-primary'>返回主畫面</a>
          </div>
        </div>
    </body>
    </html>";
}

// 函數：根據時間區間決定節次
function getTimeSlots($start_slot, $end_slot) {
    return range($start_slot, $end_slot);
}

?>
