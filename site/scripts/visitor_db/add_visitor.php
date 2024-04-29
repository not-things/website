<?php

include ('../env.php');
$configs = include(CONFIG_DIR . '/visitor_db_config.php');
$db_dir = $configs['db_dir'];
$file = fopen($db_dir, 'rb+');
if(!$file) {
    echo "err";
    exit(1);
}
$filesize = filesize($db_dir);

fseek($file, $filesize);
fwrite($file, pack("i", 0));

echo $filesize / 4;
