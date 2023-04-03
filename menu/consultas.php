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
    <title>Main Menu</title>
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
    <link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/perfect-scrollbar/perfect-scrollbar.css">
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
        <div class="container-table100" >
            <div class="wrap-table100">
                <div class="table100 ver1 m-b-110"  style="width:50%; margin-left:280px;">
                    <div class="table100-head"  style="width:100%;">
                        <table>
                            <thead>
                                <tr class="row100 head">
                                    <th class="cell100 column1">Consultas Disponíveis:</th>
                                </tr>
                            </thead>
                        </table>
                    </div>

                    <div class="table100-body js-pscroll" style="width:100%;">
                        <table>
                            <tbody>
                                        <tr class="row100 body">
                                            <td class="cell100 column1"><a href="pontos_negros.php">Pontos Negros</a></td>
                                        </tr>
                                        <tr>
                                            <td class="cell100 column1"><a href="consulta_distrito.php">Sinistralidades por Distrito</a></td>
                                        </tr>
                                        <tr>
                                            <td class="cell100 column1"><a href="consulta_concelho.php">Sinistralidades por Concelho</a></td>
                                        </tr>
                                        <tr>
                                            <td class="cell100 column1"><a href="consulta_ano.php">Sinistralidades por Ano</a></td>
                                        </tr>
                                        <tr>
                                            <td class="cell100 column1"><a href="consulta_localidade.php">Sinistralidades por Localidades</a></td>
                                        </tr>
                                        <tr>
                                            <td class="cell100 column1"><a href="consulta_natureza.php">Sinistralidades por Natureza</a></td>
                                        </tr>
                                        <tr>
                                            <td class="cell100 column1"><a href="consulta_mortos.php">Acidentes com mortos por distrito por ano</a></td>
                                        </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
        </div>
    </div>


<!--===============================================================================================-->
    <script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
    <script src="vendor/bootstrap/js/popper.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
    <script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
    <script src="vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script>
        $('.js-pscroll').each(function(){
            var ps = new PerfectScrollbar(this);

            $(window).on('resize', function(){
                ps.update();
            })
        });


    </script>
<!--===============================================================================================-->
    <script src="js/main.js"></script>

</body>
</html>