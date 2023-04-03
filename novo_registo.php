<?php
    session_start();
    if(!isset($_SESSION['nif'])){
        header("Location: index.php");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login V8</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->
    <link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="css/util.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
</head>
<body>
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <form class="login100-form validate-form p-l-55 p-r-55 p-t-178" method="POST"
                action="submit_registo.php">
                    <span class="login100-form-title">
                        Novo Registo
                    </span>

                    <form action="submit_registo.php" method="POST">
                        <label>Concelho</label>
                        <div class="wrap-input100 validate-input m-b-16">
                        <select id="mySelect" class="select100" name="concelho">
                        <?php
                            include_once('Config.php');

                            $conn = accessBD();
                            $sql = 'Select nome_concelho From concelhos';

                            $result = pg_prepare($conn, "query", $sql);
                            $result = pg_execute($conn, "query", array());

                            if ($result != FALSE) {
                                while($arr = pg_fetch_array($result, NULL, PGSQL_ASSOC)) {
                        ?>
                                <option value="<?php echo $arr["nome_concelho"]?>">
                                    <?php echo $arr["nome_concelho"]?>
                                </option>
                        <?php
                                }
                            }

                            pg_close($conn);
                        ?>
                        </select>
                            <span class="focus-input100"></span>
                        </div>

                        <label style="margin-top: 2em">Data e Hora</label>
                        <div class="wrap-input100 validate-input">
                            <input class="input100" type="text" name="data">
                            <span class="focus-input100"></span>
                        </div>

                        <label style="margin-top: 2em">Mortos</label>
                        <div class="wrap-input100 validate-input">
                            <input class="input100" type="number" name="mortos" id="mortos"
                            value = 0 onChange="updateIG()">
                            <span class="focus-input100"></span>
                            <div class="pull-right">
                                <button type="button" onclick="inc_mortos()">+</button>
                                <button type="button" onclick="dec_mortos()">-</button>
                            </div>
                        </div>

                        <label style="margin-top: 2em">Feridos Graves</label>
                        <div class="wrap-input100 validate-input">
                            <input class="input100" type="number" name="feridos" id="feridos"
                            value = 0 onChange="updateIG()">
                            <span class="focus-input100"></span>
                            <div class="pull-right">
                                <button type="button" onclick="inc_feridos()">+</button>
                                <button type="button" onclick="dec_feridos()">-</button>
                            </div>
                        </div>

                        <label style="margin-top: 2em">Km</label>
                        <div class="wrap-input100 validate-input">
                            <input class="input100" type="text" name="km">
                            <span class="focus-input100"></span>
                        </div>

                        <label style="margin-top: 2em">Via</label>
                        <div class="wrap-input100 validate-input">
                            <input class="input100" type="text" name="via">
                            <span class="focus-input100"></span>
                        </div>

                        <label style="margin-top: 2em">Natureza</label>
                        <div class="wrap-input100 validate-input">
                            <input class="input100" type="text" name="natureza">
                            <span class="focus-input100"></span>
                        </div>

                        <label style="margin-top: 2em">Indice Gravidade</label>
                        <div class="wrap-input100 validate-input">
                            <input class="input100" type="number" name="ig" id="ig"
                            value = 0 readonly>
                            <span class="focus-input100"></span>
                        </div>

                        <div class="container-login100-form-btn" style="margin-top: 2em">
                            <button class="login100-form-btn">
                                Submeter
                            </button>
                        </div>
                    </form>
                </form>
            </div>
        </div>
    </div>
    <script>

        function inc_mortos() {
            document.getElementById("mortos").stepUp(1);
            updateIG();
        }

        function dec_mortos() {
            if (document.getElementById("mortos").value > 0) {
                document.getElementById("mortos").stepDown(1);
                updateIG();
            }
        }

        function inc_feridos() {
            document.getElementById("feridos").stepUp(1);
            updateIG();
        }

        function dec_feridos() {
            if (document.getElementById("feridos").value > 0) {
                document.getElementById("feridos").stepDown(1);
                updateIG();
            }
        }

        function updateIG() {
            document.getElementById("ig").value =
                document.getElementById("mortos").value * 100
                + document.getElementById("feridos").value * 10;
        }
    </script>

<!--===============================================================================================-->
    <script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
    <script src="vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
    <script src="vendor/bootstrap/js/popper.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
    <script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
    <script src="vendor/daterangepicker/moment.min.js"></script>
    <script src="vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
    <script src="vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
    <script src="js/main.js"></script>

</body>
</html>