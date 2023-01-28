<?php

if (isset($_POST["submit"])) {
    $email = $_POST["email"];
    $tournament_id = $_POST["tournament_id"];

    // Создаем объект от класса AddNewNotification
    $addNewNotification = new AddNewNotification($email, $tournament_id);
    // Запуск алгоритма
    $addNewNotification->start();
}


final class AddNewNotification {

    public function __construct(private string $email, private int|string $tournament_id) {
        $this->email = $email;
        $this->tournament_id = $tournament_id;
    }

    public function start(): void {
        $alert = null;
        
        // Валидации
        if (!$this->validate()) {
            $alert = "Заполните все строки!";
        } else if (!$this->emailValidate()) {
            $alert = "Неверный формат электронной почты!";
        } else if (!$this->checkLengthNotification()) {
            $alert = "Лимит напоминание превышен или напоминание у этого почты уже включен!";
        } else {
            $this->fill();
            $alert = "s";
        }

        // Вернемся обратно
        header("location: ../../tournament.php?id={$this->tournament_id}&alert={$alert}");
    }

    private function validate(): bool {
        if ($this->email || $this->tournament_id) {
            return true;
        }
        return false;
    }

    private function emailValidate(): bool {
        // if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        //     return true;
        // }
        // return false;
        return true;
    }

    private function checkLengthNotification(): bool {
        require("../database/connect.php");

        // Проверим количество напоминаний
        $data = $conn->query("SELECT * FROM notifications WHERE email = '$this->email'");
        $data_rows = mysqli_num_rows($data);
        if ($data_rows > 10) return false;

        // Проверяем чтобы не было повторных напоминаний
        $data2 = $conn->query("SELECT * FROM notifications WHERE tournament_id = '$this->tournament_id' AND email = '$this->email'");
        $data2_rows = mysqli_num_rows($data2);
        if ($data2_rows > 0) return false;

        return true;
    }

    private function fill(): void {
        require("../database/connect.php");
        
        // Все, добавляем напоминание в базу
        $date_start_object = $conn->query("SELECT from_date FROm tournaments WHERE id = $this->tournament_id");
        $date_start_assoc = $date_start_object->fetch_assoc();
        $from_date = $date_start_assoc["from_date"];

        $conn->query("INSERT INTO `notifications`(`id`, `tournament_id`, `email`, `date_start`) VALUES (NULL,'$this->tournament_id','$this->email', '$from_date')");
    }

}

