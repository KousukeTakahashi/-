<!DOCTYPE html>
<html lang="ja">
<head>
 <meta charset="UTF-8">
</head>
	<body>
		<center>
			<h1>診断ツールメイカー<br>ログイン画面</h1>

<?php
/*MySQLに接続*/
$dsn = 'mysql:dbname=データベース名;host=localhost';
$user = 'ユーザー名';
$sqlPassword = 'PASSWORD';
$pdo = new PDO($dsn,$user,$sqlPassword);
/***********/
$name = $_POST['name'];
$password = $_POST['password'];
if(!empty($name)){
	$flag = '照合できませんでした';
	$sql = 'SELECT * FROM mission_6_account';
	$results = $pdo -> query($sql);
	foreach ($results as $row){
		if($row['name'] == $name && $row['password'] == $password){
			$flag = '照合できました';
			$id = $row['id'];
			break;
		}
	}
	echo $flag;
	if($flag == '照合できました'){
		$time = date("Y/n/j G:i:s");
		$sql = "update mission_6_account set timeFinal='$time' where id = $id";
		$result = $pdo->query($sql);
echo <<<EOF
<form  action = "mission_6_make_menu.php" method = "post">
<input type = 'hidden' name = 'name' value = $name>
<input type = 'hidden' name = 'password' value = $password>
<input type = 'hidden' name = 'id' value = $id>
<input type = 'submit' value = "クリエイターメニューへ">
</form>
EOF;
	}else{
echo <<<EOF
<form onsubmit="return confirm('送信しますか？');" action = "mission_6_login.php" method = "post">
ユーザー名<input type = 'text' name = 'name' value = ''><br>
パスワード<input type = 'text' name = 'password' value = ''><br>
<input type = 'submit' value = 'ログイン'>
</form>
EOF;
	}
}else{
echo <<<EOF
<form onsubmit="return confirm('送信しますか？');" action = "mission_6_login.php" method = "post">
ユーザー名<input type = 'text' name = 'name' value = ''><br>
パスワード<input type = 'text' name = 'password' value = ''><br>
<input type = 'submit' value = 'ログイン'>
</form>
EOF;
}
?>
			<form onsubmit="return confirm('アカウント作成画面に移ります。');" action = "mission_6_make_account.php" method = "post">
				<br><br><input type = "submit" value ="アカウント作成">
			</form>
			<form action = "mission_6_top.php" method = "post">
				<br><br><input type = "submit" value ="トップ画面に戻る"><br><br>
			</form>
		</center>
	</body>
</html>