<?php
  session_start();
  $dsn = 'データベース名';
  $usr = 'ユーザー名';
  $pass = 'パスワード';
  try{
    $pdo = new PDO($dsn,$usr,$pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    $sql = "CREATE TABLE IF NOT EXISTS `usertable`"
    ."("
    . "`name` TEXT,"
    . "`id` TEXT,"
    . "`sendpass` TEXT"
    .");";
    $stmt = $pdo -> prepare($sql);
    $stmt -> execute();
  }catch (PDOException $e){
    $err_msg = "エラー：". $e->getMessage();
  }
?>

<?php
  $dsn = 'データベース名';
  $usr = 'ユーザー名';
  $pass = 'パスワード';
  $name = htmlspecialchars($_POST["name"],ENT_QUOTES);
  $id = htmlspecialchars($_POST["id"],ENT_QUOTES);
  $sendpass = htmlspecialchars($_POST["sendpass"],ENT_QUOTES);
  if($_POST["send"] == "登録"){
    if(!empty($name) && !empty($id) && !empty($sendpass)){
      try{
        $pdo = new PDO($dsn,$usr,$pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        $pdo->beginTransaction();
        $sql = "INSERT INTO usertable (name, id, sendpass) VALUES (:name, :id, :sendpass)";
        $stmt = $pdo->prepare($sql);
        $params = array(':name' => $name, ':id' => $id, ':sendpass' => $sendpass);
        $stmt->execute($params);
        $pdo->commit();
      }catch (PDOException $e){
        $pdo->rollBack;
        $err_msg = "エラー：". $e->getMessage();
      }
    }else{
      $errormes = "*未入力の項目があります。*<br>";
    }
  }
?>

<form action="mission_3-6.php" method="post">
  <h1>新規ユーザー登録</h1>
  *下記の項目にすべて入力し、登録ボタンを押してください。*<br/>
  名前：<br />
  <input type="text" name="name" size="30" /><br />
  ID：<br />
  <input type="text" name="id" size="30" /><br />
  パスワード：<br />
  <input type="password" name="sendpass" inputmode="verbatim" placeholder="半角英数4～8字" minlength="4" maxlength="8">
  <input type="submit" name= "send" value="登録" /><br />
  <a href="http://co-740.it.99sv-coco.com/mission_3-7.php">登録済みの方はこちら</a>
  <br />
</form>

<?php
  $dsn = 'データベース名';
  $usr = 'ユーザー名';
  $pass = 'パスワード';
  $name = htmlspecialchars($_POST["name"],ENT_QUOTES);
  $id = htmlspecialchars($_POST["id"],ENT_QUOTES);
  $sendpass = htmlspecialchars($_POST["sendpass"],ENT_QUOTES);
  try{
    $pdo = new PDO($dsn,$usr,$pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    $pdo->beginTransaction();
    echo "↓登録されたユーザー情報↓<br>";
    $sql = "SELECT * FROM usertable";
    $result = $pdo->query($sql);
    foreach($result as $row){
      echo '名前：'.$row['name'].' ';
      echo 'ユーザーID：'.$row['id'].' ';
      echo 'パスワード：'.$row['sendpass'].'<br>';
    }
    $pdo->commit();
  }catch (PDOException $e){
    $pdo->rollBack;
    $errmsg = "エラー<br>". $e->getMessage();
  }
  $pdo = null;
?>
