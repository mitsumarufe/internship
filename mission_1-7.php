<?php
$fp = fopen("kadai1-6.txt", "r");
while(!feof($fp)){ //feof関数はファイルの終端に達していない間ループ
  print fgets($fp)."<br />";
}
