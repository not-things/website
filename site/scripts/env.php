<?php

const DATA_DIR = '/home/protected';
const CONFIG_DIR = '/home/protected';

// define("DATA_DIR", getcwd() . '/../../../protected/');
// define("CONFIG_DIR", getcwd() . '/../../../protected/');

function fail_if(bool $condition, string $message) : void {
    if($condition) {
        echo $message;
        exit(1);
    }
}