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
  if($_POST["send"] == "���M"){
    if($_POST["hensyu"] == "toukou"){ //���ʂɑ��M���������Ƃ�
      if(!empty($name) && !empty($comment) && !empty($sendpass)){
        if($fp){
          $count = fgets($fp, $length);
          $count++;
          rewind($fp);
          fwrite($fp, sprintf("%03d", $count));
          flock($fp, LOCK_UN);
        } //�J�E���g
        fclose($fp);
        $data = $data." ".(sprintf("%03d", $count+1))."<>".$name."<>".$sendpass."<>".$comment."<>".$time."\r\n";
        $fp2 = fopen($memofile, "a");
        fwrite($fp2, $data);
        fclose($fp2);
      }else{
        $errormes = "*�����͂̍��ڂ�����܂��B*<br>";
      }
    }elseif($_POST["hensyu"] == "henkou"){ //�ҏW�ԍ����͌㑗�M���������Ƃ�
      $n = 0;
      $editnum = $_POST["editnum"];
      foreach($lines as $line){
        $keijiban = explode("<>", $line);
        if($keijiban[0] == $editnum){
          $newdata = file($memofile);
          $newdata[$n] = $editnum."<>".$name."<>".$sendpass."<>".$comment."<>".$time."\r\n"; //�ҏW�ԍ��̔z�������������
          file_put_contents($memofile, $newdata); //�z��u��
          $newpass = file($passfile);
          $newpass[$n] == $sendpass;
          file_put_contents($passfile, $newpass);
        }
        $n++;
      }
    }
  }elseif($_POST["delsend"] == "�폜"){ //�폜�ԍ����͎�
    $n = 0;
    foreach($lines as $line){
      $keijiban = explode("<>", $line);
      if($keijiban[2] == $delpass){
        if($keijiban[0] == sprintf("%03d", $delete)){
          $sakujo = file($memofile);
          unset($sakujo[$n]); //�z�����
          file_put_contents($memofile, $sakujo); //�z������������̂�u��(=������)
          $fpp = fopen($sakujomes, "w");
          $sakujomessage = "~~~~~~<br>".sprintf("%03d", $delete)."�Ԃ��폜���܂����B<br>";
          fwrite($fpp, $sakujomessage);
          fclose($fpp);
        }
      $n++;
      }
    }
    if(empty($sakujomessage)){
      $errormes = "�ԍ��܂��̓p�X���[�h���Ԉ���Ă��܂��B<br>";
    }
  }elseif($_POST["editsend"] == "�ҏW"){ //�ҏW�ԍ����͎�
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
          $hensyumessage = sprintf("%03d", $edit)."�Ԃ�ҏW���܂��B<br>";
          fwrite($fpp, $hensyumessage);
          fclose($fpp);
        }
      $n++;
      }
    }
    if(empty($hensyumessage)){
      $errormes = "�ԍ��܂��̓p�X���[�h���Ԉ���Ă��܂��B<br>";
    }
  }
?>

<form action="mission_2-6.php" method="post" name="<?php echo $hensyu; ?>">
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
  touch("kadai2-6-2.txt");
  $memofile = "kadai2-6-2.txt";
  $lines = file($memofile);
  echo $errormes; //�����͂̃G���[���b�Z�[�W
  foreach($lines as $line){
    $keijiban = explode("<>", $line);
    echo "�ԍ�:".$keijiban[0]." ���O:".$keijiban[1]." �R�����g:".$keijiban[3]." ���e����:".$keijiban[4]."<br>";
  }
  echo $sakujomessage; //�폜���̃��b�Z�[�W
?>
