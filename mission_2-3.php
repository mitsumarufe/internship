<form action="mission_2-3.php" method="post">
  ���O�ƃR�����g����͂����M�{�^���������Ă��������B<br/>
  ���O�F<br />
  <input type="text" name="name" size="30" value="" /><br />
  �R�����g�F<br />
  <textarea name="comment" cols="30" rows="5"></textarea><br />
  <br />
  <input type="submit" value="���M" />
</form>

<?php
  $memofile = "kadai2-2-2.txt";
  $lines = file($memofile);
  foreach($lines as $line){
  $keijiban = explode("<>", $line);
  echo "�ԍ�:".$keijiban[0]."���O:".$keijiban[1]."�R�����g:".$keijiban[2]."���e����:".$keijiban[3]."<br>";
}
?>