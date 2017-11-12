<?php
  touch("kadai2-5-1.txt");
  $text_file = "kadai2-5-1.txt";
  touch("kadai2-5-2.txt");
  $memofile = "kadai2-5-2.txt";
  $sakujomes = "kadai2-5-3.txt";
  $hensyumes = "kadai2-5-4.txt";
  $lines = file($memofile);
  $length = 9;
  $name = htmlspecialchars($_POST["name"],ENT_QUOTES);
  $comment = htmlspecialchars($_POST["comment"],ENT_QUOTES);
  $comment = str_replace(array("\r\n","\n","\r"), "//", $comment);
  $time = date("Y/m/d H:i:s");
  $delete = htmlspecialchars($_POST["delete"],ENT_QUOTES);
  $edit = htmlspecialchars($_POST["edit"],ENT_QUOTES);
  $hensyu = "toukou";
  $fp = fopen($text_file, "r+");
  if ((empty($name) || empty($comment)) && empty($delete) && empty($edit)) {
    $errormes = "*未入力の項目があります。*<br>";
  }elseif((empty($name) || empty($comment)) && !empty($delete)){
  }elseif((empty($name) || empty($comment)) && !empty($edit)){
  }
  if($_POST["send"] == "送信"){
  if(!empty($name) || !empty($comment)){
    if($_POST["hensyu"] == "toukou"){ //普通に送信を押したとき
      if($fp){
        $count = fgets($fp, $length);
        $count++;
        rewind($fp);
        fwrite($fp, sprintf("%03d", $count));
        flock($fp, LOCK_UN);
      } //カウント
      fclose($fp);
      $data = $data." ".(sprintf("%03d", $count+1))."<>".$name."<>".$comment."<>".$time."\r\n";
      $fp2 = fopen($memofile, "a");
      fwrite($fp2, $data);
      fclose($fp2);
    }
    }elseif($_POST["hensyu"] == "henkou"){ //編集番号入力後送信を押したとき
      $n = 0;
      $editnum = $_POST["editnum"];
      foreach($lines as $line){
        $keijiban = explode("<>", $line);
        if($keijiban[0] == $editnum){
          $newdata = file($memofile);
          $newdata[$n] = " ".$editnum."<>".$name."<>".$comment."<>".$time."\r\n"; //編集番号の配列を書き換える
          file_put_contents($memofile, $newdata); //配列置換
        }
        $n++;
      }
    }
  }elseif($_POST["delsend"] == "削除"){ //削除番号入力時
    $n = 0;
    foreach($lines as $line){
      $keijiban = explode("<>", $line);
      if($keijiban[0] == sprintf("%03d", $delete)){
        $sakujo = file($memofile);
        unset($sakujo[$n]); //配列消去
        file_put_contents($memofile, $sakujo); //配列消去したものを置換(=消える)
        $fpp = fopen($sakujomes, "w");
        $sakujomessage = "~~~~~~<br>".sprintf("%03d", $delete)."番を削除しました。<br>";
        fwrite($fpp, $sakujomessage);
        fclose($fpp);
      }
      $n++;
    }
  }elseif($_POST["edisend"] == "編集"){ //編集番号入力時
    $n = 0;
    $hensyu = "henkou";
    foreach($lines as $line){
      $keijiban = explode("<>", $line);
      if($keijiban[0] == sprintf("%03d", $edit)){
        $editno = $keijiban[0];
        $editnum = $editno;
        $editname = $keijiban[1];
        $editcomment = $keijiban[2];
        $editcomment = str_replace("//", "\r\n", $editcomment);
        $edittime = $keijiban[3];
        $fpp = fopen($hensyumes, "w");
        $hensyumessage = sprintf("%03d", $edit)."番を編集します。<br>";
        fwrite($fpp, $hensyumessage);
        fclose($fpp);
      }
      $n++;
    }
  }
?>



<form action="mission_2-5.php" method="post" name="<?php echo $hensyu; ?>">
  名前とコメントを入力し送信ボタンを押してください。<br/>
  <?php echo $hensyumessage; /*編集時のメッセージ*/ ?>
  名前：<br />
  <input type="text" name="name" size="30" value="<?php echo $editname; ?>" /><br />
  コメント：<br />
  <textarea name="comment" cols="30" rows="5"><?php echo $editcomment; ?></textarea><br />
  <br />
  <input type="submit" name= "send" value="送信" /><br />
  <br />
  削除対象番号：
  <input type="text" name="delete" size="10" value="" />
  <input type="submit" name="delsend" value="削除" /><br />
  編集対象番号：
  <input type="text" name="edit" size="10" value="" />
  <input type="submit" name="edisend" value="編集" />
  <input type="hidden" name="hensyu" value="<?php echo $hensyu; ?>" />
  <input type="hidden" name="editnum" value="<?php echo $editnum; ?>" />
</form>

<?php
  touch("kadai2-5-2.txt");
  $memofile = "kadai2-5-2.txt";
  $lines = file($memofile);
  echo $errormes; //未入力のエラーメッセージ
  foreach($lines as $line){
    $keijiban = explode("<>", $line);
    echo "番号:".$keijiban[0]." 名前:".$keijiban[1]." コメント:"
    .$keijiban[2]." 投稿時間:".$keijiban[3]."<br>";
  }
  echo $sakujomessage; //削除時のメッセージ
?>
