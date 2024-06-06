<?php

include("../env.php");

$data_file_name = DATA_DIR . '/messages';
$data = htmlspecialchars($_POST["message"]);
fail_if(strlen($data) > 200,'your message is too long' . strlen($data));
$data_fd = fopen($data_file_name, 'a');
fail_if($data_fd == FALSE, 'failed to upload your message');
$locked = flock($data_fd, LOCK_EX);
fail_if($locked == FALSE, 'failed to upload your message');
$index = filesize($data_file_name);
$msg = date("Y-m-d h:i:sa") . ' - ' . $data . PHP_EOL;
$return_value = fwrite($data_fd, $msg, strlen($msg));
fail_if($return_value == FALSE,'failed to upload your message');
fclose($data_fd);
// Forgot to handle the case where writing to this file succeeds but not the other
$index_file_name = DATA_DIR . '/messages_index';
$index_fd = fopen($index_file_name, 'a');
$locked = flock($index_fd, LOCK_EX);
fwrite($index_fd, $index . ',' . $return_value . PHP_EOL);
fclose($index_fd);
echo '<p>Success!</p>';
echo '<a href="../../messages.html">Back</a>';