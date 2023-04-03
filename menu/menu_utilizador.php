<?php
    session_start();
    if (!isset($_SESSION['nif']) || $_SESSION['func'] != 0) {
        header("Location: ../index.php");
        exit();
    }

    $last = false;

    if (!isset($_SESSION['rows']) || isset($_POST['but_first'])) {
        $_SESSION['rows']=0;
    }

    if (isset($_POST['but_next'])) {
        $_SESSION['rows']+=10;
    }

    if (isset($_POST['but_prev']) && $_SESSION['rows'] > 0) {
        $_SESSION['rows']-=10;
    }

    if (isset($_POST['but_last'])) {
        $last = true;
        unset($_SESSION['but_last']);
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
        <a href="../novo_registo.php">Novo Registo</a>
        <a href="../logout.php">Logout</a>
    </div>
    <?php
        if(isset($_SESSION['novo_reg_error'])):
    ?>
    <div class="invalido">
        <p>ERRO: Não foi possível registar nova sinistralidade. Tente novamente.</p>
    </div>
    <?php
        endif;
        unset($_SESSION['novo_reg_error']);
    ?>
    <?php
        if(isset($_SESSION['edit_reg_error'])):
    ?>
    <div class="invalido">
        <p>ERRO: Não foi possível editar o registo. Tente novamente.</p>
    </div>
    <?php
        endif;
        unset($_SESSION['edit_reg_error']);
    ?>
    <?php
        if(isset($_SESSION['edit_deleted_error'])):
    ?>
    <div class="invalido">
        <p>ERRO: Registo que tentou alterar foi apagado.</p>
    </div>
    <?php
        endif;
        unset($_SESSION['edit_deleted_error']);
    ?>
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
                                    <th class="cell100 column9"></th>
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
                                $sql = 'Select * From sinistralidades Order by cod_sin LIMIT 10 OFFSET $1';

                                if ($last) {
                                    $sql2 = 'SELECT count(*) as num_rows FROM sinistralidades';

                                    $result = pg_query($conn, $sql2);
                                    if ($result != FALSE) {
                                        $arr = pg_fetch_array($result, NULL, PGSQL_ASSOC);
                                        $_SESSION['rows'] = $arr["num_rows"]-10;
                                    }
                                }

                                $result = pg_prepare($conn, "query", $sql);
                                $result = pg_execute($conn, "query", array($_SESSION['rows']));

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
                                            <td class="cell100 column9"> <?php echo "<a href='../edit.php?id=".
                                                $arr["cod_sin"]."'>Edit</a>"?> </td>
                                        </tr>
                                <?php
                                    }
                                }

                                pg_close($conn);
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div style="display: flex; flex-direction: row; align-items: center; justify-content: center; margin-top: 2em">
                    <form method="post" action="">
                        <button>
                            Previous 10
                        </button>
                        <input type="hidden" class="button" name="but_prev" value="10">
                    </form>
                    <form method="post" action="">
                        <button style="margin-left: 3em">
                            Next 10
                        </button>
                        <input type="hidden" class="button" name="but_next" value="10">
                    </form>
                    <form method="post" action="">
                        <button style="margin-left: 3em">
                            First 10
                        </button>
                        <input type="hidden" class="button" name="but_first">
                    </form>
                    <form method="post" action="">
                        <button style="margin-left: 3em">
                            Last 10
                        </button>
                        <input type="hidden" class="button" name="but_last">
                    </form>
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
