<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
    <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<?php
//Skrypt łączący z bazą danych
//-------------------------------------- Ł Ą C Z E N I E  Z  B A Z Ą  D A N Y C H ------------------------------------------//
require "database_connect.php";

$username = $_GET['username'];
$pass = $_GET['pass'];
$user_id;

if ($username == "admin" && $pass == "admin") {
    header("Location: admin/admin_main.php");
    die();
}

$remove = $_GET['remove'];
if (!empty($remove)) {
    $sql = "DELETE FROM fitcalc_records
    WHERE id = $remove";
    $result = mysqli_query($database, $sql);
}

$sql = "SELECT * FROM fitcalc_users WHERE 
username='$username'
AND pass ='$pass'
";
$result = mysqli_query($database, $sql);
$numrows = mysqli_num_rows($result);
if ($numrows > 0) {
    $result = mysqli_fetch_assoc($result);
    $user_id = $result['id'];

    if ($result['aktywny'] == 0) {
        echo ("<h1> MASZ BANA LOL </h1>");
        exit();
    }
} else {
    header("Location: idex.php?error=nouser");
    die();
}
$waga = $_GET['waga'];
$tk_tluszczowa = $_GET['tk_tluszczowa'];
$tk_miesniowa = $_GET['tk_miesniowa'];
$h2o = $_GET['h2o'];
$bialko = $_GET['bialko'];
$przem_materii = $_GET['przem_materii'];
$tl_trzewny = $_GET['tl_trzewny'];
$m_kostna = $_GET['m_kostna'];
$data = date('Y-m-d');
$last_row;

$trololo;

if (!empty($m_kostna)) {
    $sql = "INSERT INTO fitcalc_records 
    values(null,'$user_id','$waga','$tk_tluszczowa','$tk_miesniowa','$h2o','$bialko','$przem_materii','$tl_trzewny','$m_kostna','$data')";
    $result = mysqli_query($database, $sql);
    header("Location: main.php?username=$username&pass=$pass");
    die();
} else { }
?>

