<?php
    session_start();
    if(!isset($_SESSION['nif'])) {
        header("Location: index.php");
        exit();
    }

    include_once('Config.php');

    $concelho = $_POST['concelho'];
    $datahora = $_POST['data'];
    $mortos = $_POST['mortos'];
    $feridos =  $_POST['feridos'];
    $km = $_POST['km'];
    $via = $_POST['via'];
    $natureza = $_POST['natureza'];
    $ig = $_POST['ig'];

    $conn = accessBD();

    pg_query($conn, "BEGIN") or die("Could not start transaction\n");
    pg_query($conn, "SET TRANSACTION ISOLATION LEVEL SERIALIZABLE")
        or die("Could not start transaction\n");

    $sql = 'INSERT INTO sinistralidades(concelho, datahora, m, fg, km, via, natureza, ig)'
    . 'Values($1,$2,$3,$4,$5,$6,$7,$8) RETURNING cod_sin as cod_sin';

    $result = pg_prepare($conn, "query", $sql);
    $result = pg_execute($conn, "query", array($concelho, $datahora, $mortos, $feridos, $km,
        $via, $natureza, $ig));

    sleep(5);

    if ($result) {
        pg_query($conn, "COMMIT") or die("Transaction commit failed\n");
    }

    else {
        pg_query($conn, "ROLLBACK");
        $_SESSION['novo_reg_error'] = true;
    }

    if ($_SESSION['func'] == 0) {
        header('Location: menu/menu_utilizador.php');
    }

    if ($_SESSION['func'] == 2) {
        header('Location: menu/menu_admin.php');
    }

    pg_close($conn);
    exit();
?>