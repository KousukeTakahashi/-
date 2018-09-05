<!DOCTYPE html>
<html lang="ja">
<head>
 <meta charset="UTF-8">
</head>
	<body>
		<center>
			<h1>診断ツールメイカー<br>クリエイターメニュー</h1>


<?php
$id = $_POST['id'];
$name = $_POST['name'];
$password = $_POST['password'];
$mode  = $_POST['mode'];
$deleteTitle = $_POST['deleteTitle'];
$deleteNum = $_POST['deleteNum'];
if(empty($name)){
	echo 'ログインしてください。';
}else{
echo $name,"　様<br><br>";

/*MySQLに接続*/
$dsn = 'mysql:dbname=データベース名;host=localhost';
$user = 'ユーザー名';
$sqlPassword = 'PASSWORD';
$pdo = new PDO($dsn,$user,$sqlPassword);
/***********/

if($mode == '削除'){
	echo '「'.$deleteTitle.'」を削除しました<br>';
	$sql= "DROP TABLE ".$id."__".$name."__".$deleteNum."__".$deleteTitle.";";
	$stmt = $pdo->query($sql);
	$sql = "delete from ".$id."_".$name."_list where id=".$deleteNum;
	$result = $pdo->query($sql);

	$idList = $id.'_'.$name.'_list';
	$sql = 'SELECT * FROM '.$idList;
	$Tresults = $pdo -> query($sql);

	if(!empty($Tresults))
		foreach ($Tresults as $Trow)
			$Ttitle[$Trow['id']] = $Trow['title'];

	for($i = $deleteNum + 1; !empty($Ttitle[$i]); $i++){
		$j = $i - 1;
		$sql = "update ".$id."_".$name."_list set id='$j' where id = $i";
		$result = $pdo->query($sql);

		$Ititle = $Ttitle[$i];
		$sql = 'ALTER TABLE '.$id."__".$name."__".$i."__".$Ititle.' RENAME '.$id."__".$name."__".$j."__".$Ititle;
		$results = $pdo -> query($sql);
	}

}

$listName = $id.'_'.$name.'_list';

$sql = 'SELECT * FROM '.$listName;
$re = $pdo -> query($sql);
if(!empty($re))
foreach ($re as $row){
$date[$row['id']]['title'] = $row['title'];
$date[$row['id']]['timeMake'] = $row['timeMake'];
$date[$row['id']]['timeUpdate'] = $row['timeUpdate'];
}
for($i = 1;!empty($date[$i]['timeMake']);$i ++){
$Ti = $date[$i]['title'];
$TM = $date[$i]['timeMake'];
$TU = $date[$i]['timeUpdate'];
echo "$i $Ti 作成時間$TM 更新時間$TU<br>";
echo <<< EOF
<div style="display:inline-flex">
<form onsubmit="return confirm('編集に移ります。');" action = "mission_6_make.php" method = "post">
<input type = 'hidden' name = 'id' value = $id>
<input type = 'hidden' name = 'name' value = $name>
<input type = 'hidden' name = 'password' value = $password>
<input type = 'hidden' name = 'addNum' value = $i>
<input type = "submit" name = 'メニュー' value ="編集">
</form>
<pre>      </pre>
<form onsubmit="return confirm('本当に削除しますか？');" action = "mission_6_make_menu.php" method = "post">
<input type = 'hidden' name = 'id' value = $id>
<input type = 'hidden' name = 'name' value = $name>
<input type = 'hidden' name = 'password' value = $password>
<input type = 'hidden' name = 'deleteNum' value = $i>
<input type = 'hidden' name = 'deleteTitle' value = $Ti>
<input type = "submit" name = 'mode' value ="削除">
</form>
</div>
<br>
EOF;

}

echo "<form onsubmit='return confirm('新規作成画面に移ります。');' action = 'mission_6_make_first.php' method = 'post'>";
echo "<br><br><input type = 'submit' value ='新規作成'>";
}
?>

<?php
$id = $_POST['id'];
$name = $_POST['name'];
$password = $_POST['password'];
echo "<input type = 'hidden' name = 'id' value = $id>";
echo "<input type = 'hidden' name = 'name' value = $name>";
echo "<input type = 'hidden' name = 'password' value = $password>";
?>
			</form>
			<form onsubmit="return confirm('本当にトップ画面に戻りますか？');" action = "mission_6_top.php" method = "post">
				<br><br><input type = "submit" value ="トップ画面に戻る"><br><br>
			</form>
		</center>
	</body>
</html>