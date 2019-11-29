<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<?php
//Skrypt łączący z bazą danych
//-------------------------------------- Ł Ą C Z E N I E  Z  B A Z Ą  D A N Y C H ------------------------------------------//
require "database_connect.php";

$username = $_GET['username'];
$pass = $_GET['pass'];
$user_id;

if($username=="admin" && $pass=="admin"){
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

    if($result['aktywny']==0){
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
$data = $_GET['data'];

$last_row;

if (!empty($data)) {
    $sql = "INSERT INTO fitcalc_records 
    values(null,'$user_id','$waga','$tk_tluszczowa','$tk_miesniowa','$h2o','$bialko','$przem_materii','$tl_trzewny','$m_kostna','$data')";
    $result = mysqli_query($database, $sql);
    echo ($sql);
} else { }

?>

<body id="main">


    <div class="controls">
        <h1>Witaj <?php echo ($username); ?> !</h1>

        <div class="flex flex_row flex_justify_content_space_around">
            <button class="button_medium" onclick="changeView('dodaj');">DODAJ</button>

            <button class="button_medium" onclick="changeView('tabela');">TABELA</button>

            <button class="button_medium" onclick="changeView('wykres');">WYKRES</button>
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
                    <input type="number" pattern="[0-9]*" inputmode="numeric" name="waga" id="waga" size="5">
                </div>
            </div>
            <div class="element">
                <h3>
                    Tk. tłuszczowa [%]
                </h3>
                <div class="flex flex_justify_content_space_around">

                    <input type="number" pattern="[0-9]*" inputmode="numeric" name="tk_tluszczowa" id="tk_tluszczowa" size="5">

                </div>
            </div>
            <div class="element">
                <h3>
                    Tk. mięśniowa [%]
                </h3>
                <div class="flex flex_justify_content_space_around">

                    <input type="number" pattern="[0-9]*" inputmode="numeric" name="tk_miesniowa" id="tk_miesniowa" size="5">

                </div>
            </div>
            <div class="element">
                <h3>
                    H<sub>2</sub>O [%]
                </h3>
                <div class="flex flex_justify_content_space_around">

                    <input type="number" pattern="[0-9]*" inputmode="numeric" name="h2o" id="h2o" size="5">

                </div>
            </div>
            <div class="element">
                <h3>
                    Białko [kg]
                </h3>
                <div class="flex flex_justify_content_space_around">

                    <input type="number" pattern="[0-9]*" inputmode="numeric" id="bialko" name="bialko" size="5">

                </div>
            </div>
            <div class="element">
                <h3>
                    Przem. materii [%]
                </h3>
                <div class="flex flex_justify_content_space_around">

                    <input type="number" pattern="[0-9]*" inputmode="numeric" name="przem_materii" id="przem_materii" size="5">

                </div>
            </div>
            <div class="element">
                <h3>
                    Tł. trzewny [%]
                </h3>
                <div class="flex flex_justify_content_space_around">

                    <input type="number" pattern="[0-9]*" inputmode="numeric" name="tl_trzewny" id="tl_trzewny" size="5">

                </div>
            </div>
            <div class="element">
                <h3>
                    Masa kostna [kg]
                </h3>
                <div class="flex flex_justify_content_space_around">

                    <input type="number" pattern="[0-9]*" inputmode="numeric" name="m_kostna" id="m_kostna" size="5">

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

    <body>
        <div id="chartContainer" class="wykres" style="display:none;">
            <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
        </div>

    </body>


    <div class="tabela" style="display:none;">
        <table>
            <tr>
                <th>waga</th>
                <th>tkanka tłuszczowa</th>
                <th>tkanka mięśniowa</th>
                <th>H<sub>2</sub>O </th>
                <th>białko</th>
                <th>przemiana materii</th>
                <th>tłuszcz trzewny</th>
                <th>masa kostna</th>
                <th>data</th>
            </tr>
            <?php

            $sql = "SELECT * FROM fitcalc_records
WHERE user_id = $user_id
ORDER BY data DESC";
            $result = mysqli_query($database, $sql);
            $once = true;
            while ($row = mysqli_fetch_array($result, MYSQL_ASSOC)) {
                if ($once == true) {
                    $last_row = $row;
                    $once = false;
                }

                ?>
                <tr>
                    <td><?php echo ($row['waga']); ?></td>
                    <td><?php echo ($row['tk_tluszczowa']); ?></td>
                    <td><?php echo ($row['tk_miesniowa']); ?></td>
                    <td><?php echo ($row['h2o']); ?></td>
                    <td><?php echo ($row['bialko']); ?></td>
                    <td><?php echo ($row['przem_materii']); ?></td>
                    <td><?php echo ($row['tl_trzewny']); ?></td>
                    <td><?php echo ($row['m_kostna']); ?></td>
                    <td><?php echo ($row['data']); ?></td>
                    <td><button onclick="window.location.href='main.php?remove=<?php echo ($row['id']); ?>&username=<?php echo ($username); ?>&pass=<?php echo ($pass); ?>&target=tabela'">x</button></td>
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

    <script>
        window.onload = function() {

            var chart = new CanvasJS.Chart("chartContainer", {
                title: {
                    text: "Staty"
                },
                axisX: {
                    valueFormatString: "MMM YYYY DD"
                },
                axisY2: {
                    title: "Wartość",
                    prefix: "",
                    suffix: ""
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
                        name: "Waga",
                        showInLegend: true,
                        markerSize: 0,
                        yValueFormatString: "###kg",
                        dataPoints: [

                            <?php
                            $result = mysqli_query($database, $sql);
                            while ($row = mysqli_fetch_array($result, MYSQL_ASSOC)) {

                                echo ("{ x: new Date(" . substr($row['data'], 0, 4) . ", " . substr($row['data'], 5, 2) . ", " . substr($row['data'], 8, 2) . "), y: " . $row['waga'] . " },");
                            } ?>
                        ]
                    },
                    {
                        type: "line",
                        axisYType: "secondary",
                        name: "tk_tluszczowa",
                        showInLegend: true,
                        markerSize: 0,
                        yValueFormatString: "##,##%",
                        dataPoints: [
                            <?php
                            $result = mysqli_query($database, $sql);
                            while ($row = mysqli_fetch_array($result, MYSQL_ASSOC)) {
                                echo ("{ x: new Date(" . substr($row['data'], 0, 4) . ", " . substr($row['data'], 5, 2) . ", " . substr($row['data'], 8, 2) . "), y: " . $row['tk_tluszczowa'] . " },");
                            } ?>
                        ]
                    },
                    {
                        type: "line",
                        axisYType: "secondary",
                        name: "tk_miesniowa",
                        showInLegend: true,
                        markerSize: 0,
                        yValueFormatString: "##,##%",
                        dataPoints: [
                            <?php
                            $result = mysqli_query($database, $sql);
                            while ($row = mysqli_fetch_array($result, MYSQL_ASSOC)) {
                                echo ("{ x: new Date(" . substr($row['data'], 0, 4) . ", " . substr($row['data'], 5, 2) . ", " . substr($row['data'], 8, 2) . "), y: " . $row['tk_miesniowa'] . " },");
                            } ?>
                        ]
                    },
                    {
                        type: "line",
                        axisYType: "secondary",
                        name: "H2O",
                        showInLegend: true,
                        markerSize: 0,
                        yValueFormatString: "##,##%",
                        dataPoints: [
                            <?php
                            $result = mysqli_query($database, $sql);
                            while ($row = mysqli_fetch_array($result, MYSQL_ASSOC)) {
                                echo ("{ x: new Date(" . substr($row['data'], 0, 4) . ", " . substr($row['data'], 5, 2) . ", " . substr($row['data'], 8, 2) . "), y: " . $row['h2o'] . " },");
                            } ?>
                        ]
                    },
                    {
                        type: "line",
                        axisYType: "secondary",
                        name: "bialko",
                        showInLegend: true,
                        markerSize: 0,
                        yValueFormatString: "###kg",
                        dataPoints: [
                            <?php
                            $result = mysqli_query($database, $sql);
                            while ($row = mysqli_fetch_array($result, MYSQL_ASSOC)) {
                                echo ("{ x: new Date(" . substr($row['data'], 0, 4) . ", " . substr($row['data'], 5, 2) . ", " . substr($row['data'], 8, 2) . "), y: " . $row['bialko'] . " },");
                            } ?>
                        ]
                    },
                    {
                        type: "line",
                        axisYType: "secondary",
                        name: "przem_materii",
                        showInLegend: true,
                        markerSize: 0,
                        yValueFormatString: "##,##%",
                        dataPoints: [
                            <?php
                            $result = mysqli_query($database, $sql);
                            while ($row = mysqli_fetch_array($result, MYSQL_ASSOC)) {
                                echo ("{ x: new Date(" . substr($row['data'], 0, 4) . ", " . substr($row['data'], 5, 2) . ", " . substr($row['data'], 8, 2) . "), y: " . $row['przem_materii'] . " },");
                            } ?>
                        ]
                    },
                    {
                        type: "line",
                        axisYType: "secondary",
                        name: "tl_trzewny",
                        showInLegend: true,
                        markerSize: 0,
                        yValueFormatString: "##,##%",
                        dataPoints: [
                            <?php
                            $result = mysqli_query($database, $sql);
                            while ($row = mysqli_fetch_array($result, MYSQL_ASSOC)) {
                                echo ("{ x: new Date(" . substr($row['data'], 0, 4) . ", " . substr($row['data'], 5, 2) . ", " . substr($row['data'], 8, 2) . "), y: " . $row['tl_trzewny'] . " },");
                            } ?>
                        ]
                    },
                    {
                        type: "line",
                        axisYType: "secondary",
                        name: "m_kostna",
                        showInLegend: true,
                        markerSize: 0,
                        yValueFormatString: "##,##kg",
                        dataPoints: [
                            <?php
                            $result = mysqli_query($database, $sql);
                            while ($row = mysqli_fetch_array($result, MYSQL_ASSOC)) {
                                echo ("{ x: new Date(" . substr($row['data'], 0, 4) . ", " . substr($row['data'], 5, 2) . ", " . substr($row['data'], 8, 2) . "), y: " . $row['m_kostna'] . " },");
                            } ?>
                        ]
                    }

                ]
            });
            chart.render();

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


</body>
















<!-- stara forma

<form action="main.php">
            <div class="element">
                <h3>
                    Waga [kg]
                </h3>
                <div class="flex flex_justify_content_space_around">
                    <button class="button_large button_round" type="button" onclick="$('#wag').val((parseInt($('#wag').val())-1));">➖</button>
                    <input  type="number" pattern="[0-9]*" inputmode="numeric" name="wag" id="wag" size="5">
                    <button class="button_large button_round" type="button" onclick="$('#wag').val((parseInt($('#wag').val())+1));">➕</button>
                </div>
            </div>
            <div class="element">
                <h3>
                    Tk. tłuszczowa [%]
                </h3>
                <div class="flex flex_justify_content_space_around">
                    <button class="button_large button_round" type="button" onclick="$('#tlu').val((parseInt($('#tlu').val())-1));">➖</button>
                    <input type="text" name="tlu" id="tlu" size="5">
                    <button class="button_large button_round" type="button" onclick="$('#tlu').val((parseInt($('#tlu').val())+1));">➕</button>
                </div>
            </div>
            <div class="element">
                <h3>
                    Tk. mięśniowa [%]
                </h3>
                <div class="flex flex_justify_content_space_around">
                    <button class="button_large button_round" type="button" onclick="$('#mie').val((parseInt($('#mie').val())-1));">➖</button>
                    <input type="text" name="mie" id="mie" size="5">
                    <button class="button_large button_round" type="button" onclick="$('#mie').val((parseInt($('#mie').val())+1));">➕</button>
                </div>
            </div>
            <div class="element">
                <h3>
                    H2O [%]
                </h3>
                <div class="flex flex_justify_content_space_around">
                    <button class="button_large button_round" type="button" onclick="$('#wod').val((parseInt($('#wod').val())-1));">➖</button>
                    <input type="text" name="wod" id="wod" size="5">
                    <button class="button_large button_round" type="button" onclick="$('#wod').val((parseInt($('#wod').val())+1));">➕</button>
                </div>
            </div>
            <div class="element">
                <h3>
                    Białko []
                </h3>
                <div class="flex flex_justify_content_space_around">
                    <button class="button_large button_round" type="button" onclick="$('#bia').val((parseInt($('#bia').val())-1));">➖</button>
                    <input type="text" id="bia" name="bia" size="5">
                    <button class="button_large button_round" type="button" onclick="$('#bia').val((parseInt($('#bia').val())+1));">➕</button>
                </div>
            </div>
            <div class="element">
                <h3>
                    Przem. materii []
                </h3>
                <div class="flex flex_justify_content_space_around">
                    <button class="button_large button_round" type="button" onclick="$('#tet').val((parseInt($('#tet').val())-1));">➖</button>
                    <input type="text" name="tetno" id="tet" size="5">
                    <button class="button_large button_round" type="button" onclick="$('#tet').val((parseInt($('#tet').val())+1));">➕</button>
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


        !->