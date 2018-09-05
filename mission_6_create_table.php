<?php
$dsn = 'mysql:dbname=データベース名;host=localhost';
$user = 'ユーザー名';
$sqlPassword = 'PASSWORD';
$pdo = new PDO($dsn,$user,$sqlPassword);

$sql= "CREATE TABLE mission_6_account"
." ("
. "id INT,"
. "name char(32),"
. "mail TEXT,"
. "timeMake char(32),"
. "timeFinal char(32),"
. "password char(32)"
.");";
$stmt = $pdo->query($sql);

$sql ='SHOW CREATE TABLE mission_6_account';
$result = $pdo -> query($sql);
foreach ($result as $row){
print_r($row);
}
echo "<hr>";
?>