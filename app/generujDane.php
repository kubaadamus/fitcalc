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

for($i=0; $i<20; $i++){
    $dzien=$i;
    if($i<10){
        $dzien="0".$i;
    }


    $wiek = rand(15,20);
    $wzrost = rand(120,200);
    $waga = rand(50,200);
    $tluszcz = rand(15,20);
    $woda = rand(70,80);
    $cisnienie_min = rand(100,120);
    $cisnienie_max = rand(100,120);
    $tetno = rand(80,120);

    $sql = "INSERT INTO fitcalc_records 
    values(null,'8','$wiek','M','$waga','$tluszcz','$woda','$cisnienie_min','$cisnienie_max','$tetno','2019-10-$dzien')";
    $result = mysqli_query($database, $sql);
    echo($sql);
}

echo("Porobione ;3");