<form action="mission_2-3.php" method="post">
  名前とコメントを入力し送信ボタンを押してください。<br/>
  名前：<br />
  <input type="text" name="name" size="30" value="" /><br />
  コメント：<br />
  <textarea name="comment" cols="30" rows="5"></textarea><br />
  <br />
  <input type="submit" value="送信" />
</form>

<?php
  $memofile = "kadai2-2-2.txt";
  $lines = file($memofile);
  foreach($lines as $line){
  $keijiban = explode("<>", $line);
  echo "番号:".$keijiban[0]."名前:".$keijiban[1]."コメント:".$keijiban[2]."投稿時間:".$keijiban[3]."<br>";
}
?>