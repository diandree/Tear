<?php
    function accessBD() {
        // Fix password
        $conn = pg_connect("host=localhost port=5432 dbname=trabalho_1 user=postgres password=convem12345!");

        // Check connection
        if ($conn == FALSE) {
            die("Connection failed: " . $conn->connect_error);
        }

        return $conn;
    }
?>
