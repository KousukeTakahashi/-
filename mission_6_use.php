<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
</head>
	<body>
		<center>
			<h1>診断ツールメイカー<br>

<?php
/*MySQLに接続*/
$dsn = 'mysql:dbname=データベース名;host=localhost';
$user = 'ユーザー名';
$sqlPassword = 'PASSWORD';
$pdo = new PDO($dsn,$user,$sqlPassword);
/***********/



$No = $_POST['No'];
$nameID= $_POST['nameID'];
$name = $_POST['name'];
$titleID= $_POST['titleID'];
$title = $_POST['title'];
$first = $_POST['first'];
$sheetNum = $_POST['sheetNum'];
if(empty($name)){
	echo "</h1>選択してください。";
}else{
	echo "$title</h1></center><div align='right'>by $name</div>";
	echo "<form action = 'mission_6_use.php' method = 'post'>";
	for($i = 1;$i <= $sheetNum;$i ++){
		$sheet[$i]["comment"] = $_POST[$nameID.$titleID.$i.'comment'];
		$sheet[$i]["answer1"] = $_POST[$nameID.$titleID.$i.'answer1'];
		$sheet[$i]["answer2"] = $_POST[$nameID.$titleID.$i.'answer2'];
		$sheet[$i]["answer3"] = $_POST[$nameID.$titleID.$i.'answer3'];
		$sheet[$i]["answer4"] = $_POST[$nameID.$titleID.$i.'answer4'];
		$sheet[$i]["type"] = $_POST[$nameID.$titleID.$i.'type'];
		$sheet[$i]["go1"] = $_POST[$nameID.$titleID.$i.'go1'];
		$sheet[$i]["go2"] = $_POST[$nameID.$titleID.$i.'go2'];
		$sheet[$i]["go3"] = $_POST[$nameID.$titleID.$i.'go3'];
		$sheet[$i]["go4"] = $_POST[$nameID.$titleID.$i.'go4'];

		$c = $sheet[$i]["comment"];
		$a1 = $sheet[$i]["answer1"];
		$a2 = $sheet[$i]["answer2"];
		$a3 = $sheet[$i]["answer3"];
		$a4 = $sheet[$i]["answer4"];
		$t = $sheet[$i]["type"];
		$g1 = $sheet[$i]["go1"];
		$g2 = $sheet[$i]["go2"];
		$g3 = $sheet[$i]["go3"];
		$g4 = $sheet[$i]["go4"];

	echo "<input type = 'hidden' name = '".$nameID.$titleID.$i."comment' value = ".$sheet[$i]['comment'].">";
	echo "<input type = 'hidden' name = '".$nameID.$titleID.$i."answer1' value = ".$sheet[$i]['answer1'].">";
	echo "<input type = 'hidden' name = '".$nameID.$titleID.$i."go1' value = ".$sheet[$i]['go1'].">";
	echo "<input type = 'hidden' name = '".$nameID.$titleID.$i."answer2' value = ".$sheet[$i]['answer2'].">";
	echo "<input type = 'hidden' name = '".$nameID.$titleID.$i."go2' value = ".$sheet[$i]['go2'].">";
	echo "<input type = 'hidden' name = '".$nameID.$titleID.$i."answer3' value = ".$sheet[$i]['answer3'].">";
	echo "<input type = 'hidden' name = '".$nameID.$titleID.$i."go3' value = ".$sheet[$i]['go3'].">";
	echo "<input type = 'hidden' name = '".$nameID.$titleID.$i."answer4' value = ".$sheet[$i]['answer4'].">";
	echo "<input type = 'hidden' name = '".$nameID.$titleID.$i."go4' value = ".$sheet[$i]['go4'].">";
	echo "<input type = 'hidden' name = '".$nameID.$titleID.$i."type' value = ".$sheet[$i]['type'].">";
	}
	echo "<input type = 'hidden' name = 'nameID' value = $nameID>";
	echo "<input type = 'hidden' name = 'name' value = $name>";
	echo "<input type = 'hidden' name = 'titleID' value = $titleID>";
	echo "<input type = 'hidden' name = 'title' value = $title>";
	echo "<input type = 'hidden' name = 'sheetNum' value = $sheetNum>";

	if(empty($No)){
		$No = 1;
	}

	echo "<center>No.$No <b>".$sheet[$No]['comment']."</b><br>";
	if($sheet[$No]['type'] == '質問'){
		if(!empty($sheet[$No]['answer1']) && !empty($sheet[$No]['go1'])){
			echo "<input type = 'radio' name = 'No' value = '".$sheet[$No]['go1']."' checked='checked'>";
			echo $sheet[$No]['answer1'].'<br>';
		}
		if(!empty($sheet[$No]['answer2']) && !empty($sheet[$No]['go2'])){
			echo "<input type = 'radio' name = 'No' value = ".$sheet[$No]['go2']." checked='checked'>";
			echo $sheet[$No]['answer2'].'<br>';
		}
		if(!empty($sheet[$No]['answer3']) && !empty($sheet[$No]['go3'])){
			echo "<input type = 'radio' name = 'No' value = ".$sheet[$No]['go3']." checked='checked'>";
			echo $sheet[$No]['answer3'].'<br>';
		}
		if(!empty($sheet[$No]['answer4']) && !empty($sheet[$No]['go4'])){
			echo "<input type = 'radio' name = 'No' value = ".$sheet[$No]['go4']." checked='checked'>";
			echo $sheet[$No]['answer4'].'<br>';
		}
		echo "<input type = 'submit' value = '次へ'></center><br>";
	}
	echo "</form>";
}
?>


		<center>
	
			<form action = "mission_6_use_menu.php" method = "post">
				<input type = "submit" value = "メニューに戻る">
			</form>
	
		</center>
	</body>

</html>
