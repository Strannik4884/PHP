<!DOCTYPE html>
<html lang="ru">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
    <title>Липецкая обсерватория</title>
    <!-- Fonts -->
    <link href="fonts/Mazzard_M_Light/MazzardSoftM-Light.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="images/favicon.png"/>
    <!-- Styles -->
    <link type="text/css" rel="stylesheet" href="css/materialize.min.css" media="screen,projection"/>
    <link type="text/css" rel="stylesheet" href="css/materialert.css" media="screen,projection"/>
    <link type="text/css" rel="stylesheet" href="css/style.css"/>
</head>
<body>
    <!-- Navigation -->
    <nav class="transparent" style="box-shadow: none;">
        <div class="nav-wrapper" role="navigation">
            <div class="container">
                <!-- Main logo -->
                <a href="/" class="brand-logo center-align"><span class="logo-text">Липецкая обсерватория</span></a>
                <!-- Main menu -->
                <ul class="right hide-on-med-and-down">
                    <li><a class="nav-text" href="#about">О нас</a></li>
                    <li><a class="nav-text" href="#feedback">Обратная связь</a></li>
                </ul>
                <!-- Mobile hamburger menu icon -->
                <a href="#" data-target="nav-mobile" class="sidenav-trigger"><i class="material-icons">menu</i></a>
            </div>
        </div>
    </nav>
    <!-- Mobile hamburger menu -->
    <ul id="nav-mobile" class="sidenav">
        <li><a href="/">Липецкая обсерватория</a></li>
        <li><a href="#about">О нас</a></li>
        <li><a href="#feedback">Обратная связь</a></li>
    </ul>
<main>
    <!-- About section -->
    <a name="about"></a>
    <div class="container">
        <div class="section" style="padding-top: 50px">
            <div class="valign-wrapper" style="flex: 1;">
                <span class="about-text">
                    Добро пожаловать на сайт Липецкой обсерватории! Хотите погрузиться в незабываемый мир Космоса? Отправиться в далёкое путешествие по необъятной Вселенной? Тогда Вы там, где надо! Скорее воспользуйтесь формой для связи с нашими лучшими менеджерами!
                </span>
            </div>
        </div>
    </div>
    <!-- Feedback section -->
    <div class="container">
        <div class="section">
            <div class="valign-wrapper" style="flex: 1;">
                <div class="container valign" style="max-width: 500px;">
                    <a name="feedback"></a>
                    <!-- Feedback form -->
                    <form class="col s12" id="feedback_form">
                        <div class="row">
                            <div class="col s12 white-text center-align">
                                <h5>Форма обратной связи</h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12 white-text">
                                <label for="person_name" class="white-text">ФИО</label>
                                <input type="text" name="person_name" id="person_name" class="white-text" maxlength="200" required="" aria-required="true"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <label for="person_email" class="white-text">Почта</label>
                                <input type="email" name="person_email" id="person_email" class="white-text" maxlength="256" required="" aria-required="true"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <label for="person_phone" class="white-text">Номер телефона</label>
                                <input type="tel" name="person_phone" id="person_phone" class="white-text" maxlength="16" required="" aria-required="true"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <textarea name="person_comment" id="person_comment" class="materialize-textarea white-text" maxlength="280" data-length="280" required="" aria-required="true"></textarea>
                                <label for="person_comment" class="white-text">Комментарий</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <button class="btn blue darken-1 waves-effect waves-light" type="submit" style="float: right;">Отправить<i class="material-icons right">send</i></button>
                            </div>
                        </div>
                    </form>
                    <!-- Feedback response form -->
                    <form class="col s12" id="feedback_response" style="display: none">
                        <div class="row">
                            <div class="col s12 white-text center-align">
                                <h5>Заявка успешно отправлена!</h5>
                                <h6 id="response_date"></h6>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field inline col s12 white-text">
                                <label for="request_name" class="active white-text">ФИО</label>
                                <input type="text" name="person_name" id="request_name" class="white-text" maxlength="200" placeholder="" readonly/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field inline col s12">
                                <label for="request_email" class="active white-text">Почта</label>
                                <input type="email" name="person_email" id="request_email" class="white-text" maxlength="256" placeholder="" readonly/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field inline col s12">
                                <label for="request_phone" class="active white-text">Номер телефона</label>
                                <input type="tel" name="person_phone" id="request_phone" class="white-text" maxlength="16" placeholder="" readonly/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field inline col s12">
                                <label for="request_comment" class="active white-text">Комментарий</label>
                                <textarea name="person_comment" id="request_comment" class="materialize-textarea white-text" placeholder="" maxlength="280" data-length="280" readonly></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <button class="btn blue darken-1 waves-effect waves-light" type="submit" style="float: left;">Назад<i class="material-icons left">arrow_back</i></button>
                            </div>
                        </div>
                    </form>
                    <!-- Feedback warning form -->
                    <form class="col s12" id="warning_form" style="height: 590px; display: none">
                        <div class="row">
                            <div class="col s12 white-text center-align">
                                <h5>Повторную заявку можно отправить через <span id="new_request_date"></span></h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <button class="btn blue darken-1 waves-effect waves-light" type="submit" style="float: left;">Назад<i class="material-icons left">arrow_back</i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
<!-- Footer -->
<footer class="page-footer transparent">
    <div class="container">
        <div class="footer-copyright transparent">
            <!-- Copyright -->
            <div class="row">
                <div class="col s12 center-align">
                    <span class="copyright-text">© 2020 Design by <a class="footer-link" href="https://vk.com/id152191562">Alex Parkhomov</a></span>
                </div>
            </div>
        </div>
    </div>
</footer>
<script type="text/javascript" src="js/jquery-3.5.1.min.js"></script>
<script type="text/javascript" src="js/jquery.validate.min.js"></script>
<script type="text/javascript" src="js/materialize.min.js"></script>
<script type="text/javascript" src="js/main.js"></script>
</body>
</html>