<?php 
include "lib.php";
$link = connect_db();

//загрузка данных с базы
if (isset($_GET["loadDB"])) 
{
	$arr = [];
	$res = mysqli_query($link, "SELECT * FROM sheeps");
	
	//формируем строку json
	while ($row = mysqli_fetch_array($res)) 
	{
		$str = urlencode($row["name"]);
		$arr[] = '{"id":"' . $row["id"] . '","name":"' . $str . '","pen":"'. $row["pen"] . '"}';
	}
	$json = "[" . implode(",", $arr) . "]";
	echo $json;
}
?>