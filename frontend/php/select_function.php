<?php
    function select($db, $select_column, $table){
        $option = [];
        $query = ("SELECT $select_column
                    FROM $table");
        $stmt = $db->prepare($query);
        $error = $stmt->execute();
        $result = $stmt->fetchAll();
        for($i = 0; $i < count($result); $i++){
            array_push($option, $result[$i][0]);
        }

        // 檢查是否有資料
        if (count($result) != 0) {
            // 生成 HTML 的 <select> 選單
            echo '<td><select name="' . $select_column . '" style="width: 70px;" >';
            echo '<option value="">請選擇</option>'; // 第一個空白選項
            for ($i = 0; $i < count($option); $i++) {
                // 使用 id 作為 value，name 作為顯示文字
                echo $option[$i];
                echo '<option value="' . $option[$i] . '">' . $option[$i] . '</option>';
            }
            echo '</select></td>';
        } else {
            echo "無資料可供選擇";
        }
    }
?>