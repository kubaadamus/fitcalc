<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
</head>

<?php
//Skrypt łączący z bazą danych
//-------------------------------------- Ł Ą C Z E N I E  Z  B A Z Ą  D A N Y C H ------------------------------------------//
require "database_connect.php";
?>
<body id="indexBody">

    <div class="main column_align_center">

        <h1 class="header" >FIT CALC</h1>

        <?php 
        if($_GET['error']=="nouser"){
            ?>
            <div style="color:red">
                <h1>Zły login lub hasło!</h12>
            </div>
            <?
        }
        ?>
        <br><br>
        <form action="main.php" class="login_form">
            <label for="username">Nazwa użytkownika:
                <br>
                <input type="text" name="username">
                <br>
            </label>
            <label for="pass">Hasło:
                <br>
                <input type="password" name="pass">
            </label>
            <br>
            <input class="button_big button_round" type="submit" value="Zaloguj" >
            <br>
        </form>
        <button hidden class="button_medium button_round" onclick="window.location.href='register.php'";>Zarejestruj się</button>
        <img class="logo" src="assets/images/logo.png" alt="">
    </div>
</body>
