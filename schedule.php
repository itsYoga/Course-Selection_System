<?php
session_start();

// 資料庫連線資訊
$host = 'localhost'; 
$db = 'school_db'; 
$user = 'root'; 
$pass = ''; 
$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("連線失敗：" . $conn->connect_error);
}

// 檢查登入狀態
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$username = $_SESSION['username'];
$student_id = getStudentIdByUsername($conn, $username);

if (!$student_id) {
    echo "找不到該使用者的學生編號。";
    exit;
}

$schedule = getStudentSchedule($conn, $student_id);
$total_credits = getTotalCredits($conn, $student_id);

function getStudentIdByUsername($conn, $username) {
    $query = "SELECT student_id FROM users WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($student_id);
    $stmt->fetch();
    $stmt->close();
    return $student_id;
}

function getStudentSchedule($conn, $student_id) {
    $query = "SELECT courses.course_id, courses.course_name, course_schedules.day_of_week, course_schedules.start_time, course_schedules.end_time
              FROM enrollment_records
              JOIN courses ON enrollment_records.course_id = courses.course_id
              JOIN course_schedules ON courses.course_id = course_schedules.course_id
              WHERE enrollment_records.student_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $schedule = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    return $schedule;
}

function getTotalCredits($conn, $student_id) {
    $query = "SELECT SUM(courses.credits) AS total_credits
              FROM enrollment_records
              JOIN courses ON enrollment_records.course_id = courses.course_id
              WHERE enrollment_records.student_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $stmt->bind_result($total_credits);
    $stmt->fetch();
    $stmt->close();
    return $total_credits;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <title>課表</title>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4"><?= $username ?> 的課表</h1>
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>時間</th>
                    <th>星期一</th>
                    <th>星期二</th>
                    <th>星期三</th>
                    <th>星期四</th>
                    <th>星期五</th>
                </tr>
            </thead>
            <tbody>
                <?php
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

                $weekly_schedule = [];
                foreach ($schedule as $class) {
                    $day = $class['day_of_week'];
                    for ($time = $class['start_time']; $time <= $class['end_time']; $time++) {
                        $weekly_schedule[$day][$time] = [
                            'course_id' => $class['course_id'],
                            'course_name' => $class['course_name']
                        ];
                    }
                }

                foreach ($time_slots as $slot => $time) {
                    echo "<tr><td class='text-center'>{$time}</td>";
                    for ($day = 1; $day <= 5; $day++) {
                        if (isset($weekly_schedule[$day][$slot])) {
                            $course = $weekly_schedule[$day][$slot];
                            echo "<td class='text-center'>
                                    <a href='#' class='course-link' data-course-id='{$course['course_id']}'>{$course['course_name']}</a>
                                  </td>";
                        } else {
                            echo "<td class='text-center'></td>";
                        }
                    }
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
        <div class="text-center">
            <p class="mt-4">目前選擇了 <strong><?= $total_credits ?></strong> 學分的課程。</p>
            <a href="main.php" class="btn btn-primary">返回主畫面</a>
        </div>
    </div>

    <!-- Bootstrap Modal -->
    <div class="modal fade" id="courseModal" tabindex="-1" aria-labelledby="courseModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="courseModalLabel">課程詳細資料</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>課程名稱：</strong><span id="modal-course-name"></span></p>
                    <p><strong>描述：</strong><span id="modal-description"></span></p>
                    <p><strong>學分：</strong><span id="modal-credits"></span></p>
                    <p><strong>教師：</strong><span id="modal-teacher-id"></span></p>
                    <p><strong>教室：</strong><span id="modal-classroom-id"></span></p>
                </div>
            </div>
        </div>
    </div>

    <!-- AJAX Script -->
    <script>
        $(document).ready(function () {
            $(".course-link").on("click", function (e) {
                e.preventDefault();
                let courseId = $(this).data("course-id");

                $.ajax({
                    url: "get_course_details.php",
                    type: "POST",
                    data: { course_id: courseId },
                    success: function (data) {
                        let course = JSON.parse(data);

                        $("#modal-course-name").text(course.course_name);
                        $("#modal-description").text(course.description);
                        $("#modal-credits").text(course.credits);
                        $("#modal-teacher-id").text(course.teacher_id);
                        $("#modal-classroom-id").text(course.classroom_id);

                        $("#courseModal").modal("show");
                    },
                    error: function (xhr, status, error) {
                        alert("無法獲取課程詳細資料：" + error);
                    }
                });
            });
        });
    </script>
</body>
</html>