<?php

include("../env.php");
// $count = $_GET['count'];

$data_file_name = DATA_DIR . '/messages';
$index_file_name = DATA_DIR . '/messages_index';

$fd = fopen($data_file_name, "r");
flock($fd, LOCK_SH);
$index_fd = fopen($index_file_name, 'r');
flock($index_fd, LOCK_SH);

if ($fd) {
    while (($line = fgets($index_fd)) !== false) {
        list($idx, $len) = explode(',',$line);
        fseek($fd, $idx, SEEK_SET);
        $msg = fread($fd, $len);
        echo $msg;
    }   
    fclose($fd);
    fclose($index_fd);

}