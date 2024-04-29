<?php

include ('../env.php');
$configs = include(CONFIG_DIR . '/visitor_db_config.php');
$idx = $_GET['idx'];
$db_dir = $configs['db_dir'];

if(!is_numeric($idx) || 4 * $idx > filesize($db_dir)) {
    echo "Invalid index";
    exit(1);
}

$file = fopen($db_dir, 'rb+');
fseek($file, $idx * 4);
$val = unpack("iint", fread($file, 4))['int'];
echo $val;
fseek($file, -$idx*4);
fwrite($file, pack("i",$val + 1));
fclose($file);