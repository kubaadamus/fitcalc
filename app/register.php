<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>

<body id="registerBody">



    <div class="column_align_center">
        <h5 class="header" style="margin-bottom:10px;font-size:6rem;">Rejestracja</h5>
        <form action="register_confirm.php" class="register_form" id="register_form">
            <label for="name" class="border_2 padding_20">Nazwa użytkownika:
                <br>
                <input type="text" name="username" placeholder="Imie_Nazwisko" id="username" style="text-align:center;">
                <p style="font-size:2.4rem;">Np. Jan_Kowalski</p>
                
            </label>
            <br>
            <label for="klasa" class="border_2 padding_20">Klasa:
                <br>
                <select name="klasa" id="klasa">
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
                <br>
            </label>
            <br>
            <label for="pass" class="border_2 padding_20">Hasło:
                <br>
                <input type="password" name="pass" id="pass">
                <br>
                Powtórz Hasło:
                <br>
                <input type="password" name="pass2" id="pass2">
            </label>
            <h1 id="error_msg"></h1>
            <h1 id="error_msg_username"></h1>
            <input class="button_big button_round" type="button" value="Zarejestruj" id="zarejestrujPrzycisk" onclick="checkPassword();">
            <input class="button_small button_round" type="button" value="&larr; Cofnij" onclick="window.location.href='http://www.fitcalc.cba.pl'">
            <br>
            <br>
            <br>
        </form>
    </div>

    <script>
        function checkPassword() {

            passed = true;

            if ($("#pass").val() == "" || $("#pass2").val() == "") {
                $("#pass2").css("background-color", "red");
                $("#pass").css("background-color", "red");
                $("#error_msg").html("Wpisz hasło");
                passed = false;
            } else {
                $("#error_msg").html("");
            }
            if ($("#pass").val() != $("#pass2").val() || $("#username").val() == "") {
                $("#pass2").css("background-color", "red");
                $("#error_msg").html("Niepoprawnie wpisane hasło <br> lub login");
                passed = false;
            } else {
                $("#pass2").css("background-color", "white");
                $("#pass").css("background-color", "white");
            }
            if ($("#username").val() == "" || $("#username").val().indexOf("_") <= 0 || !isUpperCase($("#username").val().charAt(0)) || !isUpperCase($("#username").val().charAt($("#username").val().indexOf("_")+1))) {
                $("#username").css("background-color", "red");
                $("#error_msg_username").html("Niepoprawna nazwa użytkownika!");
                passed = false;
            } else {
                $("#username").css("background-color", "white");
                $("#error_msg_username").html("");
            }
            if(passed){
                $("#register_form").submit();
            }

            
        }



        function isUpperCase(str) {
            return str === str.toUpperCase();
        }
    </script>

</body>