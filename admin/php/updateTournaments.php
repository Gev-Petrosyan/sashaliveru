<?php

require_once('../auth/auth.php');

if (isset($_POST["submit"]) && Auth::check()) {
    // Создаем объект от класса EditTournaments и запускаем алгоритмы

    $EditTournaments = new EditTournaments(
    $_POST['id'],
    $_POST['title'],
    $_POST['about'],
    $_POST['from_date'],
    $_POST['to_date'],
    $_POST['classes'],
    $_POST['subjects'],
    $_POST['auters'],
    $_POST['level'],
    $_POST['document1name'],
    $_POST['document1link'],
    $_POST['document2name'],
    $_POST['document2link'],
    $_POST['document3name'],
    $_POST['document3link']);

    $EditTournaments->start();
}

final class EditTournaments {

    public function __construct(private int $id,
    private string $title, private string $about,
    private string $from_date, private string $to_date,
    private string $classes, private string $subjects,
    private string $auters, private string $level, 

    private string $document1name, private string $document1link,
    private string $document2name, private string $document2link,
    private string $document3name, private string $document3link)
    {
        $this->id = $id;

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

        // Валидации
        if (!$this->checkDB()) {
            $error = "Что то не так, попробуйте по позже!";
        } else if (!$this->validate()) {
            $error = "Заполните все строки!";
        }

        if (is_null($error)) {
            $this->fill();
            $alert = 'Готово!';
            header("location: ../editTournament.php?id={$this->id}&alert={$alert}");
        } else {
            header("location: ../editTournament.php?id={$this->id}&error={$error}");
        }
    }

    private function checkDB(): bool {
        require("../../php/database/connect.php");

        // SQL запрос, смотрим есть ли такой турнир
        $tournaments = mysqli_query($conn, "SELECT title FROM tournaments WHERE id = '{$this->id}'");
        return (mysqli_num_rows($tournaments) == 0) ? false : true;
    }

    private function validate(): bool {
        return ($this->title && $this->about &&
        $this->from_date && $this->classes &&
        $this->subjects && $this->auters &&
        $this->level && $this->document1name &&
        $this->document1link && $this->id)
        ? true
        : false;
    }

    private function fill(): void {
        $user = Auth::user();
        $username = $user["username"];
        require("../../php/database/connect.php");

        // Обновляем данные базы
        
        ($this->to_date) ?
        mysqli_query($conn, "UPDATE tournaments
        SET title = '".$this->title."', about = '".str_replace("'", '"', $this->about)."', from_date = '".$this->from_date."', to_date = '".$this->to_date."', classes = '".$this->classes."', subjects = '".$this->subjects."', auters = '".str_replace("'", '"', $this->auters)."', level = '".$this->level."' WHERE id = '".$this->id."'")
        or die("Query error: " . mysqli_error($conn))
        : mysqli_query($conn, "UPDATE tournaments
        SET title = '".$this->title."', about = '".str_replace("'", '"', $this->about)."', from_date = '".$this->from_date."', to_date = NULL, classes = '".$this->classes."', subjects = '".$this->subjects."', auters = '".str_replace("'", '"', $this->auters)."', level = '".$this->level."' WHERE id = '".$this->id."'")
        or die("Query error: " . mysqli_error($conn));

        $documents = mysqli_query($conn, "SELECT id FROM documents WHERE tournament_id = {$this->id} LIMIT 3")
        or die("Query error: " . mysqli_error($conn));

        $while = 1;
        while ($row = mysqli_fetch_assoc($documents)) {
            if ($while == 1) {
                $conn->query("UPDATE documents SET
                documentName = '$this->document1name', documentLink = '$this->document1link' WHERE id = {$row['id']}");
            } else if ($while == 2) {
                $conn->query("UPDATE documents SET
                documentName = '$this->document2name', documentLink = '$this->document2link' WHERE id = {$row['id']}");
            } else {
                $conn->query("UPDATE documents SET
                documentName = '$this->document3name', documentLink = '$this->document3link' WHERE id = {$row['id']}");
            }

            $while++;
        }

        if (mysqli_num_rows($documents) == 2) {
            mysqli_query($conn, "INSERT INTO `documents`(`id`, `tournament_id`, `documentName`, `documentLink`) VALUES (NULL,'{$this->id}','{$this->document2name}','{$this->document2link}')")
            or die("Query error: " . mysqli_error($conn));
        } else if (mysqli_num_rows($documents) == 3) {
            mysqli_query($conn, "INSERT INTO `documents`(`id`, `tournament_id`, `documentName`, `documentLink`) VALUES (NULL,'{$this->id}','{$this->document3name}','{$this->document3link}')")
            or die("Query error: " . mysqli_error($conn));
        }

    }

}
