<?php
    session_start();
    if (!isset($_SESSION['nif']) || !isset($_SESSION['func'])) {
        header("Location: index.php");
        exit();
    }

    if ($_SESSION['func'] != 2) {
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
                action="submit_user.php">
                    <?php
                        if(isset($_SESSION['user_reg_error'])):
                    ?>
                    <div class="invalido">
                        <p>ERRO: Utilizador com este NIF já existe.</p>
                    </div>
                    <?php
                    endif;
                        unset($_SESSION['user_reg_error']);
                    ?>
                    <span class="login100-form-title">
                        Novo Registo
                    </span>

                    <form action="submit_user.php" method="POST">
                        <label>NIF</label>
                        <div class="wrap-input100 validate-input">
                            <input class="input100" type="number" name="nif">
                            <span class="focus-input100"></span>
                        </div>

                        <label style="margin-top: 2em">Nome</label>
                        <div class="wrap-input100 validate-input">
                            <input class="input100" type="text" name="username">
                            <span class="focus-input100"></span>
                        </div>

                        <label style="margin-top: 2em">Password</label>
                        <div class="wrap-input100 validate-input">
                            <input class="input100" type="password" name="pass">
                            <span class="focus-input100"></span>
                        </div>

                        <label style="margin-top: 2em">Função</label>
                        <div class="wrap-input100 validate-input">
                            <select id="mySelect" class="select100" name="func">
                                <option value="0">Hospital/Polícia</option>
                                <option value="1">ANSR/Secretaria de Estado das Infraestruturas</option>
                                <option value="2">Administrador</option>
                            </select>
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