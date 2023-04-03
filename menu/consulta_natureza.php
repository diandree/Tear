<?php
    session_start();
    if(!isset($_SESSION['nif'])){
        header("Location: index.php");
        exit();
    }

    $consulta_loc = NULL;

    if (isset($_POST['nat'])){
        $consulta_loc =  $_POST['nat'];
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

<div class="topnav">
        <a class="active" href="#home">Home</a>
        <a href="consultas.php">Consultas</a>
        <a href="../logout.php">Logout</a>
</div>

    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                    <span class="login100-form-title">Sinistralidades por Natureza</span>

                    <div style="margin-top: 70px;">
                        <label>Selecione natureza:</label>
                        <form method="post" action="">
                            <select id="nat" class="select100" name="nat" onchange="jsFunction()">
                                <option value="select"></option>
                                <option value="Despiste">Despiste</option>
                                <option value="Atropelamento">Atropelamento</option>
                                <option value="Colisão">Colisão</option>
                            </select>
                            <button value="soubotão" name="but_concelho">Pesquisar</button>
                             </form>
                            <span class="focus-input100"></span>
                    </div>
            </div>
        </div>
    </div>
    <div class="limiter">
        <div class="container-table100">
            <div class="wrap-table100">
                <div class="table100 ver1 m-b-110">
                    <div class="table100-head">
                        <table>
                            <thead>
                                <tr class="row100 head">
                                    <th class="cell100 column1">Concelho</th>
                                    <th class="cell100 column2">Data e Hora</th>
                                    <th class="cell100 column3">Mortos</th>
                                    <th class="cell100 column4">Feridos Graves</th>
                                    <th class="cell100 column5">Km</th>
                                    <th class="cell100 column6">Via</th>
                                    <th class="cell100 column7">Natureza</th>
                                    <th class="cell100 column8">IG</th>
                                </tr>
                            </thead>
                        </table>
                    </div>

                    <div class="table100-body js-pscroll">
                        <table>
                            <tbody>
                            <?php
                                include_once('../Config.php');

                                if ($consulta_loc != NULL) {

                                    $conn = accessBD();

                                    $sql = "Select * from sinistralidades where natureza LIKE '%" . $consulta_loc . "%'";
                                    $result = pg_query($conn, $sql);

                                    if ($result != FALSE) {
                                        while($arr = pg_fetch_array($result, NULL, PGSQL_ASSOC)) {
                            ?>
                                            <tr class="row100 body">
                                                <td class="cell100 column1"> <?php echo $arr["concelho"]?> </td>
                                                <td class="cell100 column2"> <?php echo $arr["datahora"]?> </td>
                                                <td class="cell100 column3"> <?php echo $arr["m"]?> </td>
                                                <td class="cell100 column4"> <?php echo $arr["fg"]?> </td>
                                                <td class="cell100 column5"> <?php echo $arr["km"]?> </td>
                                                <td class="cell100 column6"> <?php echo $arr["via"]?> </td>
                                                <td class="cell100 column7"> <?php echo $arr["natureza"]?> </td>
                                                <td class="cell100 column8"> <?php echo $arr["ig"]?> </td>
                                            </tr>
                                    <?php
                                        }
                                    }
                                }

                                pg_close($conn);
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
        </div>
    </div>


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