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
    echo '���ҏW�O�̃f�[�^��<br>';
    $sqlb = "SELECT * FROM tablename";
    $resultb = $pdo->query($sqlb);
    foreach($resultb as $row){
      echo $row['name'].',';
      echo $row['id'].'<br>';
    }
    $sql = "UPDATE tablename SET name = :name WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $params = array(':name' => 'watanabe', ':id' => '1');
    $stmt->execute($params);
    echo '���ҏW�������܂�����<br>';
    $sqla = "SELECT * FROM tablename";
    $resulta = $pdo->query($sqla);
    foreach($resulta as $row){
      echo $row['name'].',';
      echo $row['id'].'<br>';
    }
  }catch (PDOException $e){
    $err_msg = "�G���[�F". $e->getMessage();
    echo $err_msg;
  }
  $pdo = null;
?>