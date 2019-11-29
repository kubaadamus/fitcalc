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

    $data = "2019-11-".$dzien;
    $user_id = "1";

    $waga = rand(70,80);
    $tk_tluszczowa = rand(20,30);
    $tk_miesniowa = rand(50,200);
    $h2o = rand(70,80);
    $bialko = rand(70,80);
    $przem_materii = rand(100,120);
    $tl_trzewny = rand(100,120);
    $m_kostna = rand(80,120);

    $sql = "INSERT INTO fitcalc_records 
    values(null,'$user_id','$waga','$tk_tluszczowa','$tk_miesniowa','$h2o','$bialko','$przem_materii','$tl_trzewny','$m_kostna','$data')";
    $result = mysqli_query($database, $sql);
    echo($sql);
}

echo("Porobione ;3");