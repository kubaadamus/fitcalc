<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>


<?php
//Skrypt łączący z bazą danych
//-------------------------------------- Ł Ą C Z E N I E  Z  B A Z Ą  D A N Y C H ------------------------------------------//
$user = 'jakubadamus';
$DBpassword = 'Kubaadamus1991';
$db = 'jakubadamus';
$host = 'mysql.cba.pl';
$port = 3360;
$database = mysqli_connect($host, $user, $DBpassword, $db) or die('Niedaradyyy' . mysqli_connect_error());
//echo "Status podłączenia do bazy danych: ";
if ($database) {
    //echo 'conected';
    session_start();
} else {
    //echo 'not conected';
}

$username = $_GET['username'];
$pass = $_GET['pass'];
$klasa = $_GET['klasa'];
$sql = "SELECT * FROM fitcalc_users WHERE 
username='$username'
AND pass ='$pass'
";
$result = mysqli_query($database, $sql);
$numrows = mysqli_num_rows($result);

if ($numrows <= 0) {


    $sql = "INSERT INTO fitcalc_users values(null,'$username','$pass','$klasa')";;
    $result = mysqli_query($database, $sql);
    ?>

    <div class="main column_align_center">
        <h3 class="header" style="font-size:6rem;">REJESTRACJA <br> UDANA</h3>
        <h3 class="header" style="font-size:4rem;">Zostaniesz przekierowany <br> do ekranu logowania <br> za <span id="counter"></span></h3>
    </div>
    <script>
        var seconds = 5;
        setInterval(function() {

            seconds -= 1;
            $("#counter").html(seconds);

            if (seconds == 0) {
                window.location.href = "index.php";
            }

        }, 1000);
    </script>
<?php
} else {
    ?>
    <div class="main column_align_center">
        <h3 class="header" style="font-size:6rem;">REJESTRACJA <br> NIEUDANA</h3>
        <h3 class="header" style="font-size:4rem;">Zostaniesz przekierowany <br> do ekranu rejestracji <br> za <span id="counter"></span></h3>
    </div>
    <script>
        var seconds = 5;
        setInterval(function() {

            seconds -= 1;
            $("#counter").html(seconds);

            if (seconds == 0) {
                window.location.href = "register.php";
            }

        }, 1000);
    </script>
<?php

}

?>