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
                            <th scope="col">教師編號</th>
                            <th scope="col">教室編號</th>
                            <th scope="col">星期</th>
                            <th scope="col">開始節數</th>
                            <th scope="col">結束節數</th>
                        </tr>
                    </thead>

                    <tbody>
                            <tr>
                                <td><input type="text" name="course_name" /></td>
                                <td><input type="text" name="description" /></td>
                                <td><input type="text" name="credits" style="width: 50px;" /></td>

                                <!--從資料庫中導入資訊到 下拉式選單 中-->
                                <?php 
                                    include "select_function.php";
                                    select($db, "teacher_id", "teachers");
                                    select($db, "classroom_id", "classrooms");
                                ?>

                                <td><select name="day_of_week" style="width: 50px;" >
                                    <option value="">請選擇</option>    
                                    <option value=1>1</option>
                                    <option value=2>2</option>
                                    <option value=3>3</option>
                                    <option value=4>4</option>
                                    <option value=5>5</option>
                                    <option value=6>6</option>
                                    <option value=7>7</option>
                                </select></td>
                                <td><select name="start_time" style="width: 70px;" >
                                    <option value="">請選擇</option>
                                    <option value=1>1</option>
                                    <option value=2>2</option>
                                    <option value=3>3</option>
                                    <option value=4>4</option>
                                    <option value=5>5</option>
                                    <option value=6>6</option>
                                    <option value=7>7</option>
                                    <option value=8>8</option>
                                    <option value=9>9</option>
                                    <option value=10>10</option>
                                </select></td>
                                <td><select name="end_time" style="width: 70px;" >
                                    <option value="">請選擇</option>    
                                    <option value=1>1</option>
                                    <option value=2>2</option>
                                    <option value=3>3</option>
                                    <option value=4>4</option>
                                    <option value=5>5</option>
                                    <option value=6>6</option>
                                    <option value=7>7</option> 
                                    <option value=8>8</option>
                                    <option value=9>9</option>
                                    <option value=10>10</option>
                                </select></td>
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
        $teacher_id = $_POST['teacher_id'];
        $classroom_id = $_POST['classroom_id'];
        $day_of_week = $_POST['day_of_week'];
        $start_time = $_POST['start_time'];
        $end_time = $_POST['end_time'];

        // 如果有任一個變數沒有值就不執行
        if($course_name == "" || $description == "" || $credits == "" || $teacher_id == "" || $classroom_id == "" || $day_of_week == "" || $start_time == "" || $end_time == ""){
            echo "<script type='text/javascript'> alert('請輸入完整資訊'); </script>";
        }else{
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

            echo "<script type='text/javascript'> alert('加入成功'); </script>";
        }
        
    }

?>