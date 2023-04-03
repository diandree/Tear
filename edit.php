<?php
    session_start();
    if(!isset($_SESSION['nif'])) {
        header("Location: index.php");
        exit();
    }

    include_once('Config.php');

    $id = $_GET['id'];

    $conn = accessBD();

    pg_query($conn, "BEGIN") or die("Could not start transaction\n");

    $sql = 'Select * From sinistralidades Where cod_sin = $1 FOR UPDATE';

    $result = pg_prepare($conn, "query", $sql);
    $result = pg_execute($conn, "query", array($id));

    if ($result != FALSE) {
        $arr = pg_fetch_array($result, NULL, PGSQL_ASSOC);

        $concelho = $arr["concelho"];
        if (empty($concelho)) {
            pg_query($conn, "ROLLBACK");
            $_SESSION['edit_deleted_error'] = true;

            if ($_SESSION['func'] == 0) {
                header('Location: menu/menu_utilizador.php');
            }
    
            if ($_SESSION['func'] == 2) {
                header('Location: menu/menu_admin.php');
            }

            pg_close($conn);
            exit();
        }

        $datahora = $arr["datahora"];
        $mortos = $arr["m"];
        $feridos = $arr["fg"];
        $km = $arr["km"];
        $via = $arr["via"];
        $natureza = $arr["natureza"];
        $ig = $arr["ig"];

        pg_query($conn, "COMMIT") or die("Transaction commit failed\n");
    }

    else {
        pg_query($conn, "ROLLBACK");
        $_SESSION['edit_reg_error'] = true;

        if ($_SESSION['func'] == 0) {
            header('Location: menu/menu_utilizador.php');
        }
    
        if ($_SESSION['func'] == 2) {
            header('Location: menu/menu_admin.php');
        }
    }

    pg_close($conn);
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
                <form class="login100-form validate-form p-l-55 p-r-55 p-t-178" method="POST" action="submit_edit.php">
                    <span class="login100-form-title">
                        Editar Registo
                    </span>

                    <form action="submit_edit.php" method="POST">
                        <input type="hidden" name="id" value=<?php echo $id?>>
                        <label>Concelho</label>
                        <div class="wrap-input100 validate-input m-b-16">
                            <input class="input100" type="text" name="concelho"
                            value = "<?php echo $concelho ?>" readonly>
                            <span class="focus-input100"></span>
                        </div>

                        <label style="margin-top: 2em">Data e Hora</label>
                        <div class="wrap-input100 validate-input">
                            <input class="input100" type="text" id="data_listen"
                            value = "<?php echo $datahora ?>">
                            <input class="input100" type="hidden" id="data_new" name="data"
                            value ="-1" readonly>
                            <span class="focus-input100"></span>
                        </div>

                        <label style="margin-top: 2em">Mortos</label>
                        <div class="wrap-input100 validate-input">
                            <input class="input100" type="number" id="mortos"
                            value = <?php echo $mortos ?> readonly>
                            <input class="input100" type="hidden" id="mortos_post" name="mortos"
                            value ="0" readonly>
                            <span class="focus-input100"></span>
                            <div class="pull-right">
                                <button type="button" onclick="inc_mortos()">+</button>
                                <button type="button" onclick="dec_mortos()">-</button>
                            </div>
                        </div>

                        <label style="margin-top: 2em">Feridos Graves</label>
                        <div class="wrap-input100 validate-input">
                            <input class="input100" type="number" id="feridos"
                            value = <?php echo $feridos ?> readonly>
                            <input class="input100" type="hidden" id="feridos_post" name="feridos"
                            value ="0" readonly>
                            <span class="focus-input100"></span>
                            <div class="pull-right">
                                <button type="button" onclick="dec_mortos()">+</button>
                                <button type="button" onclick="inc_mortos()">-</button>
                            </div>
                        </div>

                        <label style="margin-top: 2em">Km</label>
                        <div class="wrap-input100 validate-input">
                            <input class="input100" type="text" id="km"
                            value = "<?php echo $km ?>">
                            <input class="input100" type="hidden" id="km_new" name="km"
                            value ="-1" readonly>
                            <span class="focus-input100"></span>
                        </div>

                        <label style="margin-top: 2em">Via</label>
                        <div class="wrap-input100 validate-input">
                            <input class="input100" type="text" id="via"
                            value = "<?php echo $via ?>">
                            <input class="input100" type="hidden" id="via_new" name="via"
                            value ="-1" readonly>
                            <span class="focus-input100"></span>
                        </div>

                        <label style="margin-top: 2em">Natureza</label>
                        <div class="wrap-input100 validate-input">
                            <input class="input100" type="text" id="natureza"
                            value = "<?php echo $natureza ?>">
                            <input class="input100" type="hidden" id="natureza_new" name="natureza"
                            value ="-1" readonly>
                            <span class="focus-input100"></span>
                        </div>

                        <label style="margin-top: 2em">Indice Gravidade</label>
                        <div class="wrap-input100 validate-input">
                            <input class="input100" type="number" id="ig"
                            value = <?php echo $ig ?> readonly>
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
        document.getElementById("data_listen").addEventListener("change", function(){
            document.getElementById("data_new").value = document.getElementById("data_listen").value;
        });

        document.getElementById("via").addEventListener("change", function(){
            document.getElementById("via_new").value = document.getElementById("via").value;
        });

        document.getElementById("km").addEventListener("change", function(){
            document.getElementById("km_new").value = document.getElementById("km").value;
        });

        document.getElementById("natureza").addEventListener("change", function(){
            document.getElementById("natureza_new").value = document.getElementById("natureza").value;
        });

        function inc_mortos() {
            if (document.getElementById("feridos").value > 0) {
                document.getElementById("mortos").stepUp(1);
                document.getElementById("feridos").stepDown(1);

                document.getElementById("mortos_post").value = (+document.getElementById("mortos_post").value)+1;
                document.getElementById("feridos_post").value = (+document.getElementById("feridos_post").value)-1;

                document.getElementById("ig").value =
                    document.getElementById("mortos").value * 100
                    + document.getElementById("feridos").value * 10;
            }
        }

        function dec_mortos() {
            if (document.getElementById("mortos").value > 0) {
                document.getElementById("mortos").stepDown(1);
                document.getElementById("feridos").stepUp(1);

                document.getElementById("mortos_post").value = (+document.getElementById("mortos_post").value)-1;
                document.getElementById("feridos_post").value = (+document.getElementById("feridos_post").value)+1;

                document.getElementById("ig").value =
                    document.getElementById("mortos").value * 100
                    + document.getElementById("feridos").value * 10;
            }
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