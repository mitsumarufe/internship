<form action = "mission_1-6.php" method = "post">
  ��������͂��đ��M�{�^���������Ă��������B<br/>
  ���ɓ��͂�����������e�L�X�g�t�@�C���ɕۑ����܂��B<br/>
  <input type = "text" name = "q" />
  <input type = "submit" value = "���M" />
</form>

<?php
$q = $_POST["q"];
$q = htmlspecialchars($q);
$text_file = "kadai1-6.txt";
$fp = fopen($text_file, "a");
fwrite($fp, $q."\n");
fclose($fp);
?>