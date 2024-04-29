<?php

include("env.php");

set_error_handler(function () {
    exit();
}, E_WARNING | E_NOTICE);
$file = fopen(DATA_DIR . "/visitor_count.txt", "r+");
$contents = fread($file, filesize(DATA_DIR . "/visitor_count.txt"));
if($contents === false) {
    exit();
}
$visitor_count = intval($contents);
echo $visitor_count;
$visitor_count++;
fseek($file, 0);
fwrite($file, $visitor_count);
fclose($file);
