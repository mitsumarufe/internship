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
    $errormes = "*�����͂̍��ڂ�����܂��B*<br>";
  }elseif((empty($name) || empty($comment)) && !empty($delete)){
  }elseif((empty($name) || empty($comment)) && !empty($edit)){
  }
  if($_POST["send"] == "���M"){
  if(!empty($name) || !empty($comment)){
    if($_POST["hensyu"] == "toukou"){ //���ʂɑ��M���������Ƃ�
      if($fp){
        $count = fgets($fp, $length);
        $count++;
        rewind($fp);
        fwrite($fp, sprintf("%03d", $count));
        flock($fp, LOCK_UN);
      } //�J�E���g
      fclose($fp);
      $data = $data." ".(sprintf("%03d", $count+1))."<>".$name."<>".$comment."<>".$time."\r\n";
      $fp2 = fopen($memofile, "a");
      fwrite($fp2, $data);
      fclose($fp2);
    }
    }elseif($_POST["hensyu"] == "henkou"){ //�ҏW�ԍ����͌㑗�M���������Ƃ�
      $n = 0;
      $editnum = $_POST["editnum"];
      foreach($lines as $line){
        $keijiban = explode("<>", $line);
        if($keijiban[0] == $editnum){
          $newdata = file($memofile);
          $newdata[$n] = " ".$editnum."<>".$name."<>".$comment."<>".$time."\r\n"; //�ҏW�ԍ��̔z�������������
          file_put_contents($memofile, $newdata); //�z��u��
        }
        $n++;
      }
    }
  }elseif($_POST["delsend"] == "�폜"){ //�폜�ԍ����͎�
    $n = 0;
    foreach($lines as $line){
      $keijiban = explode("<>", $line);
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
  }elseif($_POST["edisend"] == "�ҏW"){ //�ҏW�ԍ����͎�
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
        $hensyumessage = sprintf("%03d", $edit)."�Ԃ�ҏW���܂��B<br>";
        fwrite($fpp, $hensyumessage);
        fclose($fpp);
      }
      $n++;
    }
  }
?>



<form action="mission_2-5.php" method="post" name="<?php echo $hensyu; ?>">
  ���O�ƃR�����g����͂����M�{�^���������Ă��������B<br/>
  <?php echo $hensyumessage; /*�ҏW���̃��b�Z�[�W*/ ?>
  ���O�F<br />
  <input type="text" name="name" size="30" value="<?php echo $editname; ?>" /><br />
  �R�����g�F<br />
  <textarea name="comment" cols="30" rows="5"><?php echo $editcomment; ?></textarea><br />
  <br />
  <input type="submit" name= "send" value="���M" /><br />
  <br />
  �폜�Ώ۔ԍ��F
  <input type="text" name="delete" size="10" value="" />
  <input type="submit" name="delsend" value="�폜" /><br />
  �ҏW�Ώ۔ԍ��F
  <input type="text" name="edit" size="10" value="" />
  <input type="submit" name="edisend" value="�ҏW" />
  <input type="hidden" name="hensyu" value="<?php echo $hensyu; ?>" />
  <input type="hidden" name="editnum" value="<?php echo $editnum; ?>" />
</form>

<?php
  touch("kadai2-5-2.txt");
  $memofile = "kadai2-5-2.txt";
  $lines = file($memofile);
  echo $errormes; //�����͂̃G���[���b�Z�[�W
  foreach($lines as $line){
    $keijiban = explode("<>", $line);
    echo "�ԍ�:".$keijiban[0]." ���O:".$keijiban[1]." �R�����g:"
    .$keijiban[2]." ���e����:".$keijiban[3]."<br>";
  }
  echo $sakujomessage; //�폜���̃��b�Z�[�W
?>
