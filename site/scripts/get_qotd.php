<?php

/* Gets the quote of the day from a file */
//set_error_handler(function () {
//    exit();
//}, E_WARNING | E_NOTICE);
$file = fopen("/home/protected/quotes.txt", "r");
$quote_count = count(file("/home/protected/quotes.txt"));
/*Pick a random quote*/
$quote_i = rand(0, $quote_count - 1);
while ($quote_i-- > 0) {
    fgets($file, 4096);
}
$quote = fgets($file);
if($quote === false) {
    echo "";
    exit();
}
echo $quote;
fclose($file);
