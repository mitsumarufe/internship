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
    $sql = "CREATE TABLE IF NOT EXISTS `tablename`"
    ."("
    . "`dd` INT auto_increment primary key,"
    . "`y` INT,"
    . "`m` INT,"
    . "`d` INT,"
    . "`youbi` INT,"
    . "`yokin` INT,"
    . "`a1` INT,"
    . "`a2` INT,"
    . "`a3` INT,"
    . "`a4` INT,"
    . "`a5` INT,"
    . "`i_date` DATETIME"
    .");";
    $stmt = $pdo -> prepare($sql);
    $stmt -> execute();
  }catch (PDOException $e){
    $err_msg = "�G���[�F". $e->getMessage();
    echo $err_msg;
  }
  $pdo = null;
?>