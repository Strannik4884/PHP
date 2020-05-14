<?php
    session_start();
    // include the util class
    require_once("Database.php");
    // if both fields are filled
    if(!empty($_POST['law_number']) and !empty($_POST['profile_committee'])){
        $_SESSION['error'] = 'Заполните только одно выбранное поле!';
        header('Location: /index.php');
    }
    // if law_number is filled
    else if(!empty($_POST['law_number'])){
        showLawsDefault('law_number', $_POST['law_number']);
    }
    // if profile_committee is filled
    else if(!empty($_POST['profile_committee'])){
        showLawsWithPDO('profile_committee', $_POST['profile_committee']);
    }
    // if both fields are empty
    else{
        $_SESSION['error'] = 'Заполните одно выбранное поле!';
        header('Location: /index.php');
    }

    // get data from database using pg_connect
    function showLawsDefault(string $lawProperty, string $propertyValue)
    {
        $database = new Database();
        // open database connection
        $connection = $database->connectPgConnect();
        // query string
        $query = "SELECT * FROM law WHERE " . $lawProperty . " = '" . $propertyValue . "';";
        $data = array();
        // get data
        $result = pg_query($connection, $query);
        if($result){
            while ($item = pg_fetch_array($result, null, PGSQL_ASSOC)) {
                array_push($data, $item);
            }
        }
        // if error
        else{
            $_SESSION['show_action_error'] = "Ошибка запроса: " . pg_last_error();
        }
        $_SESSION['data'] = $data;
    }

    // get data from database using PDO
    function showLawsWithPDO(string $lawProperty, string $propertyValue)
    {
        $database = new Database();
        // open database connection
        $connection = $database->connectPDO();
        // query string
        $prepared = $connection->prepare("SELECT * FROM law WHERE " . $lawProperty . " = :propertyValue");
        $prepared->bindParam(':propertyValue', $propertyValue);
        // get data
        if ($prepared->execute()) {
            $_SESSION['data'] = $prepared->fetchAll();
        }
        // if error
        else{
            $_SESSION['show_action_error'] = "Ошибка запроса: " . $prepared->errorCode();
        }
    }
    ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
    <title>Безопасность</title>
    <link type="text/css" rel="stylesheet" href="../css/materialize.min.css" media="screen,projection"/>
    <link type="text/css" rel="stylesheet" href="../css/materialert.css" media="screen,projection"/>
    <link type="text/css" rel="stylesheet" href="../css/style.css"/>
</head>
<body>
<div class="container">
    <div class="section">
        <div class="valign-wrapper center-align" style="flex: 1;">
            <div class="container valign" style="max-width: 800px;">
                <?php
                if(isset($_SESSION['show_action_error'])){
                    echo "<div class=\"materialert error\" id=\"message-box\">
                                <div class=\"material-icons\">error_outline</div>" . $_SESSION['error'] ."</div>";
                    unset($_SESSION['show_action_error']);
                }
                ?>
                <ul class="collection">
                    <?php
                        foreach ($_SESSION['data'] as $item) {
                            echo "<li class=\"collection-item\">
                                    <div class=\"col s12\">
                                        <div class=\"row\">
                                            <div class=\"col s12\">
                                                <a href=\"http://asozd.duma.gov.ru/main.nsf/(Spravka)?OpenAgent&RN=" . $item['law_number'] . "\"><h5>Законопроект № " . $item['law_number'] . "</h5></a>
                                            </div>
                                        </div>
                                        <div class=\"row\">
                                            <div class=\"col s12\">
                                                " . $item['law_name'] . "
                                            </div>
                                        </div>
                                        <div class=\"row\">
                                            <div class=\"col s12\">
                                                Профильный комитет: " . $item['profile_committee'] . "
                                            </div>
                                        </div>
                                    </div>
                                 </li>";
                        }
                        unset($_SESSION['data']);
                    ?>
                </ul>
                <form action="/index.php">
                    <button class="btn waves-effect waves-light" onclick="location.href='/index.php'" type="button">На главную</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="../js/materialize.min.js"></script>
</body>
</html>
