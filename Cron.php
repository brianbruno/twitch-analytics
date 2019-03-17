<?php
date_default_timezone_set('America/Sao_Paulo');

while(true) {
    $command = "php artisan schedule:run";
    exec($command, $output, $return_var);
    echo "Time 4 Cron! ".date('d/m/Y H:i:s')."\n";
    sleep(58);
}