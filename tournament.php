<?php
    if (empty($_GET["id"]))
        header("location: index.php");

    require_once("php/database/connect.php");
    $id = $_GET["id"];

    // SQL Запрос к MySQL базу, берем данные турнира
    $tournament = $conn->query("SELECT * FROM tournaments
    WHERE id = $id");
    if (!mysqli_num_rows($tournament)) {
        header("location: index.php");
    }

    // SQL Запрос к MySQL базу, берем документы турнира
    $documents = $conn->query("SELECT * FROM documents
    WHERE tournament_id = $id LIMIT 3");
    $tournamentRow = $tournament->fetch_assoc();
    $auters = '';
    
    for ($i = 0; $i < strlen($tournamentRow["auters"]); $i++) { 
        ($tournamentRow["auters"][$i] != ';') ?
        $auters .= $tournamentRow["auters"][$i] :
        $auters .= '<br />';
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="css/tournament.css">
    <title><?php echo $tournamentRow["title"] ?></title>
</head>
<body>

    <header>
        <div class="navabar">
            <h2><a href="index.php">КАЛЕНДАРЬ ОЛИМПИАД И КОНКУРСОВ</a></h2>
        </div>
    </header>
    <main>
        <div class="header">
            <a href="index.php">НАЗАД</a>
            <?php if (isset($_GET["alert"]) && $_GET["alert"] == "s") { ?>
                <button type="button" style="background:#1FAA71;cursor:initial">НАПОМИНАНИЕ ВКЛЮЧЕН</button>
            <?php } else { ?>
                <button type="button" data-bs-toggle="modal" data-bs-target="#exampleModal">ПОЛУЧИТЬ НАПОМИНАНИЕ</button>
            <?php } ?>
        </div>
        <h1><?php echo $tournamentRow["title"] ?></h1>
        <div class="about">
            <p><?php echo $tournamentRow["about"] ?></p>
        </div>
        <div class="info">
            <p>ДАТА ПРОВЕДЕНИЯ: <?php if (is_null($tournamentRow["to_date"])) { ?>
                                <?php echo date("d.m.y", strtotime($tournamentRow["from_date"])) ?>
                                <?php } else { ?>
                                    <?php echo date("d.m.y", strtotime($tournamentRow["from_date"])) . " - " . date("d.m.y", strtotime($tournamentRow["to_date"])) ?>
                                <?php } ?></p>
            <p>КЛАССЫ: <?php echo $tournamentRow["classes"] ?></p>
        </div>
        <div class="subjects">
            <h3>ПРЕДМЕТЫ</h3>
            <p><?php echo $tournamentRow["subjects"] ?></p>
        </div>
        <div class="info-blocks">
            <div class="part-one">
                <div class="item">
                    <h4>ОРГАНИЗАТОРЫ</h4>
                    <p><?php echo $auters ?></p>
                </div>
            </div>
            <div class="part-two">
                <div class="item1">
                    <h4>УРОВЕНЬ</h4>
                    <p><?php echo $tournamentRow["level"] ?></p>
                </div>
                <div class="item2">
                    <h4>ДОКУМЕНТЫ</h4>
                    <?php while ($row = $documents->fetch_assoc()) { ?>
                        <a href="<?php echo $row["documentLink"] ?>"><?php echo $row["documentName"] ?></a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </main>


    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Получить напоминание</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="php/mailer/addNewNotification.php">
                <input type="hidden" name="tournament_id" value="<?php echo $tournamentRow["id"] ?>" required>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label">Email:</label>
                        <input type="email" class="form-control" name="email" id="email" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                    <button type="submit" name="submit" class="btn btn-primary">Получить напоминание</button>
                </div>
            </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <script>
        
        let dateForYear = new Date();
        let year = dateForYear.getFullYear();
        let year2 = parseInt(year) + 1;
        document.querySelector("#navabar_year").innerHTML = year + "-" + year2;

        <?php if (isset($_GET["alert"])) { ?>
            let alertEmail = '<?= $_GET["alert"] ?>';
            if (alertEmail != "s") {
                alert(alertEmail);
            }
        <?php } ?>
        
    </script>
</body>
</html>