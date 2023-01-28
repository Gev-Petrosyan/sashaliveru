<?php
    require_once('auth/auth.php');
    if (!Auth::check()) {
        header("location: index.php");
    }
    $user = Auth::user();
    
    // SQL запрос, берем все турниры
    require_once('../php/database/connect.php');
    $tournaments = $conn->query("SELECT * FROM tournaments");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/admin.css">
    <title>Admin Panel</title>
</head>
<body>

    <header>
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <a class="navbar-brand" href="#"><?php echo $user['username'] ?></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="home.php">Главная</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">Список Турниров</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="auth/logout.php">Выйти</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <main>
        <div class="container">
            <div class="row tournaments-list">
                <div class="col-md-10">
                <table class="table table-borderless">
                    <thead>
                        <tr>
                            <th scope="col">ДАТА</th>
                            <th scope="col">НАИМЕНОВАНИЕ</th>
                            <th scope="col">КЛАССЫ</th>
                            <th scope="col">ДЕЙСТВИЕ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $tournaments->fetch_assoc()) { ?>
                            <tr>
                                <td>
                                    <?php if (is_null($row["to_date"])) { ?>
                                        <?php echo $row["from_date"] ?>
                                    <?php } else { ?>
                                        <?php echo $row["from_date"] . " - " . $row["to_date"] ?>
                                    <?php } ?>
                                </td>
                                <td><?php echo $row["title"] ?></td>
                                <td><?php echo $row["classes"] ?></td>
                                <td>
                                    <a class="btn btn-success" href="editTournament.php?id=<?php echo $row["id"] ?>">Менять</a>
                                    <a class="btn btn-danger" href="php/deleteTournament.php?id=<?php echo $row["id"] ?>">Удалить</a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>
</html>