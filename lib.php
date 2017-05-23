<?php 

//подключение к базе данных
function connect_db()
{
	$link = mysqli_connect("localhost","root","")
	or die("Data base connection error");
	mysqli_select_db($link, "farm");
	mysqli_set_charset($link, "utf8");
	return $link;
}


//функция генерации json
//принимает массивы со значениями и количество записей
//возвращает строку JSON
function get_json($id, $name, $pen, $qty)
{
	for ($i=0; $i < $qty; $i++) 
		$arr[] = '{"id":"' . $id[$i] . '","name":"' . $name[$i] . '","pen":"'. $pen[$i] . '"}';
	return "[" . implode(",", $arr) . "]";
}

 
//функция принимает массив и возвращает массив не повторяющихся элементов
//возвращает false, если нет уникальных элементов
function get_unic($arr){
	$unic_nums = [];
	for ($i = 0; $i < count($arr); $i++) 
	{ 
		for ($j = 0; $j < count($arr); $j++)
		{
			if($arr[$i] == $arr[$j] && $i != $j) break;
			else
			{
				if($j == count($arr)-1)
					$unic_nums[] = $arr[$i];
			} 
		}
	}
	if(!count($unic_nums)) return false;
	return $unic_nums;
}

?>