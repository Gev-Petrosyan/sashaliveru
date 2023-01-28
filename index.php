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

    <header>
        <div class="navabar">
            <h2><a href="index.php">КАЛЕНДАРЬ ОЛИМПИАД И КОНКУРСОВ</a></h2>
            <div class="nav">
                <div class="tournamentsNav">
                    <a href="tournaments.php">Полный список</a>
                </div>
            </div>
        </div>
    </header>
    <main>
    <div class="calentar-block">
        <div id='calendar'></div>
    </div>
        <div class="footer">
            <div class="title">
                <h3 id="footer_title">В ЭТОМ МЕСЯЦЕ</h3>
            </div>
            <table class="table table-borderless">
                <thead>
                    <tr>
                        <th scope="col">ДАТА</th>
                        <th scope="col">НАИМЕНОВАНИЕ</th>
                        <th scope="col">КЛАССЫ</th>
                    </tr>
                </thead>
                <tbody id="dataTbody">
           
                </tbody>
            </table>
        </div>
    </main>
    
    <script src='js/fullcalendar/main.js'></script>
    <script src='js/fullcalendar/locales/ru.js'></script>

    <script>
        // Библиотека FullCalendar
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                // locale: 'ru'
            });
            calendar.render();
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    <script src="js/calendar.js"></script>
</body>
</html>