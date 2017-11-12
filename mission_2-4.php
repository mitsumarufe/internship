<form action="mission_2-4.php" method="post">
  名前とコメントを入力し送信ボタンを押してください。<br/>
  名前：<br />
  <input type="text" name="name" size="30" value="" /><br />
  コメント：<br />
  <textarea name="comment" cols="30" rows="5"></textarea><br />
  <br />
  <input type="submit" value="送信" /><br />
  <br />
  削除対象番号：
  <input type="text" name="delete" size="10" value="" />
  <input type="submit" value="削除" />
</form>

<?php
  touch("kadai2-4.txt");
  $text_file = "kadai2-4.txt";
  $fp = fopen($text_file, "r+");
  $length = 9;
  $name = htmlspecialchars($_POST["name"],ENT_QUOTES);
  $comment = htmlspecialchars($_POST["comment"],ENT_QUOTES);
  $comment = str_replace(array("\r\n","\n","\r"), "<改行>", $comment);
  $time = date("Y/m/d H:i:s");
  $delete = htmlspecialchars($_POST["delete"],ENT_QUOTES);

  if ((empty($name) || empty($comment)) && empty($delete)) {
  echo "*未入力の項目があります。*<br>";
  }elseif((empty($name) || empty($comment)) && !empty($delete)){
  }else{
  if($fp){
    $count = fgets($fp, $length);
    $count++;
    rewind($fp);
    fwrite($fp, sprintf("%03d", $count));
    flock($fp, LOCK_UN);
  }
  fclose($fp);

  $data = $data." ".(sprintf("%03d", $count+1))."<>".$name."<>".$comment."<>".$time."\r\n";
  $memofile = "kadai2-4-2.txt";
  $fpp = fopen($memofile, "a");
  fwrite($fpp, $data);
  fclose($fpp);
  }
?>

<?php
  touch("kadai2-4-2.txt");
  $memofile = "kadai2-4-2.txt";
  $lines = file($memofile);
  $sakujomes = "kadai2-4-3.txt";
  $delete = htmlspecialchars($_POST["delete"],ENT_QUOTES);
  if (!empty($delete)){
    $n = 0;
    foreach($lines as $line){
      $keijiban = explode("<>", $line);
      if($keijiban[0] == sprintf("%03d", $delete)){
        $sakujo = file($memofile);
        unset($sakujo[$n]);
        file_put_contents($memofile, $sakujo);
        $fpp = fopen($sakujomes, "w");
        $sakujomessage = "~~~~~~<br>".sprintf("%03d", $delete)."番を削除しました。<br>";
        fwrite($fpp, $sakujomessage);
        fclose($fpp);
      }else{
        echo "番号:".$keijiban[0]." 名前:".$keijiban[1]." コメント:"
        .$keijiban[2]." 投稿時間:".$keijiban[3]."<br>";
      }
      $n++;
    }
  }else{
    foreach($lines as $line){
      $keijiban = explode("<>", $line);
      echo "番号:".$keijiban[0]." 名前:".$keijiban[1]." コメント:"
      .$keijiban[2]." 投稿時間:".$keijiban[3]."<br>";
    }
  }
  echo $sakujomessage;
?>