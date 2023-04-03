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

    include_once('Config.php');

    $nif = $_POST['nif'];
    $username = $_POST['username'];
    $password =  $_POST['pass'];
    $func = $_POST['func'];

    $conn = accessBD();

    pg_query($conn, "BEGIN") or die("Could not start transaction\n");
    pg_query($conn, "SET TRANSACTION ISOLATION LEVEL SERIALIZABLE")
        or die("Could not start transaction\n");

    $sql = 'INSERT INTO users(nif_user, nome_usr, func, password) Values($1, $2, $3, $4)';

    $password = password_hash($password, PASSWORD_ARGON2I, ['memory_cost' => 1<<16,
    'time_cost' => 10, 'threads' => 4]);

    $result = pg_prepare($conn, "query", $sql);
    $result = pg_execute($conn, "query", array($nif, $username, $func, $password));

    if ($result != FALSE) {
        pg_query($conn, "COMMIT") or die("Transaction commit failed\n");
        header('Location: menu/menu_admin.php');
    }

    else {
        pg_query($conn, "ROLLBACK");
        $_SESSION['user_reg_error'] = true;
        header('Location: registo_utilizador.php');
    }

    pg_close($conn);
    exit();
?>