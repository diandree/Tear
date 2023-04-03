<?php
    $password = password_hash('saraiva', PASSWORD_ARGON2I, ['memory_cost' => 1<<16,
    'time_cost' => 10, 'threads' => 4]);

    echo $password;
?>