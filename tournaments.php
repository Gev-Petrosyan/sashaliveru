<?php
    require_once('php/database/connect.php');
    // SQL запрос, берем все турниры
    $tournaments = $conn->query("SELECT * FROM tournaments ORDER BY from_date ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <link href='js/fullcalendar/main.css' rel='stylesheet'>
    <link href='css/calendar.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" />
    <title>Home</title>
</head>
<body class="light">

    <header style="margin-bottom:0">
        <div class="navabar">
            <h2><a href="index.php">КАЛЕНДАРЬ ОЛИМПИАД И КОНКУРСОВ</a></h2>
        </div>
    </header>
    <main>
        <div class="footer">
            <table class="table table-borderless">
                <thead>
                    <tr>
                        <th scope="col">ДАТА</th>
                        <th scope="col">НАИМЕНОВАНИЕ</th>
                        <th scope="col">КЛАССЫ</th>
                    </tr>
                </thead>
                <tbody id="dataTbody">
                    <?php while ($row = $tournaments->fetch_assoc()) { ?>
                        <tr>
                            <td>
                                <?php if (is_null($row["to_date"])) { ?>
                                <?php echo date("d.m.y", strtotime($row["from_date"])) ?>
                                <?php } else { ?>
                                    <?php echo date("d.m.y", strtotime($row["from_date"])) . " - " . date("d.m.y", strtotime($row["to_date"])) ?>
                                <?php } ?>
                            </td>
                            <td><a href="tournament.php?id=<?php echo $row["id"] ?>"><?php echo $row["title"] ?></a></td>
                            <td><?php echo $row["classes"] ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </main>

</body>
</html>