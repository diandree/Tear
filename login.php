<?php
    session_start();

    include_once('Config.php');

    $nif = $_POST['nif'];
    $password =  $_POST['pass'];

    $conn = accessBD();

    $sql = 'Select password, func From users Where nif_user = $1';

    $result = pg_prepare($conn, "query", $sql);
    $result = pg_execute($conn, "query", array($nif));

    if ($result != FALSE) {
        $arr = pg_fetch_array($result, NULL, PGSQL_ASSOC);

        if (password_verify($password, $arr["password"])) {
            switch($arr["func"]) {
                case 0:
                    $_SESSION['nif'] = $nif;
                    $_SESSION['func'] = 0;
                    header('Location: menu/menu_utilizador.php');
                    break;
                case 1:
                    $_SESSION['nif'] = $nif;
                    $_SESSION['func'] = 1;
                    header('Location: menu/menu_asrn.php');
                    break;
                case 2:
                    $_SESSION['nif'] = $nif;
                    $_SESSION['func'] = 2;
                    header('Location: menu/menu_admin.php');
                    break;
            }
        }

        else {
            $_SESSION['nao_autenticado'] = true;
            header('Location: index.php');
        }
    }

    pg_close($conn);
    exit();
?>