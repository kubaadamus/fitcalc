<?php

require "../database_connect.php";

?>
<html>

<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
    <link rel="stylesheet" type="text/css" href="../styles.css">
    <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
</head>

<body>
    <div class="flex flex_column flex_justify_items_center text_center">
    <button style="font-size:4rem;margin:0 auto;padding:30px;" onclick="window.location.href='admin_main.php'" class="button_orange">DO MENU</button>
        <h2 class="header_small">Klasy i uczniowie</h2>
    </div>


    <table class="user_list_table">


        <?php




        $sql = "SELECT * FROM fitcalc_users WHERE username!='admin' ORDER BY klasa";
        $result = mysqli_query($database, $sql);
        $result = mysqli_fetch_all($result, MYSQLI_ASSOC);

        $klasa = "";
        for ($i = 0; $i < count($result); $i++) {
            ?>

            <?php
                if ($klasa != $result[$i]['klasa']) {
                    $klasa = $result[$i]['klasa'];
                    ?>
                <tr class="class_row">
                    <td colspan="5" style="text-align:center">
                        <?php echo ($result[$i]['klasa']); ?>
                    </td>
                </tr>

            <?php
                }
                ?>


            <tr class="users_row">
                <td> <?php echo ($result[$i]['imie']); ?> </td>
                <td> <?php echo ($result[$i]['nazwisko']); ?> </td>
                <td> <?php echo ($result[$i]['klasa']); ?> </td>
                <td><button style="background-color:chartreuse; width:100%;" onclick="window.location.href='../main.php?username=<?php echo ($result[$i]['username']); ?>&pass=<?php echo ($result[$i]['pass']); ?>&admin=1'">Profil</button></td>
            </tr>

        <?php


        }

        ?>

    </table>

</body>

</html>