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
        <h2 class="header_small">Lista uczniów</h2>
    </div>

    <style>
        table,
        th,
        tr,
        td {
            border: 1px solid black;
            padding: 10px;
        }
    </style>

    <table>
        <tr>
            <th>Imie</th>
            <th>Nazwisko</th>
            <th>Klasa</th>
        </tr>

        <?php
        $sql = "SELECT * FROM fitcalc_users WHERE username!='admin' ORDER BY klasa";
        $result = mysqli_query($database, $sql);
        $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
        var_dump($result);

        $klasa = "";
        for ($i = 0; $i < count($result); $i++) {
            ?>

            <?php
                if ($klasa != $result[$i]['klasa']) {
                    $klasa = $result[$i]['klasa'];
                    ?>
                <tr>
                    <td colspan="5">
                    <?php echo ($result[$i]['klasa']); ?>
                    </td>
                </tr>
            <?php
                }
                ?>

            <tr>
                <td> <?php echo ($result[$i]['imie']); ?> </td>
                <td> <?php echo ($result[$i]['nazwisko']); ?> </td>
                <td> <?php echo ($result[$i]['klasa']); ?> </td>
                <td><button onclick="window.location.href='../main.php?username=<?php echo ($result[$i]['username']); ?>&pass=<?php echo ($result[$i]['pass']); ?>'">Profil</button></td>
            </tr>

        <?php


        }

        ?>

    </table>

</body>

</html>