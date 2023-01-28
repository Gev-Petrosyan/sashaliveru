<?php
    require_once('auth/auth.php');
    if (!Auth::check()) {
        header("location: index.php");
    }
    $user = Auth::user();
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
                            <a class="nav-link active" aria-current="page" href="#">Главная</a>
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
                <form class="row g-3 needs-validation" method="POST" action="php/newTournaments.php">
                    <div class="col-md-7">
                        <label for="validationCustom01" class="form-label">Название турнира</label>
                        <input type="text" class="form-control" name="title" id="validationCustom01" maxlength="255" required>
                        <div class="valid-feedback">
                        Looks good!
                        </div>
                    </div>
                    <div class="col-md-7">
                        <label for="validationCustom02" class="form-label">Дата начала</label>
                        <input type="date" class="form-control" name="from_date" id="validationCustom02" required>
                        <div class="valid-feedback">
                        Looks good!
                        </div>
                    </div>
                    <div class="col-md-7">
                        <label for="validationCustom03" class="form-label">Дата окончания (необязательно)</label>
                        <input type="date" class="form-control" name="to_date" id="validationCustom03">
                        <div class="valid-feedback">
                        Looks good!
                        </div>
                    </div>
                    <div class="col-md-7">
                        <label for="validationCustom04" class="form-label">Для каких классов</label>
                        <input type="text" class="form-control" name="classes" id="validationCustom04" maxlength="255" placeholder="7 - 10" required>
                        <div class="valid-feedback">
                        Looks good!
                        </div>
                    </div>
                    <div class="col-md-7">
                        <label for="validationCustom03" class="form-label">Предметы</label>
                        <div class="checks">
                            <div class="form-check">
                                <p>Математика</p>
                                <input class="form-check-input" type="checkbox" name="subject0" value="Математика" id="flexCheckChecked">
                            </div>
                            <div class="form-check">
                                <p>Физика</p>
                                <input class="form-check-input" type="checkbox" name="subject1" value="Физика" id="flexCheckChecked">
                            </div>
                            <div class="form-check">
                                <p>Химия</p>
                                <input class="form-check-input" type="checkbox" name="subject2" value="Химия" id="flexCheckChecked">
                            </div>
                            <div class="form-check">
                                <p>Лингвистика</p>
                                <input class="form-check-input" type="checkbox" name="subject3" value="Лингвистика" id="flexCheckChecked">
                            </div>
                            <div class="form-check">
                                <p>Астрономия</p>
                                <input class="form-check-input" type="checkbox" name="subject4" value="Астрономия" id="flexCheckChecked">
                            </div>
                            <div class="form-check">
                                <p>Биология</p>
                                <input class="form-check-input" type="checkbox" name="subject5" value="Биология" id="flexCheckChecked">
                            </div>
                            <div class="form-check">
                                <p>История</p>
                                <input class="form-check-input" type="checkbox" name="subject6" value="История" id="flexCheckChecked">
                            </div>
                            <div class="form-check">
                                <p>Литература</p>
                                <input class="form-check-input" type="checkbox" name="subject7" value="Литература" id="flexCheckChecked">
                            </div>
                            <div class="form-check">
                                <p>Русский язык</p>
                                <input class="form-check-input" type="checkbox" name="subject8" value="Русский язык" id="flexCheckChecked">
                            </div>
                            <div class="form-check">
                                <p>География</p>
                                <input class="form-check-input" type="checkbox" name="subject9" value="География" id="flexCheckChecked">
                            </div>
                            <div class="form-check">
                                <p>Информатика</p>
                                <input class="form-check-input" type="checkbox" name="subject10" value="Информатика" id="flexCheckChecked">
                            </div>
                            <div class="form-check">
                                <p>Английский язык</p>
                                <input class="form-check-input" type="checkbox" name="subject11" value="Английский язык" id="flexCheckChecked">
                            </div>
                            <div class="form-check">
                                <p>Иностранные языки</p>
                                <input class="form-check-input" type="checkbox" name="subject12" value="Иностранные языки" id="flexCheckChecked">
                            </div>
                            <div class="form-check">
                                <p>Обществознание</p>
                                <input class="form-check-input" type="checkbox" name="subject13" value="Обществознание" id="flexCheckChecked">
                            </div>
                            <div class="form-check">
                                <p>Право</p>
                                <input class="form-check-input" type="checkbox" name="subject" value="Право" id="flexCheckChecked">
                            </div>
                            <div class="form-check">
                                <p>Физическая культура</p>
                                <input class="form-check-input" type="checkbox" name="subject" value="Физическая культура" id="flexCheckChecked">
                            </div>
                            <div class="form-check">
                                <p>Проектные работы</p>
                                <input class="form-check-input" type="checkbox" name="subject" value="Проектные работы" id="flexCheckChecked">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7">
                            <label for="validationCustom01" class="form-label">Уровень</label>
                            <input type="text" class="form-control" name="level" id="validationCustom01" maxlength="255" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-7">
                            <label for="validationCustom01" class="form-label">Документ 1, имя</label>
                            <input type="text" class="form-control" name="document1name" id="validationCustom01" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-7">
                            <label for="validationCustom01" class="form-label">Документ 1, ссылка</label>
                            <input type="text" class="form-control" name="document1link" id="validationCustom01">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-7">
                            <label for="validationCustom01" class="form-label">Документ 2, имя (необязательно)</label>
                            <input type="text" class="form-control" name="document2name" id="validationCustom01">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-7">
                            <label for="validationCustom01" class="form-label">Документ 2, ссылка (необязательно)</label>
                            <input type="text" class="form-control" name="document2link" id="validationCustom01">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-7">
                            <label for="validationCustom01" class="form-label">Документ 3, имя (необязательно)</label>
                            <input type="text" class="form-control" name="document3name" id="validationCustom01">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-7">
                            <label for="validationCustom01" class="form-label">Документ 3, ссылка (необязательно)</label>
                            <input type="text" class="form-control" name="document3link" id="validationCustom01">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="form-floating col-md-7 mt-3">
                            <textarea class="form-control" placeholder="О турнире" name="about" id="floatingTextarea2" style="height: 150px" maxlength="1000" required></textarea>
                            <label for="floatingTextarea2">О турнире</label>
                        </div>
                        <div class="form-floating col-md-7 mt-3">
                            <textarea class="form-control" placeholder="Организатор" name="auters" id="floatingTextarea3" style="height: 150px" maxlength="1000" required></textarea>
                            <label for="floatingTextarea3">Организатор</label>
                        </div>
                    <div class="col-12">
                        <button class="btn btn-primary" name="submit" type="submit">Добавить турнир</button>
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