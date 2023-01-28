<?php
    require_once('auth/auth.php');

    // Если админ уже входил то сразу заходим в панель
    if (Auth::check()) {
        header("location: home.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/auth.css">
    <title>Login</title>
</head>
<body>
    
    <main>
        <form method="POST" action="auth/login.php">
            <h2>Вход в личный кабинет</h2>
            <input type="text" name="username" placeholder="Логин" required>
            <input type="password" name="password" minlength="8" placeholder="Пароль" required>
            <button type="submit">ВОЙТИ</button>
            <?php if (isset($_GET['error'])) { ?>
                <div class="errors">
                    <p><?php echo $_GET['error'] ?></p>
                </div>
            <?php } ?>
        </form>
    </main>

</body>
</html>