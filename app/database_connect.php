<?php

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


?>