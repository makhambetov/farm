<?php 
include "lib.php";
$link = connect_db();

//удаление записи с БД
if(isset($_GET))
{
	for ($i=0; $i < count($_GET); $i++) { 
		$id = $_GET["id".($i+1)];
		mysqli_query($link, "DELETE FROM sheeps WHERE id = '$id'");
	}
}
?>