
//загрузка данных с базы данных. 
//Возвращает массив с объектами данных и загружает счетчик
function loadDataBase()
{
	var loadCounter = newAJAXObject();
	loadCounter.open("GET", "counter.php?load=1", false);
	loadCounter.send();
	$("#killed").val("Всего убито овечек: " + loadCounter.responseText)

	var loadData = newAJAXObject();
	loadData.open("GET", "load.php?loadDB=1", false);
	loadData.send();
	var sheeps = JSON.parse(decodeURI(loadData.responseText))
	return sheeps;
}

//распределяет загруженные записи по полям(загонам)
function allocate(arr){
	var select  = $("select");
	arr.forEach(function(obj, i, arr){
		var option = document.createElement('option');
		option.innerHTML = arr[i].name;
		option.setAttribute("value", arr[i].id);
		select.get(+arr[i].pen-1).append(option);
	})
}

//обновление страницы
function updatePage(){
	var update = newAJAXObject();
	var select  = document.getElementsByTagName("select");

	update.open("GET", "update.php?upd="+randomNum(), false);
	update.send();
	var sheeps = JSON.parse(decodeURI(update.responseText))
	allocate(sheeps);
}

//возвращает случайное число от мин до макс
function randomNum(min = 1, max = 5) {
	var rand = min + Math.random() * (max + 1 - min);
	rand = Math.floor(rand);
	return rand;
}

//удаляет записи с БД и со страницы
function kill(id)
{
	opt_val = [];

	if(id)//при вводе команды
	{
		options = $('[value=' + id + ']').each(function(){
			opt_val = [this.value]
		})
		options.remove();
	}
	else//при множественном выборе
	{
		options = $( "select option:selected" ).each(function(){
			opt_val.push(this.value)
		});
		options.remove();
	}

	if(opt_val.length == 0) return;

	//формируем URL для GET-запроса
	var url_str = "";
	for (var i = 0; i < opt_val.length; i++) 
		url_str += "id" + (i+1) + "=" + opt_val[i] + "&";
	url_str = url_str.slice(0, -1);

	//отправляем запрос
	var kill = newAJAXObject();
	kill.open("GET", "kill.php?"+url_str, false);
	kill.send();
	
	//обновление записи в БД
	var counter = newAJAXObject();
	counter.open("GET", "counter.php?killed="+opt_val.length, false);
	counter.send();

	//загрузка записи счетчика с БД
	counter.open("GET", "counter.php?load=1", false);
	counter.send();
	$("#killed").val("Всего убито овечек: " + counter.responseText);
}


function move(sheep_id, pen_id)
{
	var move = newAJAXObject();
	move.open("GET", "move.php?s=" + sheep_id + "&p=" + pen_id, false);
	move.send();

	$('[value=' + sheep_id + ']').appendTo($("#pen" + pen_id));

}

//обработчик команд (реализованы команды "убить" и "переместить")
function command()
{
	var command = $("#command_line").val();
	var command_pattern = /^((убить)|(переместить))/ig;		//регулярное выражение поиска команды
	var sheep_pattern = /((овечка)((\d+)|(\d+\s+)))$/ig;	//регулярное выражение поиска значения
	var digit_pattern = /\d+/ig;							//регулярное выражение поиска id
	var pen_pattern = /загон(\d+)|(\d+\s+)$/ig;
	var sheep_id = command.match(digit_pattern)[0];
	var pen_id = command.match(digit_pattern)[1];

	if(command.search(command_pattern) != -1 && command.search(sheep_pattern) != -1){
		if(command.match(command_pattern)[0] == "убить")
			kill(sheep_id);
	}
	
	if(command.search(command_pattern) != -1 && command.search(pen_pattern) != -1)
		if(command.match(command_pattern)[0] == "переместить")
			move(sheep_id, pen_id);
	}

//возвращает новый XMLHttpRequest объект
function newAJAXObject() {
	var request_type;
	var browser = navigator.appName;
	if(browser == "Microsoft Internet Explorer"){
		request_type = new ActiveXObject("Microsoft.XMLHTTP");
	}else{
		request_type = new XMLHttpRequest();
	}
	return request_type;
}

var sheeps = loadDataBase();
allocate(sheeps);
//автообновление каждые 20 секунд
setInterval(updatePage, 20000);