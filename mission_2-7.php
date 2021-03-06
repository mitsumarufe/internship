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
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
  }catch (PDOException $e){
    $err_msg = "エラー：". $e->getMessage();
    echo $err_msg;
  }
  $pdo = null;
?>