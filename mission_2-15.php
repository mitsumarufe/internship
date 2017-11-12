
<?php
  $dsn = 'データベース名';
  $usr = 'ユーザー名';
  $pass = 'パスワード';
  try{
    $pdo = new PDO($dsn,$usr,$pass);
    print('<br>');
    if ($pdo == null){
      print('接続に失敗しました。<br>');
    }else{
      print('接続に成功しました。<br>');
    }
    $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    //テーブルが存在しなければ作成
    $sql = "CREATE TABLE IF NOT EXISTS `board`"
    ."("
    . "`id` INT auto_increment primary key,"
    . "`name` TEXT,"
    . "`comment` TEXT,"
    . "`time` TIMESTAMP,"
    . "`sendpass` TEXT"
    .");";
    $stmt = $pdo -> prepare($sql);
    $stmt -> execute();
  }catch (PDOException $e){
    $err_msg = "エラー：". $e->getMessage();
  }
?>

<?php

  $dsn = 'データベース名';
  $usr = 'ユーザー名';
  $pass = 'パスワード';

  $name = htmlspecialchars($_POST["name"],ENT_QUOTES);
  $comment = htmlspecialchars($_POST["comment"],ENT_QUOTES);
  $comment = str_replace(array("\r\n","\n","\r"), "//", $comment);
  $delete = htmlspecialchars($_POST["delete"],ENT_QUOTES);
  $edit = htmlspecialchars($_POST["edit"],ENT_QUOTES);
  $sendpass = htmlspecialchars($_POST["sendpass"],ENT_QUOTES);
  $delpass = htmlspecialchars($_POST["delpass"],ENT_QUOTES);
  $editpass = htmlspecialchars($_POST["editpass"],ENT_QUOTES);
  $hensyu = "toukou";
  if($_POST["send"] == "送信"){
    if($_POST["hensyu"] == "toukou"){ //普通に送信を押したとき
      if(!empty($name) && !empty($comment) && !empty($sendpass)){
        try{
          $pdo = new PDO($dsn,$usr,$pass);
          $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
          $pdo->beginTransaction();

          $sql = "INSERT INTO board (id, name, comment, time, sendpass) VALUES (null, :name, :comment, now(), :sendpass)";
          $stmt = $pdo->prepare($sql);
          $params = array(':name' => $name, ':comment' => $comment, ':sendpass' => $sendpass);
          $stmt->execute($params);
          $id = $pdo->lastInsertId('id');
          $pdo->commit();
        }catch (PDOException $e){
          $pdo->rollBack;
          $err_msg = "エラー：". $e->getMessage();
        }
      }else{
        $errormes = "*未入力の項目があります。*<br>";
      }
    }
  }

?>

<?php

  $dsn = 'データベース名';
  $usr = 'ユーザー名';
  $pass = 'パスワード';

  if($_POST["send"] == "送信"){
    if($_POST["hensyu"] == "henkou"){ //編集番号入力後送信を押したとき
      if(!empty($name) && !empty($comment) && !empty($sendpass)){
        $editnum = $_POST["editnum"];
        try{
          $pdo = new PDO($dsn,$usr,$pass);
          $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

          $pdo->beginTransaction();
          $update = "UPDATE board SET name = :name, comment = :comment, time = now(), sendpass = :sendpass WHERE id = :id";
          $stmtu = $pdo->prepare($update);
          $paramsu = array(':name' => $name, ':comment' => $comment, ':sendpass' => $sendpass, ':id' => $editnum);
          $stmtu->execute($paramsu);
          $pdo->commit();
        }catch (PDOException $e){
          $pdo->rollBack;
          $err_msg = "エラー：". $e->getMessage();
        }
      }else{
        $errormes = "*未入力の項目があります。*<br>";
      }
    }
  }

?>

<?php
  $dsn = 'データベース名';
  $usr = 'ユーザー名';
  $pass = 'パスワード';

  if($_POST["delsend"] == "削除"){ //削除番号入力時
    if(!empty($delete) && !empty($delpass)){
      try{
        $pdo = new PDO($dsn,$usr,$pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

        $pdo->beginTransaction();
        $sql = "SELECT * FROM board";
        $result = $pdo->query($sql);
        foreach($result as $row){
          $sendpass = $row['sendpass'];
          $sql = "DELETE FROM board WHERE id = :id";
          if($sendpass == $delpass){
            $sakujomessage = "~~~~~~<br>".$delete."番を削除しました。<br>";
            $stmtd = $pdo->prepare($sql);
            $paramsd = array(':id' => $delete);
            $stmtd->execute($paramsd);
          }
        }

        $pdo->commit();
      }catch (PDOException $e){
        $pdo->rollBack;
        $err_msg = "エラー：". $e->getMessage();
      }
    }else{
      $errormes = "*未入力の項目があります。*<br>";
    }
  }

?>

<?php

  if($_POST["editsend"] == "編集"){ //編集番号入力時
    if(!empty($edit) && !empty($editpass)){
      try{
        $pdo = new PDO($dsn,$usr,$pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

        $pdo->beginTransaction();
        $sql = "SELECT * FROM board";
        $result = $pdo->query($sql);
        foreach($result as $row){
          $sendpass = $row['sendpass'];
          if($sendpass == $editpass){
            $editnum = $row['id'];
            $editname = $row['name'];
            $editcomment = $row['comment'];
            $editpass = $row['sendpass'];
            $hensyu = "henkou";
            $hensyumessage = $edit."番を編集します。<br>";
          }
        }

    $pdo->commit();
  }catch (PDOException $e){
    $pdo->rollBack;
    $errmsg = "エラー<br>". $e->getMessage();
  }

    }else{
    $errormes = "*未入力の項目があります。*<br>";
    }
  }

?>

<form action="mission_2-15.php" method="post" name="<?php echo $hensyu; ?>">
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
  $dsn = 'データベース名';
  $usr = 'ユーザー名';
  $pass = 'パスワード';

  try{
    $pdo = new PDO($dsn,$usr,$pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

    $pdo->beginTransaction();
    $board = "SELECT * FROM board";
    echo $errormes; //エラーメッセージ
    $result = $pdo->query($board);
    foreach($result as $row){
      echo '番号：'.$row['id'].' ';
      echo '名前：'.$row['name'].' ';
      echo 'コメント：'.$row['comment'].' ';
      echo '投稿時間：'.$row['time'].'<br>';
    }
    echo $sakujomessage; //削除時のメッセージ
    $pdo->commit();
  }catch (PDOException $e){
    $pdo->rollBack;
    $errmsg = "エラー<br>". $e->getMessage();
  }
  $pdo = null;
  echo $connect;

?>
