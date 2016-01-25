<?php
/*
 * Constant that is checked in included files to prevent direct access.
 * define() is used in the installation folder rather than "const" to not error for PHP 5.2 and lower
 */
define('_CMSEXEC', 1); //include protection
/* Время генерации старт */
include_once('engine/scripts/start.php');

require_once('engine/scripts/check.php'); //Подключаем функции первичных проверок
clientip(); //идентификация ip клиента

$arrycheckurlrequest = array("?", ".php", ".asp", ".py", ".js", "&", ".dat", "<script>");
foreach ($arrycheckurlrequest as $value) {
    checkurlrequest($value);
}

require_once('engine/config.dat'); //Подключаем файл общей конфигурации

if ($showerrors==="on"){error_reporting(E_ALL);} //показ всех ошибок
if ($webapp==="on"){

    require_once('engine/scripts/functional.php'); //Подключаем файл функций и классов
    $test_info = 'Ура! У нас получилось подключить стартовый модуль <b style="color:#f00">'.$modul_name.'</b> ))))<br>';
    $file_config = file('engine/module.dat'); // Подключаем МЕНЮ Активных модулей
    foreach($file_config as $line){
	$el = explode('',$line);
	if($el[1] == 'on'){
		$menu_active_modules .= '<li class="menu1"><a href="./'.$el[3].'/"><span class="'.$el[8].'"></span> '.$el[4].'</a></li>'."\r\n";
	}
    }

    // Выбор баз нужно перенести с сами модули и не мучать тут попу
    // Хотя если подключается какой нибудь плагин юзающий Мускуль, или нужно вывести последние заказы из магазина то это понадобиться ((
    if($modul_db == '1'){ // Подключаем меню .... 1-файлы, 2-мускуль, 3-постгре
		$filemenu = '<span class="glyphicon glyphicon-info-sign"></span> Подключаем Меню модуля на файлах <br><br>'; // $filemenu = file('file_cms/'.$modul_dir.'/menu.dat');
	}elseif($modul_db == '2'){
		$filemenu = 'Меню грузится из Мускуля'; // Подключаем Мускуль
	}elseif($modul_db == '3'){
		$filemenu = 'Меню грузится из Постгре'; // Подключаем Постгре
    }

    require_once('modules/'.$modul_dir.'/content/1.dat'); // Главная страница подключенного модуля
    require_once('engine/static_blocks.dat'); // Статичные блоки для всего сайта
    require_once('templates/'.$modul_skin.'/skin.dat'); // Шаблон модуля из настроек

}
elseif($webapp==="off"){
    echo "<div id=\"notice\">Веб приложение отключено!</div>";
      
}
elseif($webapp==="service"){
    echo "<div id=\"notice\">Веб приложение на обслуживание!</div>";
}
else{
    echo "<div id=\"notice\">Critical error! Please, contact the administrator.</div>";
}

/* Время генерации стоп */
include_once('engine/scripts/end.php');

?>