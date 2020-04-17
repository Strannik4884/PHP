<?php
    function Calculate($input_stream)
    {
        // получаем количество ставок
        $rates_count = (int)fgets($input_stream);
        $rates = array();
        // читаем ставки и записываем в массив
        for ($i = 0; $i < $rates_count; $i++) {
            $tmp_input = explode(" ", fgets($input_stream));
            $rates[$i] = [
                'game_id' => (int)$tmp_input[0],
                'sum' => (float)$tmp_input[1],
                'game_result' => str_replace("\n", "", $tmp_input[2])
            ];
        }
        // получаем количество игр
        $games_count = (int)fgets($input_stream);
        $games = array();
        // читаем игры и записываем в массив
        for ($i = 0; $i < $games_count; $i++) {
            $tmp_input = explode(" ", fgets($input_stream));
            $games[(int)$tmp_input[0]] = [
                'L' => (float)$tmp_input[1],
                'R' => (float)$tmp_input[2],
                'D' => (float)$tmp_input[3],
                'game_result' => str_replace("\n", "", $tmp_input[4])
            ];
        }
        // начальный счёт
        $money = 0;
        // проходимся по ставкам и ищём соответствующую игру
        for ($i = 0; $i < $rates_count; $i++) {
            $current_game = $games[$rates[$i]['game_id']];
            $money -= $rates[$i]['sum'];
            if($current_game['game_result'] == $rates[$i]['game_result']){
                $money += $rates[$i]['sum'] * $current_game[$rates[$i]['game_result']];
            }
        }
        return $money;
    }
    // директория с тестами
    $src_dir = "tests/";
    // читаем все файлы
    $files = scandir($src_dir);
    // номер теста
    $test_num = 0;
    // проходимся по всем тестам
    for($i = 2; $i < count($files); $i+=2) {
        // читаем тестовые данные
        $input_file = fopen($src_dir.$files[$i + 1], 'r');
        // читаем правильный ответ
        $correct_file = fopen($src_dir.$files[$i], 'r');
        // получаем свой ответ
        $result = Calculate($input_file);
        $correct_result = (float)fgets($correct_file);
        $test_num++;
        // если ответы совпали - тест пройден
        if($result == $correct_result){
            echo "Test $test_num: OK\n";
        }
        // иначе провален
        else{
            echo "Test $test_num: FAILED\n";
        }
        fclose($input_file);
        fclose($correct_file);
    }