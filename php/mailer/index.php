<?php

// PHP mailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'phpmailer/Exception.php';
require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';

require_once("../patterns/singleton.php");
require("../database/connect.php");

// Send класс отвечает за отправку
final class Send extends Singleton {

    public function __construct(private object $notifications) {
        $this->notifications = $notifications;
    }

    public function send(): void {
        try {
            $mail = new PHPMailer(true);
            // Вызов методов
            $this->setting($mail);
            $this->sendMail($mail);
            $mail->send();
            require("../database/connect.php");
            $notifications = $conn->query("DELETE FROM `notifications` WHERE date_start <= DATE_ADD(CURDATE(), INTERVAL +4 DAY) AND
            date_start >= DATE_ADD(CURDATE(), INTERVAL +0 DAY)");
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

    private function setting($mail): void {
        // Настройка mailer
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;
        $mail->isSMTP();
        $mail->Host = $this->email_host;
        $mail->SMTPAuth = true;
        $mail->Username = $this->email_username;
        $mail->Password = $this->email_password;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = $this->email_port;
    }

    private function sendMail($mail): void {
        // отправка
        $mail->setFrom($this->email_username, 'Mailer');
        $mail->CharSet  = 'UTF-8';
        $mail->setLanguage('ru', 'phpmailer/language/phpmailer.lang-ru.php');
        while ($row = $this->notifications->fetch_assoc()) {
            if (filter_var($row["email"], FILTER_VALIDATE_EMAIL)) {
                $mail->addAddress($row["email"]);
                $mail->isHTML(true);
                $date = date("d.m.y", strtotime($row["date_start"]));
                $mail->Subject = $this->website . " напоменение";
                $mail->Body = "
                    <h2>Здравствуйте.</h2>
                    <p style='font-size:16px'>Через несколько дней - {$date} начнётся Всероссийская олимпиада школьников</p>
                    <p style='font-size:16px'>Необходимую информацию можете посмотреть тут:</p>
                    <p style='font-size:16px'>{$this->link}tournament.php?id={$row["tournament_id"]}</p>
                ";
            }
        }
    }

}

// Забераем из таблицы notifications мейли
// echo 'Будут отправлены напоминание их!';
$notifications = $conn->query("SELECT * FROM `notifications` WHERE date_start <= DATE_ADD(CURDATE(), INTERVAL +4 DAY) AND
date_start >= DATE_ADD(CURDATE(), INTERVAL +0 DAY)");

$Send = new Send($notifications);
$Send->send();

