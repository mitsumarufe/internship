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
    //テーブルが存在しなければ作成
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
    $err_msg = "エラー：". $e->getMessage();
    echo $err_msg;
  }
  $pdo = null;
?>