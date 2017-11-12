
<?php
  $dsn = '�f�[�^�x�[�X��';
  $usr = '���[�U�[��';
  $pass = '�p�X���[�h';
  try{
    $pdo = new PDO($dsn,$usr,$pass);
    print('<br>');
    if ($pdo == null){
      print('�ڑ��Ɏ��s���܂����B<br>');
    }else{
      print('�ڑ��ɐ������܂����B<br>');
    }
    $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    //�e�[�u�������݂��Ȃ���΍쐬
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
    $err_msg = "�G���[�F". $e->getMessage();
  }
?>

<?php

  $dsn = '�f�[�^�x�[�X��';
  $usr = '���[�U�[��';
  $pass = '�p�X���[�h';

  $name = htmlspecialchars($_POST["name"],ENT_QUOTES);
  $comment = htmlspecialchars($_POST["comment"],ENT_QUOTES);
  $comment = str_replace(array("\r\n","\n","\r"), "//", $comment);
  $delete = htmlspecialchars($_POST["delete"],ENT_QUOTES);
  $edit = htmlspecialchars($_POST["edit"],ENT_QUOTES);
  $sendpass = htmlspecialchars($_POST["sendpass"],ENT_QUOTES);
  $delpass = htmlspecialchars($_POST["delpass"],ENT_QUOTES);
  $editpass = htmlspecialchars($_POST["editpass"],ENT_QUOTES);
  $hensyu = "toukou";
  if($_POST["send"] == "���M"){
    if($_POST["hensyu"] == "toukou"){ //���ʂɑ��M���������Ƃ�
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
          $err_msg = "�G���[�F". $e->getMessage();
        }
      }else{
        $errormes = "*�����͂̍��ڂ�����܂��B*<br>";
      }
    }
  }

?>

<?php

  $dsn = '�f�[�^�x�[�X��';
  $usr = '���[�U�[��';
  $pass = '�p�X���[�h';

  if($_POST["send"] == "���M"){
    if($_POST["hensyu"] == "henkou"){ //�ҏW�ԍ����͌㑗�M���������Ƃ�
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
          $err_msg = "�G���[�F". $e->getMessage();
        }
      }else{
        $errormes = "*�����͂̍��ڂ�����܂��B*<br>";
      }
    }
  }

?>

<?php
  $dsn = '�f�[�^�x�[�X��';
  $usr = '���[�U�[��';
  $pass = '�p�X���[�h';

  if($_POST["delsend"] == "�폜"){ //�폜�ԍ����͎�
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
            $sakujomessage = "~~~~~~<br>".$delete."�Ԃ��폜���܂����B<br>";
            $stmtd = $pdo->prepare($sql);
            $paramsd = array(':id' => $delete);
            $stmtd->execute($paramsd);
          }
        }

        $pdo->commit();
      }catch (PDOException $e){
        $pdo->rollBack;
        $err_msg = "�G���[�F". $e->getMessage();
      }
    }else{
      $errormes = "*�����͂̍��ڂ�����܂��B*<br>";
    }
  }

?>

<?php

  if($_POST["editsend"] == "�ҏW"){ //�ҏW�ԍ����͎�
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
            $hensyumessage = $edit."�Ԃ�ҏW���܂��B<br>";
          }
        }

    $pdo->commit();
  }catch (PDOException $e){
    $pdo->rollBack;
    $errmsg = "�G���[<br>". $e->getMessage();
  }

    }else{
    $errormes = "*�����͂̍��ڂ�����܂��B*<br>";
    }
  }

?>

<form action="mission_2-15.php" method="post" name="<?php echo $hensyu; ?>">
  ���O�ƃR�����g����͂����M�{�^���������Ă��������B<br/>
  <?php echo $hensyumessage; /*�ҏW���̃��b�Z�[�W*/ ?>
  ���O�F<br />
  <input type="text" name="name" size="30" value="<?php echo $editname; ?>" /><br />
  �R�����g�F<br />
  <textarea name="comment" cols="30" rows="5"><?php echo $editcomment; ?></textarea><br />
  �p�X���[�h�F
  <input type="password" name="sendpass" inputmode="verbatim" placeholder="���p�p��4�`8��" minlength="4" maxlength="8">
  <input type="submit" name= "send" value="���M" /><br />
  <br />
  �폜�Ώ۔ԍ��F
  <input type="text" name="delete" size="5" value="" /><br />
  �p�X���[�h�F
  <input type="password" name="delpass" inputmode="verbatim" placeholder="���p�p��4�`8��" minlength="4" maxlength="8">
  <input type="submit" name="delsend" value="�폜" /><br />
  �ҏW�Ώ۔ԍ��F
  <input type="text" name="edit" size="5" value="" /><br />
  �p�X���[�h�F
  <input type="password" name="editpass" inputmode="verbatim" placeholder="���p�p��4�`8��" minlength="4" maxlength="8">
  <input type="submit" name="editsend" value="�ҏW" />
  <input type="hidden" name="hensyu" value="<?php echo $hensyu; ?>" />
  <input type="hidden" name="editnum" value="<?php echo $editnum; ?>" />
</form>

<?php
  $dsn = '�f�[�^�x�[�X��';
  $usr = '���[�U�[��';
  $pass = '�p�X���[�h';

  try{
    $pdo = new PDO($dsn,$usr,$pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

    $pdo->beginTransaction();
    $board = "SELECT * FROM board";
    echo $errormes; //�G���[���b�Z�[�W
    $result = $pdo->query($board);
    foreach($result as $row){
      echo '�ԍ��F'.$row['id'].' ';
      echo '���O�F'.$row['name'].' ';
      echo '�R�����g�F'.$row['comment'].' ';
      echo '���e���ԁF'.$row['time'].'<br>';
    }
    echo $sakujomessage; //�폜���̃��b�Z�[�W
    $pdo->commit();
  }catch (PDOException $e){
    $pdo->rollBack;
    $errmsg = "�G���[<br>". $e->getMessage();
  }
  $pdo = null;
  echo $connect;

?>
