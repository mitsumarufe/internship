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
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
  }catch (PDOException $e){
    $err_msg = "�G���[�F". $e->getMessage();
    echo $err_msg;
  }
  $pdo = null;
?>