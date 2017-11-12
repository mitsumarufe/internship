<form action="mission_2-2.php" method="post">
  名前とコメントを入力し送信ボタンを押してください。<br/>
  名前：<br />
  <input type="text" name="name" size="30" value="" /><br />
  コメント：<br />
  <textarea name="comment" cols="30" rows="5"></textarea><br />
  <br />
  <input type="submit" value="送信" />
</form>

<?php
  touch("kadai2-2.txt");
  $text_file = "kadai2-2.txt";
  $fp = fopen($text_file, "r+");
  $length = 9;
  if($fp){
    $count = fgets($fp, $length);
    $count++;
    rewind($fp);
    fwrite($fp, sprintf("%03d", $count));
    flock($fp, LOCK_UN);
  }
  fclose($fp);

  $name = htmlspecialchars($_POST["name"],ENT_QUOTES);
  $comment = htmlspecialchars($_POST["comment"],ENT_QUOTES);
  $comment = str_replace(array("\r\n","\n","\r"), "<改行>", $comment);
  $time = date("Y/m/d H:i:s");
  $data = $data." ".(sprintf("%03d", $count)+1)."<>".$name."<>"
  .$comment."<>".$time."\r\n";
  $memofile = "kadai2-2-2.txt";
  $fpp = fopen($memofile, "a");
  fwrite($fpp, $data);
  fclose($fpp);
?>