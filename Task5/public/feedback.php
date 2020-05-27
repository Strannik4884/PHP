<?php
    require_once ('../src/Database.php');
    require_once ('../src/Email.php');

    // check post body
    if(isset($_POST['person_name']) and isset($_POST['person_email']) and isset($_POST['person_phone']) and isset($_POST['person_comment'])) {
        $request_date = date("Y-m-d H:i:s");
        $personName = htmlspecialchars($_POST['person_name']);
        $personEmail = $_POST['person_email'];
        $personPhone = $_POST['person_phone'];
        $personComment = htmlspecialchars($_POST['person_comment']);
        $response_date = date("H:i:s d.m.Y", strtotime('+1 hours +30minutes'));
        try {
            // connect to database
            $database = new Database();
            $connection = $database->connect();
            // query string
            $prepared = $connection->prepare("INSERT INTO request (request_date, request_person_name, request_person_email, request_person_phone, request_person_comment) VALUES
                                            (:request_date, :person_name, :person_email, :person_phone, :person_comment)");
            $prepared->bindParam(':request_date', $request_date);
            $prepared->bindParam(':person_name', $personName);
            $prepared->bindParam(':person_email', $personEmail);
            $prepared->bindParam(':person_phone', $personPhone);
            $prepared->bindParam(':person_comment', $personComment);
            // insert into database
            if ($prepared->execute()) {
                // get last request id
                $last_request_id = $connection->lastInsertId('request_request_id_seq');
                $email = new Email();
                // send mail
                if ($email->send($personName, $personEmail, $personPhone, $personComment)) {
                    echo json_encode(array('successful' => array($personName, $personEmail, $personPhone, $personComment, $response_date)));
                }
                // if can't send email
                else {
                    $prepared = $connection->prepare("DELETE FROM request WHERE request_id = :last_request_id");
                    $prepared->bindParam(':last_request_id', $last_request_id);
                    $prepared->execute();
                    echo json_encode(array('error' => 'Невозможно отправить письмо менеджеру - попробуйте отправить заявку позже!'));
                }
            }
            // error when inserting
            else {
                echo json_encode(array('error' => 'Ошибка при записи в базу данных - попробуйте отправить заявку позже!'));
            }
        } catch (PDOException $exception) {
            $message = $exception->getMessage();
            if (strpos($message, 'Raise exception: 7 ERROR: ') === false) {
                echo json_encode(array('error' => $exception->getMessage()));
            }
            // if request date constraint exception
            else {
                // get time left
                preg_match('/(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})/', $message, $matches);
                echo json_encode(array('warning' => $matches[0]));
            }
        } catch (ConfigException $exception) {
            echo json_encode(array('error' => $exception->getMessage()));
        } catch (Exception $exception) {
            echo json_encode(array('error' => $exception->getMessage()));
        }
    }
    else{
        header('Location: /');
    }