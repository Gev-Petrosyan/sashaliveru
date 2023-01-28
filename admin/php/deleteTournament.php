<?php

require_once('../auth/auth.php');

if (isset($_GET["id"]) && Auth::check()) {
    $deleteTournaments = new DeleteTournaments($_GET["id"]);
    $deleteTournaments->start();
}

final class DeleteTournaments {

    public function __construct(private int $id)
    {
        $this->id = $id;
    }

    public function start(): void {
        $this->delete();
        header("location: ../tournaments.php");
    }

    public function validate(): bool {
        return ($this->id) ? true : false;
    }

    public function delete(): void {
        require_once("../../php/database/connect.php");
        // Deleting tournaments, documents, notifications
        $conn->query("DELETE FROM tournaments WHERE id = '{$this->id}'");
        $conn->query("DELETE FROM documents WHERE tournament_id = '{$this->id}'");
        $conn->query("DELETE FROM notifications WHERE tournament_id = '{$this->id}'");
    }

}
