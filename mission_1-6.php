<form action = "mission_1-6.php" method = "post">
  文字を入力して送信ボタンを押してください。<br/>
  下に入力した文字列をテキストファイルに保存します。<br/>
  <input type = "text" name = "q" />
  <input type = "submit" value = "送信" />
</form>

<?php
$q = $_POST["q"];
$q = htmlspecialchars($q);
$text_file = "kadai1-6.txt";
$fp = fopen($text_file, "a");
fwrite($fp, $q."\n");
fclose($fp);
?>