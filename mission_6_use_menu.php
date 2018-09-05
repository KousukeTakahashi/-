<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
</head>
	<body>
		<center>
			<h1>診断ツールメイカー
			<br>メニュー</h1><br>
		</center>

<?php
/*MySQLに接続*/
$dsn = 'mysql:dbname=データベース名;host=localhost';
$user = 'ユーザー名';
$sqlPassword = 'PASSWORD';
$pdo = new PDO($dsn,$user,$sqlPassword);
/***********/
$sql = 'SELECT * FROM mission_6_account';
$Aresults = $pdo -> query($sql);
foreach ($Aresults as $Arow){
	$Aname[$Arow['id']] = $Arow['name'];
	$Amail[$Arow['id']] = $Arow['mail'];
	$AtM[$Arow['id']] = $Arow['timeMake'];
	$AtF[$Arow['id']] = $Arow['timeFinal'];
	$Apass[$Arow['id']] = $Arow['password'];
/*リスト　1_名前_list*/
	$idList = $Arow['id'].'_'.$Aname[$Arow['id']].'_list';

	$sql = 'SELECT * FROM '.$idList;
	$Tresults = $pdo -> query($sql);
	if(!empty($Tresults))
		foreach ($Tresults as $Trow){
		$Ttitle[$Arow['id']][$Trow['id']] = $Trow['title'];
		$TtM[$Arow['id']][$Trow['id']] = $Trow['timeMake'];
		$TtU[$Arow['id']][$Trow['id']] = $Trow['timeUpdate'];
/*作成物　アカウントID__名前__作成物ID__作成物名*/
		$date = 0;
		$sql = "SELECT * FROM ".$Arow['id'].'__'.$Aname[$Arow['id']].'__'.$Trow['id'].'__'.$Ttitle[$Arow['id']][$Trow['id']];
		$date = $pdo -> query($sql);
		$sheetNum[$Arow['id']][$Trow['id']] = 0;
		if(!empty($date))
			foreach ($date as $a){
				$text[$Arow['id']][$Trow['id']][$a['No']] = $a['comment'];
				$answer1[$Arow['id']][$Trow['id']][$a['No']] = $a['answer1'];
				$answer2[$Arow['id']][$Trow['id']][$a['No']] = $a['answer2'];
				$answer3[$Arow['id']][$Trow['id']][$a['No']] = $a['answer3'];
				$answer4[$Arow['id']][$Trow['id']][$a['No']] = $a['answer4'];
				$go1[$Arow['id']][$Trow['id']][$a['No']] = $a['go1'];
				$go2[$Arow['id']][$Trow['id']][$a['No']] = $a['go2'];
				$go3[$Arow['id']][$Trow['id']][$a['No']] = $a['go3'];
				$go4[$Arow['id']][$Trow['id']][$a['No']] = $a['go4'];
				$type[$Arow['id']][$Trow['id']][$a['No']] = $a['type'];
				$sheetNum[$Arow['id']][$Trow['id']] ++;
			}
	}


}

	for($h = 1;!empty($Aname[$h]);$h ++){
		echo "<br>作成者 $Aname[$h] <br>";
		for($i = 1;!empty($Ttitle[$h][$i]);$i ++){
			$TTtitle = $Ttitle[$h][$i];
			$TTtM = $TtM[$h][$i];
			$TTtU = $TtU[$h][$i];
			$SN = $sheetNum[$h][$i];
echo "<form action = 'mission_6_use.php' method = 'post'>";

			echo "　　 $i";

echo "<input type = 'submit' name = 'first' value = 'はじめる'>";
echo "<input type = 'hidden' name = 'nameID' value = $h>";
echo "<input type = 'hidden' name = 'name' value = $Aname[$h]>";
echo "<input type = 'hidden' name = 'titleID' value = $i>";
echo "<input type = 'hidden' name = 'title' value = $TTtitle>";
echo "<input type = 'hidden' name = 'sheetNum' value = $SN>";
 			echo " $TTtitle";
			echo " 作成時間$TTtM 更新時間$TTtU<br>";

			for($j = 1;$j <= $SN;$j ++){
				$Ttext = $text[$h][$i][$j];
				$Aanswer1 = $answer1[$h][$i][$j];
				$Aanswer2 = $answer2[$h][$i][$j];
				$Aanswer3 = $answer3[$h][$i][$j];
				$Aanswer4 = $answer4[$h][$i][$j];
				$Ggo1 = $go1[$h][$i][$j];
				$Ggo2 = $go2[$h][$i][$j];
				$Ggo3 = $go3[$h][$i][$j];
				$Ggo4 = $go4[$h][$i][$j];
				$Ttype = $type[$h][$i][$j];

echo "<input type = 'hidden' name = '".$h.$i.$j."comment' value = $Ttext>";
echo "<input type = 'hidden' name = '".$h.$i.$j."answer1' value = $Aanswer1>";
echo "<input type = 'hidden' name = '".$h.$i.$j."go1' value = $Ggo1>";
echo "<input type = 'hidden' name = '".$h.$i.$j."answer2' value = $Aanswer2>";
echo "<input type = 'hidden' name = '".$h.$i.$j."go2' value = $Ggo2>";
echo "<input type = 'hidden' name = '".$h.$i.$j."answer3' value = $Aanswer3>";
echo "<input type = 'hidden' name = '".$h.$i.$j."go3' value = $Ggo3>";
echo "<input type = 'hidden' name = '".$h.$i.$j."answer4' value = $Aanswer4>";
echo "<input type = 'hidden' name = '".$h.$i.$j."go4' value = $Ggo4>";
echo "<input type = 'hidden' name = '".$h.$i.$j."type' value = $Ttype>";
			}

echo "</form>";
		}
	}
?>


		<center>
	
			<form action = "mission_6_top.php" method = "post">
				<input type = "submit" value = "トップ画面に戻る">
			</form>
	
		</center>
	</body>

</html>