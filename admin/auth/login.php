<?php

session_start();

if (isset($_POST['username'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Создаем объект от Login Логин и запускаем алгоритмы
    $login = new Login($username, $password);
    $login->checking();
}

final class Login {

    public function __construct(private string $username, private string $password) {
        $this->username = $username;
        $this->password = $password;
    }

    public function checking(): void {

        // validations
        if ($this->emptyInput() === false) {
            $error = "Заполните все строки!";
        } else if ($this->invalidUsername() === false) {
            $error = "В имени пользователя использовался запрещенный знак!";
        } else if ($this->invalidPassword() === false) {
            $error = "В пароле использован запрещенный знак!";
        } else if ($this->checkingDb() === false) {
            $error = "Имя пользователя или пароль неверны!";
        }  else {
            $error = null;
            $_SESSION["user"] = [
                "username" => $this->username
            ];
        }

        // Если есть error по валидациям то вернемся обратно с error-ом
        if (is_null($error)) {
            header("location: ../../admin/");
        } else {
            header("location: ../../admin/?error=$error");
            exit();
        }

    }

    private function emptyInput(): bool {
        $result;
        if (empty($this->username) || empty($this->password)) {
            $result = false;
        }
        else {
            $result = true;
        }
        return $result;
    }

    private function invalidUsername(): bool {
        $result;
        if (!preg_match("/^[a-zA-Z0-9]*$/", $this->username)) {
            $result = false;
        }
        else {
            $result = true;
        }
        return $result;
    }

    private function invalidPassword(): bool {
        $result;
        if (!preg_match("/^[a-zA-Z0-9]*$/", $this->password)) {
            $result = false;
        }
        else {
            $result = true;
        }
        return $result;
    }

    private function checkingDb(): bool {
        $result;
        require_once("../../php/database/connect.php");

        // Ищем админа по этим данным
        $checking = $conn->query("SELECT * FROM admins WHERE username='$this->username' AND password='$this->password' LIMIT 1");

        if ($checking->num_rows === 0) {
            $result = false;
        }
        else {
            $result = true;
        }
        return $result;
    }

}
