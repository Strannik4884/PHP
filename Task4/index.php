<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
    <title>Безопасность</title>
    <link type="text/css" rel="stylesheet" href="css/materialize.min.css" media="screen,projection"/>
    <link type="text/css" rel="stylesheet" href="css/materialert.css" media="screen,projection"/>
    <link type="text/css" rel="stylesheet" href="css/style.css"/>
</head>
<body>
<div class="container">
    <div class="section">
        <div class="valign-wrapper" style="flex: 1;">
            <div class="container valign" style="max-width: 500px;">
                <form action="code/show_action.php" method="post" accept-charset="utf-8" class="col s12">
                        <?php
                            // show error
                            if(isset($_SESSION['error'])){
                                echo "<div class=\"materialert error\" id=\"message-box\">
                                        <div class=\"material-icons\">error_outline</div>" . $_SESSION['error'] ."</div>";
                                unset($_SESSION['error']);
                            }
                        ?>
                    <div class="row">
                        <div class="col s12">
                            <h5>Поиск законопроекта по полю (первое поле с возможностью SQL-инъекции, второе - без)</h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <label for="law_number">Номер законопроекта</label>
                            <input type="text" name="law_number" id="law_number" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <label for="profile_committee">Профильный комитет</label>
                            <input type="text" name="profile_committee" id="profile_committee" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <button class="btn waves-effect waves-light" style="float: right;" type="submit">Войти<i class="material-icons right">send</i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="js/materialize.min.js"></script>
</body>
</html>