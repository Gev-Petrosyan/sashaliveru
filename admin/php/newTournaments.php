<?php

require_once('../auth/auth.php');

if (isset($_POST["submit"]) && Auth::check()) {
    $subjects = '';
    for ($i = 0; $i <= 6; $i++) { 
        if (isset($_POST['subject' . $i])) $subjects .= $_POST['subject' . $i] . '; ';
    }

    // Создаем объект от класса NewTournaments и запускаем алгоритмы
    $newTournaments = new NewTournaments(
    $_POST['title'],
    $_POST['about'],
    $_POST['from_date'],
    $_POST['to_date'],
    $_POST['classes'],
    $subjects,
    $_POST['auters'],
    $_POST['level'],
    $_POST['document1name'],
    $_POST['document1link'],
    $_POST['document2name'],
    $_POST['document2link'],
    $_POST['document3name'],
    $_POST['document3link']);
    $newTournaments->start();
}

final class NewTournaments {

    public function __construct(private string $title,
    private string $about, private string $from_date,
    private string $to_date, private string $classes,
    private string $subjects, private string $auters,
    private string $level, 

    private string $document1name, private string $document1link,
    private null|string $document2name, private null|string $document2link,
    private null|string $document3name, private null|string $document3link,)
    {
        $this->title = $title;
        $this->about = $about;
        $this->from_date = $from_date;
        $this->to_date = $to_date;
        $this->classes = $classes;
        $this->subjects = $subjects;
        $this->auters = $auters;
        $this->level = $level;

        $this->document1name = $document1name;
        $this->document2name = $document2name;
        $this->document3name = $document3name;

        $this->document1link = $document1link;
        $this->document2link = $document2link;
        $this->document3link = $document3link;
    }

    public function start(): void {
        $error = null;

        // Валидация
        if (!$this->validate()) {
            $error = "Заполните все строки!";
        }

        if (is_null($error)) {
            $this->fill();
            $alert = 'Новый турнир готов!';
            header("location: ../home.php?alert={$alert}");
        } else {
            header("location: ../home.php?error={$error}");
        }
    }

    private function validate(): bool {
        return ($this->title && $this->about &&
        $this->from_date && $this->classes &&
        $this->subjects && $this->auters &&
        $this->level && $this->document1name &&
        $this->document1link)
        ? true
        : false;
    }

    private function fill(): void {
        $user = Auth::user();
        $username = $user["username"];
        require_once("../../php/database/connect.php");

        // Добавляем данные в базу

        $about = str_replace("'", '"', $this->about);
        $auters = str_replace("'", '"', $this->auters);
        $to_date = ($this->to_date) ? $this->to_date : NULL;

        (is_string($to_date)) ?
        $request = $conn->query("INSERT INTO `tournaments`(`id`, `from_admin`, `title`, `about`, `from_date`, `to_date`, `classes`, `subjects`, `auters`, `level`) 
        VALUES (NULL,'$username','$this->title','$about','$this->from_date', '$to_date','$this->classes','$this->subjects','$auters','$this->level')")
        : $request = $conn->query("INSERT INTO `tournaments`(`id`, `from_admin`, `title`, `about`, `from_date`, `to_date`, `classes`, `subjects`, `auters`, `level`) 
        VALUES (NULL,'$username','$this->title','$about','$this->from_date', NULL,'$this->classes','$this->subjects','$auters','$this->level')");

        $request2 = $conn->query("SELECT max(id) as id FROM tournaments");
        $id = $request2->fetch_assoc();

        if ($this->document1name && $this->document1link) {
            $request3 = $conn->query("INSERT INTO `documents`(`id`, `tournament_id`, `documentName`, `documentLink`) VALUES (NULL,'{$id["id"]}','{$this->document1name}','{$this->document1link}')");  
        }

        if ($this->document2name && $this->document2link) {
            $request4 = $conn->query("INSERT INTO `documents`(`id`, `tournament_id`, `documentName`, `documentLink`) VALUES (NULL,'{$id["id"]}','{$this->document2name}','{$this->document2link}')");  
        }

        if ($this->document3name && $this->document3link) {
            $request5 = $conn->query("INSERT INTO `documents`(`id`, `tournament_id`, `documentName`, `documentLink`) VALUES (NULL,'{$id["id"]}','{$this->document3name}','{$this->document3link}')");  
        }

    }

}
