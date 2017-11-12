<?php
  touch("kadai2-6-1.txt");
  $text_file = "kadai2-6-1.txt";
  touch("kadai2-6-2.txt");
  $memofile = "kadai2-6-2.txt";
  $sakujomes = "kadai2-6-3.txt";
  $hensyumes = "kadai2-6-4.txt";
  $lines = file($memofile);
  $length = 9;
  $name = htmlspecialchars($_POST["name"],ENT_QUOTES);
  $comment = htmlspecialchars($_POST["comment"],ENT_QUOTES);
  $comment = str_replace(array("\r\n","\n","\r"), "//", $comment);
  $time = date("Y/m/d H:i:s");
  $delete = htmlspecialchars($_POST["delete"],ENT_QUOTES);
  $edit = htmlspecialchars($_POST["edit"],ENT_QUOTES);
  $sendpass = htmlspecialchars($_POST["sendpass"],ENT_QUOTES);
  $delpass = htmlspecialchars($_POST["delpass"],ENT_QUOTES);
  $editpass = htmlspecialchars($_POST["editpass"],ENT_QUOTES);

  $hensyu = "toukou";
  $fp = fopen($text_file, "r+");
  if($_POST["send"] == "送信"){
    if($_POST["hensyu"] == "toukou"){ //普通に送信を押したとき
      if(!empty($name) && !empty($comment) && !empty($sendpass)){
        if($fp){
          $count = fgets($fp, $length);
          $count++;
          rewind($fp);
          fwrite($fp, sprintf("%03d", $count));
          flock($fp, LOCK_UN);
        } //カウント
        fclose($fp);
        $data = $data." ".(sprintf("%03d", $count+1))."<>".$name."<>".$sendpass."<>".$comment."<>".$time."\r\n";
        $fp2 = fopen($memofile, "a");
        fwrite($fp2, $data);
        fclose($fp2);
      }else{
        $errormes = "*未入力の項目があります。*<br>";
      }
    }elseif($_POST["hensyu"] == "henkou"){ //編集番号入力後送信を押したとき
      $n = 0;
      $editnum = $_POST["editnum"];
      foreach($lines as $line){
        $keijiban = explode("<>", $line);
        if($keijiban[0] == $editnum){
          $newdata = file($memofile);
          $newdata[$n] = $editnum."<>".$name."<>".$sendpass."<>".$comment."<>".$time."\r\n"; //編集番号の配列を書き換える
          file_put_contents($memofile, $newdata); //配列置換
          $newpass = file($passfile);
          $newpass[$n] == $sendpass;
          file_put_contents($passfile, $newpass);
        }
        $n++;
      }
    }
  }elseif($_POST["delsend"] == "削除"){ //削除番号入力時
    $n = 0;
    foreach($lines as $line){
      $keijiban = explode("<>", $line);
      if($keijiban[2] == $delpass){
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
    }
    if(empty($sakujomessage)){
      $errormes = "番号またはパスワードが間違っています。<br>";
    }
  }elseif($_POST["editsend"] == "編集"){ //編集番号入力時
    $n = 0;
    $hensyu = "henkou";
    foreach($lines as $line){
      $keijiban = explode("<>", $line);
      if($keijiban[2] == $editpass){
        if($keijiban[0] == sprintf("%03d", $edit)){
          $editno = $keijiban[0];
          $editnum = $editno;
          $editname = $keijiban[1];
          $editcomment = $keijiban[3];
          $editcomment = str_replace("//", "\r\n", $editcomment);
          $edittime = $keijiban[4];
          $fpp = fopen($hensyumes, "w");
          $hensyumessage = sprintf("%03d", $edit)."番を編集します。<br>";
          fwrite($fpp, $hensyumessage);
          fclose($fpp);
        }
      $n++;
      }
    }
    if(empty($hensyumessage)){
      $errormes = "番号またはパスワードが間違っています。<br>";
    }
  }
?>

<form action="mission_2-6.php" method="post" name="<?php echo $hensyu; ?>">
  名前とコメントを入力し送信ボタンを押してください。<br/>
  <?php echo $hensyumessage; /*編集時のメッセージ*/ ?>
  名前：<br />
  <input type="text" name="name" size="30" value="<?php echo $editname; ?>" /><br />
  コメント：<br />
  <textarea name="comment" cols="30" rows="5"><?php echo $editcomment; ?></textarea><br />
  パスワード：
  <input type="password" name="sendpass" inputmode="verbatim" placeholder="半角英数4～8字" minlength="4" maxlength="8">
  <input type="submit" name= "send" value="送信" /><br />
  <br />
  削除対象番号：
  <input type="text" name="delete" size="5" value="" /><br />
  パスワード：
  <input type="password" name="delpass" inputmode="verbatim" placeholder="半角英数4～8字" minlength="4" maxlength="8">
  <input type="submit" name="delsend" value="削除" /><br />
  編集対象番号：
  <input type="text" name="edit" size="5" value="" /><br />
  パスワード：
  <input type="password" name="editpass" inputmode="verbatim" placeholder="半角英数4～8字" minlength="4" maxlength="8">
  <input type="submit" name="editsend" value="編集" />
  <input type="hidden" name="hensyu" value="<?php echo $hensyu; ?>" />
  <input type="hidden" name="editnum" value="<?php echo $editnum; ?>" />
</form>

<?php
  touch("kadai2-6-2.txt");
  $memofile = "kadai2-6-2.txt";
  $lines = file($memofile);
  echo $errormes; //未入力のエラーメッセージ
  foreach($lines as $line){
    $keijiban = explode("<>", $line);
    echo "番号:".$keijiban[0]." 名前:".$keijiban[1]." コメント:".$keijiban[3]." 投稿時間:".$keijiban[4]."<br>";
  }
  echo $sakujomessage; //削除時のメッセージ
?>
