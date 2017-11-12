<?php
  session_start();
  $dsn = 'データベース名';
  $usr = 'ユーザー名';
  $pass = 'パスワード';

  $id = htmlspecialchars($_POST["id"],ENT_QUOTES);
  $sendpass = htmlspecialchars($_POST["sendpass"],ENT_QUOTES);
  if($_POST["send"] == "ログイン"){
    if(!empty($id) && !empty($sendpass)){
      try{
        $pdo = new PDO($dsn,$usr,$pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        $pdo->beginTransaction();
        $sql = "SELECT * FROM usertable where id = $id";
        $result = $pdo->query($sql);
        foreach($result as $row){
          $password = $row['sendpass'];
          if($password == $sendpass){
            $_SESSION["name"] = $row['name'];
            $_SESSION["sendpass"] = $row['sendpass'];
            $login = mt_rand(100000,999999);
            setcookie('login', $login, 0);
            header('location: http://co-740.it.99sv-coco.com/mission_3-7-2.php');
          }
        }
        $pdo->commit();
      }catch (PDOException $e){
        $pdo->rollBack;
        $errmsg = "エラー<br>". $e->getMessage();
      }
    }else{
    $errormes = "*未入力の項目があります。*<br>";
    }
  }

?>

<form action="mission_3-7.php" method="post">
  <h1>ログインフォーム</h1>
  <?php echo $errormes; ?>
  *下記の項目にすべて入力し、ログインボタンを押してください。*<br/>
  ID：<br />
  <input type="text" name="id" size="30" /><br />
  パスワード：<br />
  <input type="password" name="sendpass" inputmode="verbatim" placeholder="半角英数4～8字" minlength="4" maxlength="8">
  <input type="submit" name= "send" value="ログイン" /><br />
  <br />
  <a href="http://co-740.it.99sv-coco.com/mission_3-6.php">ユーザー登録していない方はこちら</a>
</form>
