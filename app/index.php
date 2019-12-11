<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
    <META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
</head>

<?php
//Skrypt łączący z bazą danych
//-------------------------------------- Ł Ą C Z E N I E  Z  B A Z Ą  D A N Y C H ------------------------------------------//
require "database_connect.php";
?>

<body id="indexBody">

    <div class="main column_align_center">

        <h1 class="header_blue">FIT CALC</h1>

        <?php
        if ($_GET['error'] == "nouser") {
            ?>
            <div style="color:red">
                <h1>Zły login lub hasło!</h12>
            </div>
        <?
        }
        ?>
        <br><br>
        <form action="main.php" class="login_form">
            <br>
            <input type="text" name="username" id="username" placeholder="Nazwa Użytkownika">
            <br>
            <input type="password" name="pass" placeholder="Hasło">
            <br>
            <input class="button_big button_round button_orange" type="submit" value="Zaloguj">
            <br>
        </form>
        <button style="margin:0 auto; font-size:4rem;" class="button_round button_orange" onclick="window.location.href='register.php'" ;>Zarejestruj sie</button>
        <img class="logo" src="assets/images/logo.png" alt="">
    </div>
</body>

<script>
    $(document).ready(function() {
        $("#username").trigger("click");
    });
</script>