<?php
  $dsn = 'データベース名';
  $usr = 'ユーザー名';
  $pass = 'パスワード';

 $PDO=NULL;
 try {  $PDO=new PDO(  sprintf($dsn,$usr,$pass),  array(  PDO::MYSQL_ATTR_READ_DEFAULT_FILE=>'/etc/my.cnf',
 PDO::MYSQL_ATTR_READ_DEFAULT_GROUP=>'client',
 PDO::ATTR_EMULATE_PREPARES=>'FALSE'));
 $PDO->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_WARNING);
} catch(PDOException $e) {
 var_dump($e->getMessage());
}
 
//$PDO->query("SET NAMES utf8");
 
$sth=$PDO->prepare("SHOW VARIABLES LIKE 'char%'");
$sth->execute();
while($ins=$sth->fetchObject()){
 echo $ins->Variable_name . " | " . $ins->Value . "\n";
}