<?php

$configs = include('/home/protected/config.php');
$idx = $_GET['index'];
if(!is_numeric($idx)) {
    echo "Invalid name";
    exit(1);
}
$db_dir = $configs['db_dir'];
$file = fopen($db_dir, 'rb+');
/* Skip the freelist pointer */
fseek($file, 1);

fseek($file, $idx);