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
    $sql = "SELECT * FROM tablename";
    $result = $pdo->query($sql);
    foreach($result as $row){
      echo $row['name'].',';
      echo $row['id'].'<br>';
    }
  }catch (PDOException $e){
    $err_msg = "�G���[�F". $e->getMessage();
    echo $err_msg;
  }
  $pdo = null;
?>