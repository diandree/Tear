<?php
    session_start();
    if(!isset($_SESSION['nif'])){
        header("Location: index.php");
        exit();
    }

    if (isset($_POST['distrito_consulta'])){
        $consulta_dis =  $_POST['distrito_consulta'];
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
        <a href="ocorrencias.php">Relatório Ocorrência</a>
        <a href="../logout.php">Logout</a>
</div>

    <div class="limiter">
        <div class="container-login100">
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
                                    <th class="cell100 column1">Codigo sinistralidade</th>
                                    <th class="cell100 column1">Concelho</th>
                                    <th class="cell100 column2">Data e Hora</th>
                                </tr>
                            </thead>
                        </table>
                    </div>

                    <div class="table100-body js-pscroll">
                        <table>
                            <tbody>
                            <?php
                                include_once('../Config.php');

                                $conn = accessBD();
                                $sql = "SELECT cod_sin, concelho, datahora FROM sinistralidades;";

                                $result = pg_prepare($conn, "query", $sql);
                                $result = pg_execute($conn, "query", array());

                                if ($result != FALSE) {
                                    while($arr = pg_fetch_array($result, NULL, PGSQL_ASSOC)) {
                            ?>
                                        <tr class="row100 body">
                                            <td class="cell100 column1"><a href="<?php echo 'print_relatorio.php?id='.$arr["cod_sin"]?>"> <?php echo $arr["cod_sin"]?></a></td>
                                            <td class="cell100 column1"> <?php echo $arr["concelho"]?> </td>
                                            <td class="cell100 column2"> <?php echo $arr["datahora"]?> </td>
                                        </tr>
                                <?php
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