
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
        <h1 class="header_medium">Administrator</h1>
        <button onclick="location.href='admin_find_user.php'" class="button_big">Znajdź ucznia</button>
        <button onclick="location.href='admin_user_list.php'" class="button_big">Lista uczniów</button>
        <button onclick="location.href='../index.php'" class="button_big">Wyloguj</button>
    </div>
</body>

</html>