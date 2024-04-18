<?php

$configs = include('/home/protected/config.php');
include \Entry::class;

$db_dir = $configs['db_dir'];
$file = fopen($db_dir, 'rb+');

$filesize = filesize($db_dir);
if(!$file || !$filesize) {
    exit(1);
}

$free=intval(fread($file, PHP_INT_SIZE));
if($free === 0) {
    exit(1);
}

// The free pointer will always point towards EOF, or the next free list
if($free === $filesize) {
    fseek($file, $free);
}