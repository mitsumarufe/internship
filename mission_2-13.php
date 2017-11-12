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
    echo '↓編集前のデータ↓<br>';
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
    echo '↓編集完了しました↓<br>';
    $sqla = "SELECT * FROM tablename";
    $resulta = $pdo->query($sqla);
    foreach($resulta as $row){
      echo $row['name'].',';
      echo $row['id'].'<br>';
    }
  }catch (PDOException $e){
    $err_msg = "エラー：". $e->getMessage();
    echo $err_msg;
  }
  $pdo = null;
?>