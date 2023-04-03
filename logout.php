<?php
    session_start();

    if (isset($_SESSION['nif'])) {
        unset($_SESSION['nif']);
    }

    if (isset($_SESSION['func'])) {
        unset($_SESSION['func']);
    }

    if (isset($_SESSION['rows'])) {
        unset($_SESSION['rows']);
    }

    header("Location: index.php");
    exit();
?>