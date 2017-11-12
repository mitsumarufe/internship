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
    $sql = "INSERT INTO tablename (name, id) VALUES (:name, :id)";
    $stmt = $pdo->prepare($sql);
    $params = array(':name' => 'suzuki', ':id' => '4');
    $stmt->execute($params);
  }catch (PDOException $e){
    $err_msg = "エラー：". $e->getMessage();
    echo $err_msg;
  }
  $pdo = null;
?>