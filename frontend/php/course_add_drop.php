<?php
    require_once("../../db_conn.php");
    session_start();

    // 檢查是否已登入
    if (!isset($_SESSION['username'])) {
        header("Location: http://localhost/db_final_project_git/Course-Selection_System/login.php");
        exit;
    }

    $username = $_SESSION['username'];
?>

<html>
    <head>
        <meta charset="UTF-8"></meta>
        <title>課程加退選</title>
        <link rel="stylesheet" href="../css/course_add_drop.css" /><!--連接css-->
        <link rel="stylesheet" href="../css/menu.css" /><!--連接css-->
    </head>
    <body>
        <div class="menu"><!--可選擇頁面-->
            <table class="menu_css">
                <tr>
                    <td>
                        <a href="../../main.php">Home</a>
                    </td>
                    <td>
                        <a href="../php/course_add_drop.php">課程加退選</a>
                    </td>
                    <td>
                        <a href="../php/information_modify.php">編輯資訊</a>
                    </td>
                </tr>
            </table>
        </div>

        <br /><br />
        <div class="col-sm-8">
            <table class="school_timetable"><!--暫定動態課表-->
                <caption>暫定動態課表</caption>
                <thead>
                    <tr>
                        <td></td>
                        <th scope="col">星期一</th>
                        <th scope="col">星期二</th>
                        <th scope="col">星期三</th>
                        <th scope="col">星期四</th>
                        <th scope="col">星期五</th>
                        <th scope="col">星期六</th>
                        <th scope="col">星期日</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row">1</th>
                        <td id="101"></td>
                        <td id="201"></td>
                        <td id="301"></td>
                        <td id="401"></td>
                        <td id="501"></td>
                        <td id="601"></td>
                        <td id="701"></td>
                    </tr>
                    <tr>
                        <th scope="row">2</th>
                        <td id="102"></td>
                        <td id="202"></td>
                        <td id="302"></td>
                        <td id="402"></td>
                        <td id="502"></td>
                        <td id="602"></td>
                        <td id="702"></td>
                    </tr>
                    <tr>
                        <th scope="row">3</th>
                        <td id="103"></td>
                        <td id="203"></td>
                        <td id="303"></td>
                        <td id="403"></td>
                        <td id="503"></td>
                        <td id="603"></td>
                        <td id="703"></td>
                    </tr>
                    <tr>
                        <th scope="row">4</th>
                        <td id="104"></td>
                        <td id="204"></td>
                        <td id="304"></td>
                        <td id="404"></td>
                        <td id="504"></td>
                        <td id="604"></td>
                        <td id="704"></td>
                    </tr>
                    <tr>
                        <th scope="row">5</th>
                        <td id="105"></td>
                        <td id="205"></td>
                        <td id="305"></td>
                        <td id="405"></td>
                        <td id="505"></td>
                        <td id="605"></td>
                        <td id="705"></td>
                    </tr>
                    <tr>
                        <th scope="row">6</th>
                        <td id="106"></td>
                        <td id="206"></td>
                        <td id="306"></td>
                        <td id="406"></td>
                        <td id="506"></td>
                        <td id="606"></td>
                        <td id="706"></td>
                    </tr>
                    <tr>
                        <th scope="row">7</th>
                        <td id="107"></td>
                        <td id="207"></td>
                        <td id="307"></td>
                        <td id="407"></td>
                        <td id="507"></td>
                        <td id="607"></td>
                        <td id="707"></td>
                    </tr>
                    <tr>
                        <th scope="row">8</th>
                        <td id="108"></td>
                        <td id="208"></td>
                        <td id="308"></td>
                        <td id="408"></td>
                        <td id="508"></td>
                        <td id="608"></td>
                        <td id="708"></td>
                    </tr>
                    <tr>
                        <th scope="row">9</th>
                        <td id="109"></td>
                        <td id="209"></td>
                        <td id="309"></td>
                        <td id="409"></td>
                        <td id="509"></td>
                        <td id="609"></td>
                        <td id="709"></td>
                    </tr>
                    <tr>
                        <th scope="row">10</th>
                        <td id="110"></td>
                        <td id="210"></td>
                        <td id="310"></td>
                        <td id="410"></td>
                        <td id="510"></td>
                        <td id="610"></td>
                        <td id="710"></td>
                    </tr>
                </tbody>
                <tfoot>

                </tfoot>
            </table>
        </div>

        <br /><br />

        <?php
            // 查詢此使用者的 student_id
            include "select_student_id.php";

            $status = "enrolled";
            $current_course = [[]];

            // 看目前已選甚麼課程
            $query = ("SELECT course_name, day_of_week, start_time, end_time
                        FROM (courses natural join course_schedules) join enrollment_records using (course_id)
                        WHERE student_id = ? AND status = ?");

            $stmt = $db->prepare($query);
            $error = $stmt->execute(array($student_id, $status));
            $result = $stmt->fetchAll();

            // 有已選的課程
            if(count($result) != 0){
                for($i = 0; $i < count($result); $i++){
                    // array_push($current_course, $result[$i]['course_name']);
                    // array_push($current_course, $result[$i]['day_of_week']);
                    // array_push($current_course, $result[$i]['start_time']);
                    // array_push($current_course, $result[$i]['end_time']);
                    $current_course[$i][0] = $result[$i]['course_name'];
                    $current_course[$i][1] = $result[$i]['day_of_week'];
                    $current_course[$i][2] = $result[$i]['start_time'];
                    $current_course[$i][3] = $result[$i]['end_time'];
                }
                // 利用 json 來傳值給 js
                // $result_json = json_encode($current_course);


                // $result = json_decode($result_json, true);
    
                // 將現有的課程加入 暫定動態課表 中
                // 將 data 裡的上課時間從 day_of_week, start_time, end_time 轉成例如：101 102 103
                // $data = [];
                // $course_time_array = []; // 放全部的上課時間
                // $course_time_number = []; // 放每個 course 的上課節數
    
                // $course_id = []; // 放每個 course 的 course_id
    
                for($i = 0; $i < count($current_course); $i++) {
                    // $course_time = [];
                    $course_name = $current_course[$i][0];
                    $day_of_week = (int) $current_course[$i][1];
                    $start_time = (int) $current_course[$i][2];
                    $end_time = (int) $current_course[$i][3];
                    // array_push($course_id, $course[5]);
                    
                    $current_course_time = "";
                    for ($j = $start_time; $j <= $end_time; $j++) {
                        $current_course_time = (string) $day_of_week * 100 + $j;
                        echo $current_course_time . " " . $course_name;
                        echo "<script type='text/javascript'> addCurrentCourse('$current_course_time', '$course_name'); </script>"; // 更改指定表格的 text

                        // $course_time[] = $temp;
                        // $course_time_array[] = $temp; // 全部節數加入陣列
                    }
    
                    // $course_time_number[] = count($course_time); // 每門課的節數
                    // $course[2] = implode(' ', $course_time); // 用空格連接節數
                    // array_splice($course, 3); // 移除 start_time, end_time, course_id    3 表示移除 $course[3] 以後的元素
                    // $data[] = $course;
                }
            }

            // 抓取資料庫中與課程相關訊息的檔案
            $query = ("SELECT department, course_name, day_of_week, start_time, end_time, course_id 
                        from (courses natural join course_schedules) join teachers using(teacher_id)");
            $stmt = $db->prepare($query);
            $error = $stmt->execute(array());
            $result = $stmt->fetchAll();

            $send_to_js = []; // 存下列的結果
            for($i = 0; $i < count($result); $i++){
                $temp = [];
                array_push($temp, $result[$i]['department']);
                array_push($temp, $result[$i]['course_name']);
                array_push($temp, $result[$i]['day_of_week']);
                array_push($temp, $result[$i]['start_time']);
                array_push($temp, $result[$i]['end_time']);
                array_push($temp, $result[$i]['course_id']);
                // print_r($temp);
                array_push($send_to_js, $temp);
                // print_r($send_to_js);
            }
            // 利用 json 來傳值給 js
            $result_json = json_encode($send_to_js);


            $result = json_decode($result_json, true);
            // 將 data 裡的上課時間從 day_of_week, start_time, end_time 轉成例如：101 102 103
            $data = [];
            $course_time_array = []; // 放全部的上課時間
            $course_time_number = []; // 放每個 course 的上課節數

            $course_id = []; // 放每個 course 的 course_id

            foreach ($result as $index => $course) {
                $course_time = [];
                $day_of_week = $course[2];
                $start_time = $course[3];
                $end_time = $course[4];
                array_push($course_id, $course[5]);

                for ($j = $start_time; $j <= $end_time; $j++) {
                    $temp = $day_of_week * 100 + $j;
                    $course_time[] = $temp;
                    $course_time_array[] = $temp; // 全部節數加入陣列
                }

                $course_time_number[] = count($course_time); // 每門課的節數
                $course[2] = implode(' ', $course_time); // 用空格連接節數
                array_splice($course, 3); // 移除 start_time, end_time, course_id    3 表示移除 $course[3] 以後的元素
                $data[] = $course;
            }
        ?>

        <!--輸出表格-->
        <table id="test">
            <thead>
                <tr>
                    <th>系所</th>
                    <th>課程名稱</th>
                    <th>上課時間</th>
                    <th>加選</th>
                    <th>退選</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $i => $course): ?>
                    <tr>
                        <?php foreach ($course as $value): ?>
                            <td><?= htmlspecialchars($value) ?></td>
                        <?php endforeach; ?>
                        <td><a href="javascript:;" onclick="addCourse(<?= $i ?>)">加選</a></td>
                        <td><a href="javascript:;" onclick="dropCourse(<?= $i ?>)">退選</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>


        <script>
            // 加入目前已有課程
            function addCurrentCourse(current_course_time, course_name){
                let el = document.getElementById(current_course_time);
                if (el) el.textContent = course_name;
            }

            let courseTimeArray = <?= json_encode($course_time_array) ?>;
            let courseTimeNumber = <?= json_encode($course_time_number) ?>;
            let data = <?= json_encode($data) ?>;
            let courseID = <?= json_encode($course_id) ?>
            
            // 加選功能
            function addCourse(index) {
                // 呼叫 insert_enrollment.php
                fetch('insert_enrollment.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        course_id: courseID[index],
                    }),
                })
                    .then((response) => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json(); // 假設 `insert_enrollment.php` 返回 JSON 格式的回應
                    })
                    .then((responseData) => {
                        console.log('Enrollment successful:', responseData);
                    })
                    .catch((error) => {
                        console.error('Error during enrollment:', error);
                    });
                
                let tempCount = 0; // 計算目前的指定課程在 courseTimeArray 的哪個位置
                for (let j = 0; j < index; j++) {
                    tempCount += courseTimeNumber[j];
                }

                for (let j = tempCount; j < tempCount + courseTimeNumber[index]; j++) {
                    let el = document.getElementById(courseTimeArray[j]);
                    if (el) el.textContent = data[index][1]; // 更改指定表格的 text
                }

                
            }

            // 退選功能
            function dropCourse(index) {
                let tempCount = 0; // 計算目前的指定課程在 courseTimeArray 的哪個位置
                for (let j = 0; j < index; j++) {
                    tempCount += courseTimeNumber[j];
                }

                for (let j = tempCount; j < tempCount + courseTimeNumber[index]; j++) {
                    let el = document.getElementById(courseTimeArray[j]);
                    if (el) el.textContent = ""; // 刪除指定表格的 text
                }

                // 呼叫 drop_enrollment.php
                fetch('drop_enrollment.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        course_id: courseID[index],
                    }),
                })
                    .then((response) => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json(); // 假設 `drop_enrollment.php` 返回 JSON 格式的回應
                    })
                    .then((responseData) => {
                        console.log('Enrollment successful:', responseData);
                    })
                    .catch((error) => {
                        console.error('Error during enrollment:', error);
                    });
            }
        </script>

    </body>
</html>