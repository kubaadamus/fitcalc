<?php

require "../database_connect.php";

?>
<html>

<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
    <link rel="stylesheet" type="text/css" href="../styles.css">
</head>

<body>
    <div class="flex flex_column flex_justify_items_center text_center">
        <h1 class="header_medium">Znajdź ucznia</h1>
        <form action="admin_user_list.php" class="flex flex_column flex_justify_items_center" style="width:80%; margin:0 auto;">
            <input class="input_large" type="text" name="imie" id="" placeholder="Imię">
            <br><br><br><br>
            <input type="text" name="nazwisko" id="" placeholder="Nazwisko">
            <br><br><br><br>
            <select name="klasa" id="klasa" style="margin:0 auto;">
                <option value="1 Gl a">1 Gl a</option>
                <option value="1 Gl b">1 Gl b</option>
                <option value="1 GF c">1 GF c</option>
                <option value="1 Pl d">1 Pl d</option>
                <option value="1 Pl f">1 Pl f</option>
                <option value="1 PF g">1 PF g</option>
                <option value="2 a">2 a</option>
                <option value="2 b">2 b</option>
                <option value="2 c">2 c</option>
                <option value="3">3</option>
                <option value="4">4</option>
            </select>
            <input type="submit" name="" id="" class="button_big" value="SZUKAJ">

        </form>
    </div>
</body>

</html>