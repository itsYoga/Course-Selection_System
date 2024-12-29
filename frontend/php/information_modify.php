<?php
    require_once("../../db_conn.php");
    session_start();

    // 檢查是否已登入
    if (!isset($_SESSION['username'])) {
        header("Location: http://localhost/db_final_project_git/Course-Selection_System/login.php");
        exit;
    }
?>

<html>
    <head>
        <meta charset="UTF-8"></meta>
        <title>編輯資訊</title>
        <link rel="stylesheet" href="../css/information_modify.css" /><!--連接css-->
        <link rel="stylesheet" href="../css/menu.css" /><!--連接css-->
    </head>

    <body>
        <!-- 傳送資料並跳轉到下方的 php 程式中 -->
        <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
            <div calss="modify_course">
                <table class="course">
                    <caption>課程資訊</caption>
                    <thead>
                        <tr>
                            <th scope="col">課程名稱</th>
                            <th scope="col">描述</th>
                            <th scope="col">學分</th>
                            <th scope="col">教室</th>
                            <th scope="col">星期</th>
                            <th scope="col">開始節數</th>
                            <th scope="col">結束節數</th>
                        </tr>
                    </thead>

                    <tbody>
                        
                            <tr>
                                
                                    <td><input type="text" name="course_name" /></td>
                                    <td><input type="text" name="description" /></td>
                                    <td><input type="text" name="credits" /></td>
                                    <td><input type="text" name="classroom_id" /></td>
                                    <td><input type="text" name="day_of_week" /></td>
                                    <td><input type="text" name="start_time" /></td>
                                    <td><input type="text" name="end_time" /></td>
                            </tr>

                            <tr></tr>
                        
                    </tbody>
                </table>
            </div>
            <input type="submit" name="login_btn" value="加入課程">
        </form>
    </body>

    <p><a href='../../main.php'><button type='button'>返回主畫面</button></a></p>
</html>

<?php
    // 接收上面 html 傳送的資料
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $course_name = $_POST['course_name'];
        $description = $_POST['description'];
        $credits = $_POST['credits'];
        $classroom_id = $_POST['classroom_id'];
        $day_of_week = $_POST['day_of_week'];
        $start_time = $_POST['start_time'];
        $end_time = $_POST['end_time'];
        $teacher_id = 1;

        // insert into courses
        $query = ("INSERT INTO courses (course_name, description, credits, teacher_id, classroom_id) 
                    VALUES (?, ?, ?, ?, ?)");
        $stmt = $db->prepare($query);
        $result = $stmt->execute(array($course_name, $description, $credits, $teacher_id, $classroom_id));

        // select 剛剛新增的 course_id
        $query = ("SELECT course_id
                        FROM courses
                        WHERE course_name = ? AND description = ? AND credits = ? AND classroom_id = ?");
        $stmt = $db->prepare($query);
        $error = $stmt->execute(array($course_name, $description, $credits, $classroom_id));
        $result = $stmt->fetchAll();
        for($i = 0; $i < count($result); $i++){
            $course_id = $result[$i][0];
        }

        // insert into course_schdeules
        $query = ("INSERT INTO course_schedules (course_id, day_of_week, start_time, end_time) 
                    VALUES (?, ?, ?, ?)");
        $stmt = $db->prepare($query);
        $result = $stmt->execute(array($course_id, $day_of_week, $start_time, $end_time));
    }

?>