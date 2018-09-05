<!DOCTYPE html>
<html lang="ja">
<head>
 <meta charset="UTF-8">
</head>
	<body>
		<center>
			<h1>診断ツールメイカー<br>アカウント作成画面</h1>

<?php
/*MySQLに接続*/
$dsn = 'mysql:dbname=データベース名;host=localhost';
$user = 'ユーザー名';
$sqlPassword = 'PASSWORD';
$pdo = new PDO($dsn,$user,$sqlPassword);
/***********/
mb_language("Japanese");
mb_internal_encoding("UTF-8");

$name = $_POST['name'];
$password = $_POST['password'];
$adress = $_POST['adress'];
function makeRandStr($length){
	$str = array_merge(range('a', 'z'), range('0', '9'), range('A', 'Z"'));
	
	for ($i = 0; $i < $length; $i++) {
		$r_str .= $str[rand(0, count($str)-1)];
	}
	return $r_str;
}

if(!empty($_POST['id'])){
	if($_POST['id'] == $_POST['inputID'] ){
		echo "登録しました";

		$id = 1;

		$sql = 'SELECT * FROM mission_6_account';
		$results = $pdo -> query($sql);
		foreach ($results as $row){
			if($row['id'] >= $id){
				$id = $row['id'] + 1;
			}
		}

		$sql = $pdo -> prepare("INSERT INTO mission_6_account (id, name, mail, timeMake, timeFinal, password) VALUES (:id, :name, :mail, :timeMake, :timeFinal, :password)");
		$sql -> bindParam(':id', $id, PDO::PARAM_STR);
		$sql -> bindParam(':name', $name, PDO::PARAM_STR);
		$sql -> bindParam(':mail', $mail, PDO::PARAM_STR);
		$sql -> bindParam(':timeMake', $timeMake, PDO::PARAM_STR);
		$sql -> bindParam(':timeFinal', $timeFinal, PDO::PARAM_STR);
		$sql -> bindParam(':password', $password, PDO::PARAM_STR);

		$mail = $adress;
		$timeMake = date("Y/n/j G:i:s");
		$timeFinal = $timeMake;
		$sql -> execute();

		$sql= "CREATE TABLE ".$id."_".$name."_list"
		." ("
		. "id INT,"
		. "title TEXT,"
		. "timeMake char(32),"
		. "timeUpdate char(32)"
		.");";
		$stmt = $pdo->query($sql);

echo <<<EOF
<form action = "mission_6_make_menu.php" method = "post">
<br><br><input type = "submit" value ="クリエイターメニューへ">
<input type = 'hidden' name = 'name' value = $name>
<input type = 'hidden' name = 'password' value = $password>
<input type = 'hidden' name = 'id' value = $id>
</form>
EOF;

	}else{
		echo '認証IDが違います。';
echo <<<EOF
<form onsubmit="return confirm('送信しますか？');" action = "mission_6_make_account.php" method = "post">
ユーザー名         $name<input type = 'hidden' name = 'name' value = $name><br>
パスワード         $password<input type = 'hidden' name = 'password' value = $password><br>
メールアドレス     $adress<input type = 'hidden' name = 'adress' value = $adress><br>
認証ID             <input type = 'text' name = 'inputID' value = ''><br>
<input type = 'hidden' name = 'id' value = $id>
<input type = 'submit' value = '送信'>
</form>
EOF;
	}

}else{
	if(!empty($_POST['name']) && !empty($_POST['password']) && !empty($_POST['adress'])){
	echo $_POST['id'];

		$id = makeRandStr(8);
		$to = $_POST['adress'];
		$from_mail = 'zerozeroseventy@gmail.com';


// 件名
$subject = "診断ツールメイカーアカウント作成";

// 本文
$text = $name."様\n診断ツールメイカーです。\nあなたの認証IDは".$id."です。";

// 送信元
$from = "診断ツールメイカー";


// 送信者名
$from_name = "診断ツールメイカー";

// 送信者情報の設定
$header = '';
$header .= "Content-Type: text/plain \r\n";
$header .= "Return-Path: " . $from_mail . " \r\n";
$header .= "From: " . $from ." \r\n";
$header .= "Sender: " . $from ." \r\n";
$header .= "Reply-To: " . $from_mail . " \r\n";
$header .= "Organization: " . $from_name . " \r\n";
$header .= "X-Sender: " . $from_mail . " \r\n";
$header .= "X-Priority: 3 \r\n";

		if(mb_send_mail( $to, $subject, $text, $header)){
			echo "メールを送信しました。<br>メールに書かれている認証IDを入力してください。";

echo <<<EOF
<form onsubmit="return confirm('送信しますか？');" action = "mission_6_make_account.php" method = "post">
ユーザー名         $name<input type = 'hidden' name = 'name' value = $name><br>
パスワード         $password<input type = 'hidden' name = 'password' value = $password><br>
メールアドレス     $adress<input type = 'hidden' name = 'adress' value = $adress><br>
認証ID             <input type = 'text' name = 'inputID' value = ''><br>
<input type = 'hidden' name = 'id' value = $id>
<input type = 'submit' value = '送信'>
</form>
EOF;
		}else{
			echo "メールの送信に失敗しました";
		};
	}else{

echo <<<EOF
<form onsubmit="return confirm('送信しますか？');" action = "mission_6_make_account.php" method = "post">
ユーザー名         <input type = 'text' name = 'name' value = ''><br>
パスワード         <input type = 'text' name = 'password' value = ''><br>
メールアドレス     <input type = 'text' name = 'adress' value = '' size='60'><br>
<input type = 'submit' value = '送信'>
</form>
EOF;
	}
}

$sql = 'SELECT * FROM mission_6_account';
$results = $pdo -> query($sql);

?>
			<form onsubmit="return confirm('ログイン画面に移ります。');" action = "mission_6_login.php" method = "post">
				<br><br><input type = "submit" value ="ログイン画面に行く">
			</form>
			<form onsubmit="return confirm('本当に戻りますか？');" action = "mission_6_top.php" method = "post">
				<br><br><input type = "submit" value ="トップ画面に戻る"><br><br>
			</form>
		</center>
	</body>
</html>