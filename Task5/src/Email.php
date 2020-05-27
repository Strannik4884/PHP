<?php
require_once ('PHPMailer/PHPMailer.php');
require_once ('PHPMailer/SMTP.php');
require_once ('PHPMailer/Exception.php');
require_once ('ConfigException.php');

class Email
{
    private const configFile = "../src/config.ini";
    private $login;
    private $password;
    private $email;
    private $username;
    private $host;
    private $secure;
    private $port;
    private $manager_email;
    private $subject;

    // email class construct
    function __construct()
    {
        // check config file
        if (!is_file(self::configFile)) {
            throw (new ConfigException("Can't load config file"));
        }
        // read config file
        $ini_array = parse_ini_file(self::configFile, true);
        // check mandatory variables in config file
        if (!isset($ini_array['email']['login']) || !isset($ini_array['email']['password']) || !isset($ini_array['email']['email']) || !isset($ini_array['email']['username']) || !isset($ini_array['email']['host']) ||
            !isset($ini_array['email']['secure']) || !isset($ini_array['email']['port']) || !isset($ini_array['email']['manager_email']) || !isset($ini_array['email']['subject'])) {
            throw (new ConfigException("Config file corrupted (email section)"));
        }
        // check empty config variables
        if (empty($ini_array['email']['login']) || empty($ini_array['email']['password']) || empty($ini_array['email']['email']) || empty($ini_array['email']['username']) || empty($ini_array['email']['host']) ||
            empty($ini_array['email']['secure']) || empty($ini_array['email']['port']) || empty($ini_array['email']['manager_email']) || empty($ini_array['email']['subject'])) {
            throw (new ConfigException("You must set email config variables"));
        }
        // set properties
        $this->login = $ini_array['email']['login'];
        $this->password = $ini_array['email']['password'];
        $this->email = $ini_array['email']['email'];
        $this->username = $ini_array['email']['username'];
        $this->host = $ini_array['email']['host'];
        $this->secure = $ini_array['email']['secure'];
        $this->port = (int)$ini_array['email']['port'];
        $this->manager_email = $ini_array['email']['manager_email'];
        $this->subject = $ini_array['email']['subject'];
    }

    // send email
    public function send(string $person_name, string $person_email, string $person_phone, string $person_comment)
    {
        // email message
        $message = '
        <html lang="ru">
        <head>
            <title>' . $this->subject . '</title>
            <style type="text/css">
                table {
                    border-collapse: collapse;
                    width: 600px;
                }
                th {
                    text-align: center;
                }
                td {
                    background: #fff;
                    text-align: center;
                }
                th, td {
                    border: 1px solid black;
                    padding: 4px;
                }
            </style>
        </head>
        <body>
        <table>
            <tr>
                <th>ФИО</th><th>Email</th><th>Телефон</th><th>Комментарий</th>
            </tr>
            <tr>
                <td>' . $person_name . '</td><td><a href="mailto:' . $person_email . '">' . $person_email . '</a></td><td>' . $person_phone . '</td><td>' . $person_comment . '</td>
            </tr>
        </table>
        </body>
        </html>
        ';
        // create phpmailer object
        $mail = new PHPMailer\PHPMailer\PHPMailer();
        // configure phpmailer
        $mail->isSMTP();
        $mail->CharSet = "UTF-8";
        $mail->SMTPAuth = true;
        $mail->Host = $this->host;
        $mail->Username = $this->login;
        $mail->Password = $this->password;
        $mail->SMTPSecure = $this->secure;
        $mail->Port = $this->port;
        $mail->setFrom($this->email, $this->username);
        $mail->addAddress($this->manager_email);
        $mail->isHTML(true);
        $mail->Subject = $this->subject;
        $mail->Body = $message;
        // send message by smtp
        return $mail->send();
    }
}