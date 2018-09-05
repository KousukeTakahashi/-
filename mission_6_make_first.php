<!DOCTYPE html>
<html lang="ja">
<head>
 <meta charset="UTF-8">
</head>
	<body>
		<center>
			 <h1>診断ツールメイカー<br>作成画面</h1>
		</center>
<?php
$id = $_POST['id'];
$name = $_POST['name'];
$password = $_POST['password'];


if(empty($name)){
	echo "<center>ログインしてください。";
}else{
	echo "<center>";
	echo "<form onsubmit='return confirm('本当にクリエイターメニューに戻りますか？');' action = 'mission_6_make_menu.php' method = 'post'>";
	echo "<br><br><input type = 'submit' value ='クリエイターメニューに戻る'><br><br>";
	echo "<input type = 'hidden' name = 'id' value = $id>";
	echo "<input type = 'hidden' name = 'name' value = $name>";
	echo "<input type = 'hidden' name = 'password' value = $password>";
	echo "</form>";
	echo "</center>";
	echo "<form onsubmit='return confirm('送信しますか？');' action = 'mission_6_make.php' method = 'post'>";

/*MySQLに接続*/
$dsn = 'mysql:dbname=データベース名;host=localhost';
$user = 'ユーザー名';
$sqlPassword = 'PASSWORD';
$pdo = new PDO($dsn,$user,$sqlPassword);
/***********/
$id = $_POST['id'];
$name = $_POST['name'];
$password = $_POST['password'];

$idList = $id.'_'.$name.'_list';
$sql = 'SELECT * FROM '.$idList;
$results = $pdo -> query($sql);
$addNum = 1;
if(!empty($results))
	foreach ($results as $row){
		$addNum ++;
	}
echo "<input type = 'hidden' name = 'id' value = $id>";
echo "<input type = 'hidden' name = 'name' value = $name>";
echo "<input type = 'hidden' name = 'password' value = $password>";
echo "$name　様<br>";
$sheetNum=7;
echo "<input type = 'hidden' name = 'sheetNum' value = ",$sheetNum,">";
$title = "タイトル";
$initialTitle = $title;
echo "タイトル　<input type = 'text' name = 'title' value = '",$title,"'><br><br>";
echo "<input type = 'hidden' name = 'initialTitle' value = $initialTitle>";
for($i = 1;$i <= 3;$i ++){
	$sheet[$i]["comment"] = "質問".$i;
	$sheet[$i]["answer1"] = "はい";
	$sheet[$i]["answer2"] = "いいえ";
	$sheet[$i]["answer3"] = "";
	$sheet[$i]["answer4"] = "";
	$sheet[$i]["type"] = "質問";
}
$sheet[1]["go1"] = 2;	$sheet[1]["go2"] = 3;
$sheet[2]["go1"] = 4;	$sheet[2]["go2"] = 5;
$sheet[3]["go1"] = 6;	$sheet[3]["go2"] = 7;

for($i = 4;$i <= 7;$i ++){
	$j = $i - 3;
	$sheet[$i]["comment"] = "結果".$j;
	$sheet[$i]["type"] = "結果";
}

for($i = 1;$i <= $sheetNum;$i ++){
	echo "No.",$i,"<br>  <textarea name='",$i,"comment' rows='4' cols='40'>",$sheet[$i]["comment"],"</textarea>";
	for($j = 1;$j <= 4;$j ++){
		echo "<br>回答",$j,"　<input type = 'text' name = '",$i,"answer",$j,"' value = '",$sheet[$i]["answer".$j],"'>";
		echo "　遷移先　No.";
		echo "<select name= ",$i,"go",$j,">";
		for($k = 1;$k <= $sheetNum;$k ++){
			echo "<option value= ",$k," ";
			if($sheet[$i]["go".$j] == $k){
				echo "selected";
			}
			echo ">",$k,"</option>";
		}
		echo "</select>";

	}
	echo "<br>タイプ　<input type='radio' name='",$i,"type' value= '質問' ";
	if($sheet[$i]["type"] == "質問")
		echo "checked='checked'";
	echo ">質問　";
	echo "<input type='radio' name='",$i,"type' value= '結果' ";
	if($sheet[$i]["type"] == "結果")
		echo "checked='checked'";
	echo ">結果<br><br>";
}
	echo "<input type = 'hidden' name = 'メニュー' value = '新規保存'>";
	echo "<input type = 'hidden' name = 'addNum' value = $addNum>";

echo "<center>";
echo "<input type = 'submit' name = 'mode' value = 'シートを追加する'><br>";
echo "<input type = 'submit' name = 'mode' value = 'シートを削除する'><br>削除 No.";
echo "<select name= 'deleteNum'>";

		for($k = 1;$k <= $sheetNum;$k ++){
			echo "<option value= ",$k,">",$k,"</option>";
		}
echo "</select>";
echo "<br>";
echo "<input type = 'submit' name = 'mode' value = '保存'><br>";
echo "</center>";
echo "</form>";
echo "<center>";
echo "<form onsubmit='return confirm('本当にクリエイターメニューに戻りますか？');' action = 'mission_6_make_menu.php' method = 'post'>";
echo "<br><br><input type = 'submit' value ='クリエイターメニューに戻る'><br><br>";
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