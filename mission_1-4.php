<form action = "mission_1-4.php">
  文字を入力して送信ボタンを押してください。<br/>
  下に入力した文字列を表示させます。<br/>
  <input type = "text" name = "q" />
  <input type = "submit" value = "送信" />
</form>

<?php
echo $_GET["q"];
?>