<body id="main">
    <div class="controls">
        <h1 class="header_blue margin_top_10">FIT CALC</h1>
        <?php
        if (!empty($_GET['admin'])) {
            ?>
            <button tyle="width:250px;height:150px;font-size:2rem;margin:0 auto;" onclick="window.location.href='admin/admin_user_list.php'" class="button_orange">DO PANELU</button>
        <?php
        } else {
            ?>
            <button style="width:250px;height:150px;font-size:2rem;margin:0 auto;" onclick="window.location.href='index.php'" class="button_orange">WYLOGUJ</button>
        <?php
        }
        ?>

        <h2 style="text-align:center;margin-top:20px;margin-bottom:20px;">Witaj <?php echo (substr($username, 0, strpos($username, "_", 0))); ?> !</h2>
        <div class="flex flex_row flex_justify_content_space_around">
            <button style="font-size:4rem;" class="button_orange" onclick="changeView('dodaj');">DODAJ</button>
            <button style="font-size:4rem;" class="button_orange" onclick="changeView('tabela');">TABELA</button>
            <button style="font-size:4rem;" class="button_orange" onclick="changeView('wykres');">WYKRES</button>
        </div>
    </div>
    <script>
        function changeView(stan) {
            $(".dodaj").hide();
            $(".wykres").hide();
            $(".tabela").hide();
            if (stan == "dodaj") {
                $(".dodaj").show();
            }
            if (stan == "wykres") {
                $(".wykres").show();
                window.dispatchEvent(new Event('resize'));
            }
            if (stan == "tabela") {
                $(".tabela").show();
            }
        }
    </script>

    <div class="dodaj">
        <form action="main.php" method="GET">
            <div class="element">
                <h3>
                    Waga [kg]
                </h3>
                <div class="flex flex_justify_content_space_around">
                    <input value="75.435" type="number" pattern="[0-9]+([\.,][0-9]+)?" step="0.001" inputmode="decimal" name="waga" id="waga" size="5">
                </div>
            </div>
            <div class="element">
                <h3>
                    Tk. tłuszczowa [%]
                </h3>
                <div class="flex flex_justify_content_space_around">

                    <input value="23.4" type="number" pattern="[0-9]+([\.,][0-9]+)?" step="0.001" inputmode="decimal" name="tk_tluszczowa" id="tk_tluszczowa" size="5">

                </div>
            </div>
            <div class="element">
                <h3>
                    Tk. mięśniowa [%]
                </h3>
                <div class="flex flex_justify_content_space_around">

                    <input value="12" type="number" pattern="[0-9]+([\.,][0-9]+)?" step="0.001" inputmode="decimal" name="tk_miesniowa" id="tk_miesniowa" size="5">

                </div>
            </div>
            <div class="element">
                <h3>
                    H<sub>2</sub>O [%]
                </h3>
                <div class="flex flex_justify_content_space_around">

                    <input value="75.02" type="number" pattern="[0-9]+([\.,][0-9]+)?" step="0.001" inputmode="decimal" name="h2o" id="h2o" size="5">

                </div>
            </div>
            <div class="element">
                <h3>
                    Białko [kg]
                </h3>
                <div class="flex flex_justify_content_space_around">

                    <input value="40.41" type="number" pattern="[0-9]+([\.,][0-9]+)?" step="0.001" inputmode="decimal" id="bialko" name="bialko" size="5">

                </div>
            </div>
            <div class="element">
                <h3>
                    Przem. materii [%]
                </h3>
                <div class="flex flex_justify_content_space_around">

                    <input value="50" type="number" pattern="[0-9]+([\.,][0-9]+)?" step="0.001" inputmode="decimal" name="przem_materii" id="przem_materii" size="5">

                </div>
            </div>
            <div class="element">
                <h3>
                    Tł. trzewny [%]
                </h3>
                <div class="flex flex_justify_content_space_around">

                    <input value="10.4" type="number" pattern="[0-9]+([\.,][0-9]+)?" step="0.001" inputmode="decimal" name="tl_trzewny" id="tl_trzewny" size="5">

                </div>
            </div>
            <div class="element">
                <h3>
                    Masa kostna [kg]
                </h3>
                <div class="flex flex_justify_content_space_around">

                    <input value="14.2" type="number" pattern="[0-9]+([\.,][0-9]+)?" step="0.001" inputmode="decimal" name="m_kostna" id="m_kostna" size="5">

                </div>
            </div>
            <div class="element">
                <h3>
                    Data
                </h3>
                <input type="text" name="data" value="<?php echo (date('Y-m-d')); ?>" size="15" readonly><br>
            </div>
            <div class="element">
                <input type="submit" value="DODAJ" class="dodaj">
                <input type="hidden" name="username" value="<?php echo ($username); ?>">
                <input type="hidden" name="pass" value="<?php echo ($pass); ?>">
            </div>
        </form>
    </div>



    <?php

    $sql = "SELECT * FROM fitcalc_records
