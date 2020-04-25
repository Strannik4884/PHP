<?php
    // include the util class
    require_once ("Database.php");
    $database = new Database();
    // open database connection
    $connection = $database->connect();
    // get all data from database
    $data = getDataFromDB($connection)->fetchAll();
    echo "Links count from database: " . count($data) . "\n";
    // check count of rows
    if(count($data) != 0){
        // output old links
        echo "Links:\n";
        foreach ($data as $item){
            echo $item["law_link"] . "\n";
        }
        // change links
        $changed_data = changeLinks($data);
        // update data in database
        updateDataInDB($changed_data, $connection);
        // close database connection
        $database->close();
    }

    // select all data from table 'law'
    function getDataFromDB(PDO $connection) {
        $data = $connection->query("SELECT * FROM law");
        // check query success
        if($data === false){
            die("\e[31mDatabase query error!\e[39m\n");
        }
        return $data;
    }

    // change links to new format
    function changeLinks(array $data){
        // pattern for getting law number from the link
        $pattern = '/(http:\/\/asozd\.duma\.gov\.ru\/main\.nsf\/\(Spravka\)\?OpenAgent&RN=)((\d+)-(\d+))/';
        $changed_data = array();
        // change every link
        foreach ($data as $item){
            // search law number by pattern
            preg_match($pattern, $item["law_link"], $matches);
            // change link to new format
            if(isset($matches[2])){
                $item["law_link"] = "http://sozd.parlament.gov.ru/bill/" . $matches[2];
                array_push($changed_data, $item);
            }
        }
        return $changed_data;
    }

    // update links in database
    function updateDataInDB(array $data, PDO $connection){
        // prepare update-query
        $prepared = $connection->prepare("UPDATE law SET law_link = :law_link WHERE law_id = :law_id");
        echo "\nUpdated links:\n";
        $count = 0;
        // update every link
        foreach ($data as $item){
            $prepared->bindParam(':law_link', $item["law_link"]);
            $prepared->bindParam(':law_id', $item["law_id"]);
            // check query success
            if($prepared->execute()){
                echo "\e[92m". $item["law_link"] . "\e[39m\n";
                $count++;
            }
            else{
                echo "\e[31mError while update law with id " . $item["law_id"] . "\e[39m\n";
            }
        }
        echo "Updated links count: \e[92m" . $count . "\e[39m\n";
    }
