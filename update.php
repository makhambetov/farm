<?php 
include "lib.php";
$link = connect_db();

if(isset($_GET["upd"]))
{
	$qty = $_GET["upd"];

	//проверить наличие записей с единственным номером загона(всего одна овечка в загоне)
	//зафиксировать номер загона $single_sheep_pen

	$id = [];
	$name = [];
	$pen = [];

	for ($i=0; $i < $qty; $i++) 
	{ 
		//формирование массива загонов с единственной овечкой
/*		$pen_numbers = [];
		$pens = mysqli_query($link, "SELECT pen FROM sheeps");
		while ($pens_row = mysqli_fetch_array($pens)) {
			$pen_numbers[] = $pens_row["pen"];
		}
		$single_sheep_pen = get_unic($pen_numbers);

		//случайная генерация номеров загонов
		//запретить генерацию номера с одной Овечкой $single_sheep_pen
		$rnd = 0;
		$flag = false;
		do {
			$rnd = rand(1, 4);
			for ($j=0; $j < count($single_sheep_pen); $j++)
			{
				if($rnd == $single_sheep_pen[$j]) 
				{
					$flag = true;
					break;
				}
			}
		}while($flag);
*/
		$rnd = rand(1, 4);

		mysqli_query($link, "INSERT INTO sheeps (id, name, pen) VALUES ('', '', '$rnd')");		//вставка новой записи
		$res = mysqli_query($link, "SELECT id FROM sheeps WHERE name = ''");		//получаем id новой записи
		$row = mysqli_fetch_array($res);												//парсим результат
		//echo "UPDATE sheeps SET name = Sheep'" . $row['id'] . "' WHERE id = $row['id']\n";
		mysqli_query($link, "UPDATE sheeps SET name = 'Овечка" . $row['id'] . "' WHERE id = ". $row['id']);//обновляем запись

		//заносим данные в массивы
		$id[] = $row['id'];
		$name[] = urlencode("Овечка" . $row['id']);
		$pen[] = $rnd;
	}

	//передаем массивы в функцию генерации json и выводим
	echo get_json($id, $name, $pen, $qty);
}

?>