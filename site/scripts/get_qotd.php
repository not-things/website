<?php

include("env.php");

/* Gets the quote of the day from a file */
//set_error_handler(function () {
//   exit();
//}, E_WARNING | E_NOTICE);
$file = fopen(DATA_DIR . "/quotes.txt", "r");
$quote_count = count(file(DATA_DIR . "/quotes.txt"));
/*Pick a random quote*/
$quote_i = rand(0, $quote_count - 1);
while ($quote_i-- > 0) {
    fgets($file, 4096);
}
$quote = fgets($file);
if($quote === false) {
    exit();
}
echo $quote;
fclose($file);
