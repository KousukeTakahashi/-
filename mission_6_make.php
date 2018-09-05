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

	$dsnSQL = 'mysql:dbname=データベース名;host=localhost';
	$userSQL = 'ユーザー名';
	$passwordSQL = 'PASSWORD';
	$pdo = new PDO($dsnSQL,$userSQL,$passwordSQL);

	$id = $_POST['id'];
	$name = $_POST['name'];
	$password = $_POST['password'];
	$mode = $_POST['mode'];
	$title = $_POST['title'];
	$initialTitle = $_POST['initialTitle'];
	$sheetNum=$_POST['sheetNum'];
	$menu = $_POST['メニュー'];
	$addNum = $_POST['addNum'];
	if($menu == '編集'){
		$menu = '上書き保存';
		$idList = $id.'_'.$name.'_list';
		$sql = 'SELECT * FROM '.$idList;
		$results = $pdo -> query($sql);
		foreach ($results as $row){
			if($addNum == $row['id']){
				$title = $row['title'];
				$initialTitle = $title;
			}
		}
		$sql = "SELECT * FROM ".$id.'__'.$name.'__'.$addNum.'__'.$initialTitle;
		$date = $pdo -> query($sql);
		$sheetNum = 0;
		foreach($date as $row){
			if(!empty($row['No'])){
				$sheetNum ++;
			}
			$sheet[$row['No']]["comment"] = $row['comment'];
			$sheet[$row['No']]["answer1"] = $row['answer1'];
			$sheet[$row['No']]["answer2"] = $row['answer2'];
			$sheet[$row['No']]["answer3"] = $row['answer3'];
			$sheet[$row['No']]["answer4"] = $row['answer4'];
			$sheet[$row['No']]["type"] = $row['type'];
			$sheet[$row['No']]["go1"] = $row['go1'];
			$sheet[$row['No']]["go2"] = $row['go2'];
			$sheet[$row['No']]["go3"] = $row['go3'];
			$sheet[$row['No']]["go4"] = $row['go4'];
		}
	}

	echo "<input type = 'hidden' name = 'id' value = $id>";
	echo "<input type = 'hidden' name = 'name' value = $name>";
	echo "<input type = 'hidden' name = 'password' value = $password>";
	echo "<input type = 'hidden' name = 'initialTitle' value = $initialTitle>";
	echo "$name　様<br>";

	if($mode == '保存'){

		for($i = 1;$i <= $sheetNum;$i ++){
			$sheet[$i]["comment"] = $_POST[$i.'comment'];
			$sheet[$i]["answer1"] = $_POST[$i.'answer1'];
			$sheet[$i]["answer2"] = $_POST[$i.'answer2'];
			$sheet[$i]["answer3"] = $_POST[$i.'answer3'];
			$sheet[$i]["answer4"] = $_POST[$i.'answer4'];
			$sheet[$i]["type"] = $_POST[$i.'type'];
			$sheet[$i]["go1"] = $_POST[$i.'go1'];
			$sheet[$i]["go2"] = $_POST[$i.'go2'];
			$sheet[$i]["go3"] = $_POST[$i.'go3'];
			$sheet[$i]["go4"] = $_POST[$i.'go4'];
		}
		$listName = $id.'_'.$name.'_list';
		if($menu == '新規保存'){
			$sql = $pdo -> prepare("INSERT INTO $listName (id, title, timeMake, timeUpdate) VALUES (:id, :title, :timeMake, :timeUpdate)");
			$sql -> bindParam(':id', $addNum, PDO::PARAM_STR);
			$sql -> bindParam(':title', $title, PDO::PARAM_STR);
			$sql -> bindParam(':timeMake', $timeMake, PDO::PARAM_STR);
			$sql -> bindParam(':timeUpdate', $timeUpdate, PDO::PARAM_STR);
			$timeMake = date("Y/n/j G:i:s");
			$timeUpdate = $timeMake;
			$sql -> execute();

		}else if($menu == '上書き保存'){
			$timeUpdate = date("Y/n/j G:i:s");
			$sql = "update $listName set title='$title' , timeUpdate='$timeUpdate' where id = '$addNum'";
			$result = $pdo->query($sql);
	$dropName = $id.'__'.$name.'__'.$addNum.'__'.$initialTitle;
			$sql= "DROP TABLE $dropName;";
			$stmt = $pdo->query($sql);
		}

	$dtName = $id.'__'.$name.'__'.$addNum.'__'.$title;
		$sql= "CREATE TABLE $dtName (No INT,comment TEXT,answer1 TEXT,answer2 TEXT,answer3 TEXT,answer4 TEXT,go1 INT,go2 INT,go3 INT,go4 INT,type char(32));";
		$stmt = $pdo->query($sql);

		for($i = 1;$i <= $sheetNum;$i ++){
			$sql = $pdo -> prepare("INSERT INTO $dtName (No,comment,answer1,answer2,answer3,answer4,go1,go2,go3,go4,type) VALUES (:No,:comment,:answer1,:answer2,:answer3,:answer4,:go1,:go2,:go3,:go4,:type)");
			$sql -> bindParam(':No', $i, PDO::PARAM_STR);
			$sql -> bindParam(':comment', $sheet[$i]["comment"], PDO::PARAM_STR);
			$sql -> bindParam(':answer1', $sheet[$i]["answer1"], PDO::PARAM_STR);
			$sql -> bindParam(':answer2', $sheet[$i]["answer2"], PDO::PARAM_STR);
			$sql -> bindParam(':answer3', $sheet[$i]["answer3"], PDO::PARAM_STR);
			$sql -> bindParam(':answer4', $sheet[$i]["answer4"], PDO::PARAM_STR);
			$sql -> bindParam(':go1', $sheet[$i]["go1"], PDO::PARAM_STR);
			$sql -> bindParam(':go2', $sheet[$i]["go2"], PDO::PARAM_STR);
			$sql -> bindParam(':go3', $sheet[$i]["go3"], PDO::PARAM_STR);
			$sql -> bindParam(':go4', $sheet[$i]["go4"], PDO::PARAM_STR);
			$sql -> bindParam(':type', $sheet[$i]["type"], PDO::PARAM_STR);
			$sql -> execute();
		}
		echo "<center>「".$title."」を";
		echo "保存しました<br></center>";
	}else{
		if(strcmp($mode,"シートを追加する") == 0){
			for($i = 1;$i <= $sheetNum;$i ++){
				$sheet[$i]["comment"] = $_POST[$i.'comment'];
				$sheet[$i]["answer1"] = $_POST[$i.'answer1'];
				$sheet[$i]["answer2"] = $_POST[$i.'answer2'];
				$sheet[$i]["answer3"] = $_POST[$i.'answer3'];
				$sheet[$i]["answer4"] = $_POST[$i.'answer4'];
				$sheet[$i]["type"] = $_POST[$i.'type'];
				$sheet[$i]["go1"] = $_POST[$i.'go1'];
				$sheet[$i]["go2"] = $_POST[$i.'go2'];
				$sheet[$i]["go3"] = $_POST[$i.'go3'];
				$sheet[$i]["go4"] = $_POST[$i.'go4'];
			}
			$sheetNum ++;
			$sheet[$sheetNum]["comment"] = "質問".$sheetNum;
			$sheet[$sheetNum]["answer1"] = "はい";
			$sheet[$sheetNum]["answer2"] = "いいえ";
			$sheet[$sheetNum]["answer3"] = "";
			$sheet[$sheetNum]["answer4"] = "";
			$sheet[$sheetNum]["type"] = "質問";
			echo "<br>シートを追加しました。<br>";
		}else if($mode == 'シートを削除する'){
			$deleteNum = $_POST['deleteNum'];
			if($deleteNum >= 1 && $deleteNum <= $sheetNum){
				for($i = 1;$i < $sheetNum;$i ++){
					if($i < $deleteNum){
						$sheet[$i]["comment"] = $_POST[$i.'comment'];
						$sheet[$i]["answer1"] = $_POST[$i.'answer1'];
						$sheet[$i]["answer2"] = $_POST[$i.'answer2'];
						$sheet[$i]["answer3"] = $_POST[$i.'answer3'];
						$sheet[$i]["answer4"] = $_POST[$i.'answer4'];
						$sheet[$i]["type"] = $_POST[$i.'type'];
						$sheet[$i]["go1"] = $_POST[$i.'go1'];
						$sheet[$i]["go2"] = $_POST[$i.'go2'];
						$sheet[$i]["go3"] = $_POST[$i.'go3'];
						$sheet[$i]["go4"] = $_POST[$i.'go4'];
					}else{
						$j = $i + 1;
						$sheet[$i]["comment"] = $_POST[$j.'comment'];
						$sheet[$i]["answer1"] = $_POST[$j.'answer1'];
						$sheet[$i]["answer2"] = $_POST[$j.'answer2'];
						$sheet[$i]["answer3"] = $_POST[$j.'answer3'];
						$sheet[$i]["answer4"] = $_POST[$j.'answer4'];
						$sheet[$i]["type"] = $_POST[$j.'type'];
						$sheet[$i]["go1"] = $_POST[$j.'go1'];
						$sheet[$i]["go2"] = $_POST[$j.'go2'];
						$sheet[$i]["go3"] = $_POST[$j.'go3'];
						$sheet[$i]["go4"] = $_POST[$j.'go4'];
					}
				}
				$sheetNum --;
				echo "<br>No.",$deleteNum,"を削除しました。<br>";
			}else{
				echo "<br>削除Noが適切ではありません。<br>";
				for($i = 1;$i <= $sheetNum;$i ++){
					$sheet[$i]["comment"] = $_POST[$i.'comment'];
					$sheet[$i]["answer1"] = $_POST[$i.'answer1'];
					$sheet[$i]["answer2"] = $_POST[$i.'answer2'];
					$sheet[$i]["answer3"] = $_POST[$i.'answer3'];
					$sheet[$i]["answer4"] = $_POST[$i.'answer4'];
					$sheet[$i]["type"] = $_POST[$i.'type'];
					$sheet[$i]["go1"] = $_POST[$i.'go1'];
					$sheet[$i]["go2"] = $_POST[$i.'go2'];
					$sheet[$i]["go3"] = $_POST[$i.'go3'];
					$sheet[$i]["go4"] = $_POST[$i.'go4'];
				}
			}
		}
		echo "<br>前のタイトル　$initialTitle<br>";
		echo "新規タイトル　<input type = 'text' name = 'title' value = '",$title,"'><br><br>";
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
	echo "<center>";
	echo "<input type = 'submit' name = 'mode' value = 'シートを追加する'><br>";
	echo "<input type = 'submit' name = 'mode' value = 'シートを削除する'><br>削除 No.";
	echo "<select name= 'deleteNum'>";
	for($k = 1;$k <= $sheetNum;$k ++){
		echo "<option value= ",$k,">",$k,"</option>";
	}
	echo "</select><br>";
	echo "<input type = 'submit' name = 'mode' value = '保存'><br>";
	echo "</center>";
	}
	echo "<input type = 'hidden' name = 'sheetNum' value = ",$sheetNum,">";
	echo "<input type = 'hidden' name = 'メニュー' value = $menu>";
	echo "<input type = 'hidden' name = 'addNum' value = $addNum>";
	
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