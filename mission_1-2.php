<?php
$filename = 'kadai2.txt';
//echo $filename;

$fp = fopen($filename, 'w');

fwrite($fp, 'Hello world');

fclose($fp);

?>