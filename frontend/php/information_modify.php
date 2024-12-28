<html>
    <head>
        <meta charset="UTF-8"></meta>
        <title>編輯資訊</title>
        <link rel="stylesheet" href="../css/information_modify.css" /><!--連接css-->
        <link rel="stylesheet" href="../css/menu.css" /><!--連接css-->
    </head>

    <body>
        <div class="menu"><!--可選擇頁面-->
            <table class="menu_css">
                <tr>
                    <td>
                        <a href="index.php">Home</a>
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
        <div calss="modify_course">
            <table class="course">
                <caption>課程資訊</caption>
                <thead>
                    <tr>
                        <th scope="col">星期一</th>
                        <th scope="col">星期二</th>
                        <th scope="col">星期三</th>
                    </tr>
                </thead>
                    <tr></tr>
                <tbody>

                </tbody>
            </table>
        </div>
    </body>
</html>

<?php
    include_once "../db_conn.php"


?>