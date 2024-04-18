<?php

$ENTRY_SIZE = 3;

return array(
    "db_dir" => "/home/protected/visitor_db",
    "entry_size" => $ENTRY_SIZE,
    "get_entry" => function (int $idx, $fp) {
        // fp should point to the first index
        global $ENTRY_SIZE;
        return fseek($fp, $idx * $ENTRY_SIZE);
    },
    "set_entry" => function (int $idx, $fp, string $data) {
        global $ENTRY_SIZE;
        return fwrite($fp, $data, $ENTRY_SIZE);
    }
);