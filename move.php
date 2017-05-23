<?php 
include "lib.php";
$link = connect_db();

//изменение поля "загон" в БД
if(isset($_GET))
{
	$s_id = $_GET["s"];
	$p_id = $_GET["p"];
	mysqli_query($link, "UPDATE sheeps SET pen ='$p_id' WHERE id = '$s_id'");	
}
?>