<?php 
include "lib.php";
$link = connect_db();

//если запись в таблице не найдена, то добавляем запись со значением 0
$res = mysqli_query($link, "SELECT * FROM killed");
if(!($row = mysqli_fetch_array($res)))
	mysqli_query($link, "INSERT INTO killed (killed) VALUES (0)");

//загрузка счетчика
if(isset($_GET["load"]))
{
	echo $row["killed"];
}

//обновление счетчика в базе данных
if(isset($_GET["killed"]))
{
	$new_qty = $row["killed"] + $_GET["killed"];
	mysqli_query($link, "UPDATE killed SET killed ='$new_qty'");	
}
?>