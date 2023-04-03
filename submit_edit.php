<?php
    session_start();
    if(!isset($_SESSION['nif'])) {
        header("Location: index.php");
        exit();
    }

    include_once('Config.php');

    $id = $_POST['id'];
    $datahora = $_POST['data'];
    $mortos = $_POST['mortos'];
    $feridos =  $_POST['feridos'];
    $km = $_POST['km'];
    $via = $_POST['via'];
    $natureza = $_POST['natureza'];

    $result = TRUE;
    $result_data = TRUE;
    $result_km = TRUE;
    $result_natureza = TRUE;
    $result_via = TRUE;
    $result_ig = TRUE;

    $conn = accessBD();

    pg_query($conn, "BEGIN") or die("Could not start transaction\n");
    pg_query($conn, "SET TRANSACTION ISOLATION LEVEL READ UNCOMMITTED")
        or die("Could not start transaction\n");

    $update_datahora =  'UPDATE sinistralidades SET datahora = $1 Where cod_sin = $2';
    $update_km =        'UPDATE sinistralidades SET km = $1 Where cod_sin = $2';
    $update_via =       'UPDATE sinistralidades SET via = $1 Where cod_sin = $2';
    $update_natureza =  'UPDATE sinistralidades SET natureza = $1 Where cod_sin = $2';
    $update_ig =        'UPDATE sinistralidades SET ig = (Select (fg*10 + m*100) from sinistralidades where cod_sin = $1) Where cod_sin = $1';
    $update_vitimas =   'UPDATE sinistralidades SET m = ' .
        'CASE WHEN ( (m+($1) >= 0) AND ( (@fg+($2))+(@m+($1)) = m+fg)) THEN m+($1) ELSE m END, ' .
        ' fg = ' .
        'CASE WHEN ( (fg+($2) >= 0) AND ( (@fg+($2))+(@m+($1)) = m+fg)) THEN fg+($2) ELSE fg END Where cod_sin = $3';

    if ($datahora !== "-1") {
        $result_data = pg_prepare($conn, "query_data", $update_datahora);
        $result_data = pg_execute($conn, "query_data", array($datahora, $id));
    }

    if ($km !== "-1") {
        $result_km = pg_prepare($conn, "query_km", $update_km);
        $result_km = pg_execute($conn, "query_km", array($km, $id));
    }

    if ($via !== "-1") {
        $result_via = pg_prepare($conn, "query_via", $update_via);
        $result_via = pg_execute($conn, "query_via", array($via, $id));
    }

    if ($natureza !== "-1") {
        $result_natureza = pg_prepare($conn, "query_natureza", $update_natureza);
        $result_natureza = pg_execute($conn, "query_natureza", array($natureza, $id));
    }

    if ($mortos !== "0" && $feridos !== "0") {
        $result = pg_prepare($conn, "query", $update_vitimas);
        $result = pg_execute($conn, "query", array($mortos, $feridos, $id));

        $result_ig = pg_prepare($conn, "query_ig", $update_ig);
        $result_ig = pg_execute($conn, "query_ig", array($id));
    }

    sleep(5);

    if ($result && $result_data && $result_km && $result_natureza && $result_via && $result_ig) {
        pg_query($conn, "COMMIT") or die("Transaction commit failed\n");
    }

    else {
        pg_query($conn, "ROLLBACK");
        $_SESSION['edit_reg_error'] = true;
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