<?php
    require_once('auth/auth.php');
    require_once('../php/database/connect.php');

    // Проверяем Auth и id
    if ((!Auth::check()) || empty($_GET["id"])) header("location: tournaments.php");

    // SQL запрос, Берем данные турнира
    $id = $_GET["id"];
    $tournaments = $conn->query("SELECT * FROM tournaments WHERE id = {$id}");
    if (mysqli_num_rows($tournaments) === 0) header("location: tournaments.php");

    // SQL запрос, Так же documents турнира
    $documents = $conn->query("SELECT * FROM documents WHERE tournament_id = {$id} LIMIT 3");

    $user = Auth::user();
    $data = mysqli_fetch_assoc($tournaments);
    $while = 1;

    $length = mysqli_num_rows($documents);
    $whileLength = 3 - $length;
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
                            <a class="nav-link active" aria-current="page" href="tournaments.php">Список Турниров</a>
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
            <div class="row bg-white">
                <form class="row g-3 needs-validation" method="POST" action="php/updateTournaments.php">
                    <input type="hidden" name="id" value="<?php echo $id ?>">
                    <div class="col-md-7">
                        <label for="validationCustom01" class="form-label">Название турнира</label>
                        <input type="text" class="form-control" name="title" id="validationCustom01" value="<?php echo $data["title"] ?>" maxlength="255" required>
                        <div class="valid-feedback">
                        Looks good!
                        </div>
                    </div>
                    <div class="col-md-7">
                        <label for="validationCustom02" class="form-label">Дата начала</label>
                        <input type="date" class="form-control" name="from_date" id="validationCustom02" value="<?php echo $data["from_date"] ?>" required>
                        <div class="valid-feedback">
                        Looks good!
                        </div>
                    </div>
                    <div class="col-md-7">
                        <label for="validationCustom03" class="form-label">Дата окончания (необязательно)</label>
                        <input type="date" class="form-control" name="to_date" id="validationCustom03" value="<?php echo $data["to_date"] ?>">
                        <div class="valid-feedback">
                        Looks good!
                        </div>
                    </div>
                    <div class="col-md-7">
                        <label for="validationCustom04" class="form-label">Для каких классов</label>
                        <input type="text" class="form-control" name="classes" id="validationCustom04" maxlength="255" value="<?php echo $data["classes"] ?>" placeholder="7 - 10" required>
                        <div class="valid-feedback">
                        Looks good!
                        </div>
                    </div>
                    <div class="col-md-7">
                        <label for="validationCustom05" class="form-label">Предметы</label>
                        <input type="text" class="form-control" name="subjects" id="validationCustom04" maxlength="255" value="<?php echo $data["subjects"] ?>" placeholder="Предметы" required>
                        <div class="valid-feedback">
                        Looks good!
                        </div>
                    </div>
                    <div class="col-md-7">
                        <label for="validationCustom01" class="form-label">Уровень</label>
                        <input type="text" class="form-control" name="level" id="validationCustom01" value="<?php echo $data["level"] ?>" maxlength="255" required>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                    </div>
                    <?php while ($doc = mysqli_fetch_assoc($documents)) { ?>
                        <div class="col-md-7">
                            <label for="validationCustom<?php echo $while ?>" class="form-label">Документ <?php echo $while ?>, имя</label>
                            <input type="text" class="form-control" name="document<?php echo $while ?>name" value="<?php echo $doc["documentName"] ?>" id="validationCustom<?php echo $while ?>" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-7">
                            <label for="validationCustom<?php echo $while ?>" class="form-label">Документ <?php echo $while ?>, ссылка</label>
                            <input type="text" class="form-control" name="document<?php echo $while ?>link" value="<?php echo $doc["documentLink"] ?>" id="validationCustom<?php echo $while ?>" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <?php $while++ ?>
                    <?php } ?>
                    <?php for ($i = 1; $i <= $whileLength; $i++) { ?>
                        <div class="col-md-7">
                            <label for="validationCustom<?php echo $while ?>" class="form-label">Документ <?php echo $while ?>, имя</label>
                            <input type="text" class="form-control" name="document<?php echo $while ?>name" id="validationCustom<?php echo $while ?>">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-7">
                            <label for="validationCustom<?php echo $while ?>" class="form-label">Документ <?php echo $while ?>, ссылка</label>
                            <input type="text" class="form-control" name="document<?php echo $while ?>link" id="validationCustom<?php echo $while ?>">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <?php $while++ ?>
                    <?php } ?>
                    <div class="form-floating col-md-7 mt-3">
                        <textarea class="form-control" placeholder="О турнире" name="about" id="floatingTextarea2" style="height: 150px" maxlength="1000" required><?php echo $data["about"] ?></textarea>
                        <label for="floatingTextarea2">О турнире</label>
                    </div>
                    <div class="form-floating col-md-7 mt-3">
                        <textarea class="form-control" placeholder="Организатор" name="auters" id="floatingTextarea3" style="height: 150px" maxlength="1000" required><?php echo $data["auters"] ?></textarea>
                        <label for="floatingTextarea3">Организатор</label>
                    </div>
                    <div class="col-12">
                        <button class="btn btn-primary" name="submit" type="submit">Менять</button>
                    </div>
                    <?php if (isset($_GET['error'])) { ?>
                        <div class="errors">
                            <p><?php echo $_GET['error'] ?></p>
                        </div>
                    <?php } else if (isset($_GET['alert'])) { ?>
                        <div class="errors">
                            <p style="color:green"><?php echo $_GET['alert'] ?></p>
                        </div>
                    <?php } ?>
                </form>
            </div>
        </div>
    </main>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>
</html>