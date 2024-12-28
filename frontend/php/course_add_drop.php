<?php
    // include_once "../db_conn.php"
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

        <table id="test">
            <thead>
                <th scope="col">系所</th>
                <th scope="col">名稱</th>
                <th scope="col">時間</th>
                <th scope="col">操作</th>
            </thead>
            <tbody></tbody>
        </table>

        <?php
            // 連接資料庫
            include "../db_conn.php";
            $query = ("select department, course_name, day_of_week, start_time, end_time from (courses natural join course_schedules) join teachers using(teacher_id)");
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
                // print_r($temp);
                array_push($send_to_js, $temp);
                // print_r($send_to_js);
            }
            // 利用 json 來傳值給 js
            $result_json = json_encode($send_to_js);
        ?>
        
        <script>
            // 讀取目前的課程(未實作)




            // 利用 json 來接收 php 給的值
            let object1 = JSON.parse('<?=$result_json?>');
            let result = Object.values(object1);

            // 將 data 裡的上課時間從 day_of_week, start_time, end_time 轉成例如：101 102 103
            let data = result;
            let course_time_array = []; // 放全部的上課時間
            let course_time_number = []; // 放每個 course 的上課節數
            for (let i = 0; i < result.length; i++) {
                // course_time 放最終的值
                let course_time = "", temp;
                for(let j = result[i][3], k = 0; j <= result[i][4]; j++, k++){
                    temp = (result[i][2] * 100 + j).toString();
                    course_time = course_time + temp;
                    // course_time_array[i][k] = temp;
                    course_time_array.push(temp);

                    if(j != result[i][4]){
                        course_time = course_time + " ";
                    }
                }
                course_time_number.push(result[i][4] - result[i][3] + 1);
                console.log(course_time_number[i]);

                console.log(course_time);
                data[i][2] = course_time; // 把 day_of_week 改成 course_time
                data[i].pop(); // pop 掉 start_time
                data[i].pop(); // pop 掉 end_time
            }

            // 選取 id = test 的 table
            let tbody = document.querySelector("#test");
            for (let i = 0; i < data.length; i++) {
                let tr = document.createElement('tr');
                tbody.appendChild(tr);
                for (let j = 0; j < data[i].length; j++) {
                    let td = document.createElement('td');
                    td.innerHTML = data[i][j];
                    tr.appendChild(td);
                }

                // **加選功能**
                let td_1 = document.createElement('td');
                td_1.innerHTML = `<a href='javascript:;'>加選</a>`;
                let a_1 = td_1.children[0];
                a_1.addEventListener('click', () => {

                    let tempCount = 0; // 計算當下被加選的課程放在 course_time_array 的哪個位置
                    for(let j = 0; j < i; j++){
                        tempCount += course_time_number[j];
                    }

                    for (let j = tempCount; j < tempCount + course_time_number[i]; j++) {
                        
                        var el = document.getElementById(course_time_array[j]);
                        el.textContent = data[i][1]; // 將課程加入指定的表格中
                    }
                    
                    // let parent = a.parentNode.parentNode
                    // console.log(parent);
                    // parent.remove()
                })
                tr.appendChild(td_1);

                // **退選功能**
                let td_2 = document.createElement('td');
                td_2.innerHTML = `<a href='javascript:;'>退選</a>`;
                let a_2 = td_2.children[0];
                a_2.addEventListener('click', () => {

                    let tempCount = 0; // 計算當下被加選的課程放在 course_time_array 的哪個位置
                    for(let j = 0; j < i; j++){
                        tempCount += course_time_number[j];
                    }

                    for (let j = tempCount; j < tempCount + course_time_number[i]; j++) {
                        
                        var el = document.getElementById(course_time_array[j]);
                        el.textContent = ""; // 將指定表格中的課程刪除
                    }
                })
                tr.appendChild(td_2);
            }
        </script>
    </body>
</html>