WHERE user_id = $user_id
ORDER BY data DESC";
    $result = mysqli_query($database, $sql);
    ?>
    <div id="chartContainer" class="wykres" style="display:none;">
        <?php
        if (mysqli_num_rows($result) > 0) {
            ?>

            <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
            <script>
                window.onload = function() {

                    var chart = new CanvasJS.Chart("chartContainer", {
                        animationEnabled: true,
                        zoomEnabled: true,
                        zoomType: "xy",
                        title: {
                            text: "Parametry"
                        },
                        axisX: {
                            valueFormatString: "YYYY-MM-DD"
                        },
                        axisY2: {
                            title: "Wartość",
                            prefix: "",
                            suffix: "",
                            maximum: 200,

                        },
                        toolTip: {
                            shared: true
                        },
                        legend: {
                            cursor: "pointer",
                            verticalAlign: "top",
                            horizontalAlign: "center",
                            dockInsidePlotArea: true,
                            itemclick: toogleDataSeries
                        },
                        data: [{
                                type: "line",
                                axisYType: "secondary",
                                name: "waga",
                                showInLegend: true,
                                yValueFormatString: "###.###kg",
                                dataPoints: [

                                    <?php
                                        $result = mysqli_query($database, $sql);
                                        while ($row = mysqli_fetch_array($result, MYSQL_ASSOC)) {

                                            $trololo = ("{ x: new Date(" . substr($row['data'], 0, 4) . "," . (intval(substr($row['data'], 5, 2)) - 1) . "," . substr($row['data'], 8, 2) . "), y: " . $row['waga'] . " },");
                                            echo ($trololo);
                                        } ?>
                                ]
                            },
                            {
                                type: "line",
                                axisYType: "secondary",
                                name: "tk_tluszczowa",
                                showInLegend: true,
                                yValueFormatString: "###.###'%'",
                                dataPoints: [
                                    <?php
                                        $result = mysqli_query($database, $sql);
                                        while ($row = mysqli_fetch_array($result, MYSQL_ASSOC)) {
                                            echo ("{ x: new Date(" . substr($row['data'], 0, 4) . ", " . (intval(substr($row['data'], 5, 2)) - 1) . ", " . substr($row['data'], 8, 2) . "), y: " . $row['tk_tluszczowa'] . " },");
                                        } ?>
                                ]
                            },
                            {
                                type: "line",
                                axisYType: "secondary",
                                name: "tk_miesniowa",
                                showInLegend: true,
                                yValueFormatString: "###.###'%'",
                                dataPoints: [
                                    <?php
                                        $result = mysqli_query($database, $sql);
                                        while ($row = mysqli_fetch_array($result, MYSQL_ASSOC)) {
                                            echo ("{ x: new Date(" . substr($row['data'], 0, 4) . ", " . (intval(substr($row['data'], 5, 2)) - 1) . ", " . substr($row['data'], 8, 2) . "), y: " . $row['tk_miesniowa'] . " },");
                                        } ?>
                                ]
                            },
                            {
                                type: "line",
                                axisYType: "secondary",
                                name: "H2O",
                                showInLegend: true,
                                yValueFormatString: "###.###'%'",
                                dataPoints: [
                                    <?php
                                        $result = mysqli_query($database, $sql);
                                        while ($row = mysqli_fetch_array($result, MYSQL_ASSOC)) {
                                            echo ("{ x: new Date(" . substr($row['data'], 0, 4) . ", " . (intval(substr($row['data'], 5, 2)) - 1) . ", " . substr($row['data'], 8, 2) . "), y: " . $row['h2o'] . " },");
                                        } ?>
                                ]
                            },
                            {
                                type: "line",
                                axisYType: "secondary",
                                name: "bialko",
                                showInLegend: true,
                                yValueFormatString: "###.###kg",
                                dataPoints: [
                                    <?php
                                        $result = mysqli_query($database, $sql);
                                        while ($row = mysqli_fetch_array($result, MYSQL_ASSOC)) {
                                            echo ("{ x: new Date(" . substr($row['data'], 0, 4) . ", " . (intval(substr($row['data'], 5, 2)) - 1) . ", " . substr($row['data'], 8, 2) . "), y: " . $row['bialko'] . " },");
                                        } ?>
                                ]
                            },
                            {
                                type: "line",
                                axisYType: "secondary",
                                name: "przem_materii",
                                showInLegend: true,
                                yValueFormatString: "###.###'%'",
                                dataPoints: [
                                    <?php
                                        $result = mysqli_query($database, $sql);
                                        while ($row = mysqli_fetch_array($result, MYSQL_ASSOC)) {
                                            echo ("{ x: new Date(" . substr($row['data'], 0, 4) . ", " . (intval(substr($row['data'], 5, 2)) - 1) . ", " . substr($row['data'], 8, 2) . "), y: " . $row['przem_materii'] . " },");
                                        } ?>
                                ]
                            },
                            {
                                type: "line",
                                axisYType: "secondary",
                                name: "tl_trzewny",
                                showInLegend: true,
                                yValueFormatString: "###.###'%'",
                                dataPoints: [
                                    <?php
                                        $result = mysqli_query($database, $sql);
                                        while ($row = mysqli_fetch_array($result, MYSQL_ASSOC)) {
                                            echo ("{ x: new Date(" . substr($row['data'], 0, 4) . ", " . (intval(substr($row['data'], 5, 2)) - 1) . ", " . substr($row['data'], 8, 2) . "), y: " . $row['tl_trzewny'] . " },");
                                        } ?>
                                ]
                            },
                            {
                                type: "line",
                                axisYType: "secondary",
                                name: "m_kostna",
                                showInLegend: true,
                                yValueFormatString: "###.###kg",
                                color: "pink",
                                dataPoints: [
                                    <?php
                                        $result = mysqli_query($database, $sql);
                                        while ($row = mysqli_fetch_array($result, MYSQL_ASSOC)) {
                                            echo ("{ x: new Date(" . substr($row['data'], 0, 4) . ", " . (intval(substr($row['data'], 5, 2)) - 1) . ", " . substr($row['data'], 8, 2) . "), y: " . $row['m_kostna'] . " },");
                                        } ?>
                                ]
                            }
                        ]
                    });
                    chart.render();

                    console.log(chart);

                    function toogleDataSeries(e) {
                        if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                            e.dataSeries.visible = false;
                        } else {
                            e.dataSeries.visible = true;
                        }
                        chart.render();
                    }
                }
            </script>
        <?php } else {
            ?>
            <div style="width:fit-content; margin:0 auto;">
                <h1>Dodaj dane</h1>
            </div>
        <?php
        }
        ?>
    </div>
    <div class="tabela" style="display:none;">
        <?php
        $once = true;
        if (mysqli_num_rows($result) > 0) {
            ?>
            <table style="margin-bottom:30px;">
                <tr>
                    <th title="WAGA">waga</th>
                    <th>tk. tłuszcz.</th>
                    <th>tk. mięśn.</th>
                    <th>H<sub>2</sub>O </th>
                    <th>białko</th>
                    <th>przem. mat.</th>
                    <th>tł. trzew.</th>
                    <th>masa kostna</th>
                    <th>data</th>
                </tr>
            <?php
            } else {
                ?>
                <div style="width:fit-content; margin:0 auto;">
                    <h1>Dodaj dane</h1>
                </div>
            <?php
            }
            $sql = "SELECT * FROM fitcalc_records
            WHERE user_id = $user_id
            ORDER BY data DESC";
            $result = mysqli_query($database, $sql);

            while ($row = mysqli_fetch_array($result, MYSQL_ASSOC)) {
                if ($once == true) {
                    $last_row = $row;
                    $once = false;
                }
                ?>
                <tr class="data_tr">
                    <td><?php echo ($row['waga']); ?></td>
                    <td><?php echo ($row['tk_tluszczowa']); ?></td>
                    <td><?php echo ($row['tk_miesniowa']); ?></td>
                    <td><?php echo ($row['h2o']); ?></td>
                    <td><?php echo ($row['bialko']); ?></td>
                    <td><?php echo ($row['przem_materii']); ?></td>
                    <td><?php echo ($row['tl_trzewny']); ?></td>
                    <td><?php echo ($row['m_kostna']); ?></td>
                    <td class="data_td"><?php echo ($row['data']); ?></td>
                    <?php
                        if (!empty($_GET['admin'])) {
                            ?>
                        <td><button onclick="window.location.href='main.php?remove=<?php echo ($row['id']); ?>&username=<?php echo ($username); ?>&pass=<?php echo ($pass); ?>&target=tabela'">x</button></td>
                    <?php
                        }
                        ?>
                </tr>
            <?php } ?>

            </table>
    </div>

    <script>
        $("[name=waga]").val(<?php echo ($last_row['waga']); ?>);
        $("[name=tk_tluszczowa]").val(<?php echo ($last_row['tk_tluszczowa']); ?>);
        $("[name=tk_miesniowa]").val(<?php echo ($last_row['tk_miesniowa']); ?>);
        $("[name=h2o]").val(<?php echo ($last_row['h2o']); ?>);
        $("[name=bialko]").val(<?php echo ($last_row['bialko']); ?>);
        $("[name=przem_materii]").val(<?php echo ($last_row['przem_materii']); ?>);
        $("[name=tl_trzewny]").val(<?php echo ($last_row['tl_trzewny']); ?>);
        $("[name=m_kostna]").val(<?php echo ($last_row['m_kostna']); ?>);
    </script>




</body>


<?php

echo ($trololo);


?>