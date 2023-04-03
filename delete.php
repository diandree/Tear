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

    $id = $_GET['id'];

    $conn = accessBD();

    pg_query($conn, "BEGIN") or die("Could not start transaction\n");

    $sql = 'DELETE From sinistralidades Where cod_sin = $1';

    $result = pg_prepare($conn, "query", $sql);
    $result = pg_execute($conn, "query", array($id));

    sleep(5);

    if ($result) {
        pg_query($conn, "COMMIT") or die("Transaction commit failed\n");
        header('Location: menu/menu_admin.php');
    }

    else {
        pg_query($conn, "ROLLBACK");
        $_SESSION['delete_error'] = true;
        header('Location: menu/menu_admin.php');
    }

    pg_close($conn);
    exit();
?>