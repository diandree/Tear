<?php
    session_start();
    if(!isset($_SESSION['nif'])){
        header("Location: index.php");
        exit();
    }

	$idget = $_REQUEST['id'];

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
            <div class="wrap-login100">
               <button style="background-color: #4CAF50;
  border: none;
  color: white;
  padding: 15px 32px;
  text-align: center;
  text-decoration: none;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;" onClick="window.print()">Imprimir</button>
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
                                    <th class="cell100 column1">Sinistralidade <?php echo $arr["cod_sin"]?></th>
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
                                $sql = "SELECT cod_sin,datahora,m,fg,via,km,natureza FROM  sinistralidades WHERE  cod_sin = $1;";

                                $result = pg_prepare($conn, "query", $sql);
                                $result = pg_execute($conn, "query", array($idget));

                                if ($result != FALSE) {
                                    while($arr = pg_fetch_array($result, NULL, PGSQL_ASSOC)) {
                            ?>
                                        <tr class="row100 body">
                                        <td class="cell100 column1" style="border: 1px solid #dddddd; font-weight: bold; font-size: 18px; color: black;">Codigo Ocorrência</td>
                                            <td class="cell100 column2" style="border: 1px solid #dddddd;"><?php echo $arr["cod_sin"]?></td>
                                        </tr>
                                        <tr class="row100 body">
                                            <td class="cell100 column2" style="border: 1px solid #dddddd; font-weight: bold; font-size: 18px; color: black;">Concelho</td>
                                            <td class="cell100 column3" style="border: 1px solid #dddddd;"> <?php echo $arr["concelho"]?> </td>
                                        </tr>
                                        <tr class="row100 body">
                                            <td class="cell100 column3" style="border: 1px solid #dddddd; font-weight: bold; font-size: 18px; color: black;">Data e Hora</td>
                                            <td class="cell100 column3" style="border: 1px solid #dddddd;"> <?php echo $arr["datahora"]?> </td>
                                        </tr>
                                        <tr class="row100 body">
                                           <td class="cell100 column4" style="border: 1px solid #dddddd; font-weight: bold; font-size: 18px; color: black;">Mortos</td>
                                            <td class="cell100 column4" style="border: 1px solid #dddddd;"> <?php echo $arr["m"]?> </td>
                                        </tr>
                                        <tr class="row100 body">
                                            <td class="cell100 column5" style="border: 1px solid #dddddd; font-weight: bold; font-size: 18px; color: black;">Feridos Graves</td>
                                            <td class="cell100 column5" style="border: 1px solid #dddddd;"> <?php echo $arr["fg"]?> </td>
                                        </tr>
                                        <tr class="row100 body">
                                            <td class="cell100 column6" style="border: 1px solid #dddddd; font-weight: bold; font-size: 18px; color: black;">Via</td>
                                            <td class="cell100 column6" style="border: 1px solid #dddddd;"> <?php echo $arr["via"]?> </td>
                                        </tr>
                                        <tr class="row100 body"> 
                                            <td class="cell100 column7" style="border: 1px solid #dddddd; font-weight: bold; font-size: 18px; color: black;">Km</td>                                        
                                            <td class="cell100 column7" style="border: 1px solid #dddddd;"> <?php echo $arr["km"]?> </td>
                                        </tr>
                                        <tr class="row100 body">
                                            <td class="cell100 column8" style="border: 1px solid #dddddd; font-weight: bold; font-size: 18px; color: black;">Natureza</td>
                                            <td class="cell100 column8" style="border: 1px solid #dddddd;"> <?php echo $arr["natureza"]?> </td>
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