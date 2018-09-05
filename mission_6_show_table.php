<?php
/*MySQLに接続*/
$dsn = 'mysql:dbname=データベース名;host=localhost';
$user = 'ユーザー名';
$sqlPassword = 'PASSWORD';
$pdo = new PDO($dsn,$user,$sqlPassword);
/***********/

$sql ='SHOW TABLES';
$result = $pdo -> query($sql);
foreach ($result as $row){
echo $row[0];
echo '<br>';
}
echo "<hr>";

$sql = 'SELECT * FROM mission_6_account';
$Aresults = $pdo -> query($sql);
foreach ($Aresults as $Arow){
	$Aid = $Arow['id'];
	$Aname = $Arow['name'];
	$Amail = $Arow['mail'];
	$AtM = $Arow['timeMake'];
	$AtF = $Arow['timeFinal'];
	$Apass = $Arow['password'];
	echo "<br>アカウント $Aid $Aname $Amail $AtM $AtF $Apass<br>";
/*リスト　1_名前_list*/
	$idList = $Aid.'_'.$Aname.'_list';
	$sql = 'SELECT * FROM '.$idList;
	$Tresults = $pdo -> query($sql);
	if(!empty($Tresults))
		foreach ($Tresults as $Trow){
		$Tid = $Trow['id'];
		$Ttitle = $Trow['title'];
		$TtM = $Trow['timeMake'];
		$TtU = $Trow['timeUpdate'];
		echo "　　作成物 $Tid $Ttitle $TtM $TtU<br>";
/*作成物　アカウントID__名前__作成物ID__作成物名*/
		$date = 0;
		$sql = "SELECT * FROM ".$Aid.'__'.$Aname.'__'.$Tid.'__'.$Ttitle;
		$date = $pdo -> query($sql);

		if(!empty($date))
			foreach ($date as $a){
				$No = $a['No'];
				$text = $a['comment'];
				$answer1 = $a['answer1'];
				$answer2 = $a['answer2'];
				$answer3 = $a['answer3'];
				$answer4 = $a['answer4'];
				$go1 = $a['go1'];
				$go2 = $a['go2'];
				$go3 = $a['go3'];
				$go4 = $a['go4'];
				$type = $a['type'];
				echo "　　　　No.$No $text $answer1 $answer2 $answer3 $answer4 $go1 $go2 $go3 $go4 $type <br>";
			}
	}

	echo '<hr>';
}
?>