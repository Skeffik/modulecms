<?php
//include protection
/* Constant that is checked in included files to prevent direct access.
 * define() is used in the installation folder rather than "const" to not error for PHP 5.2 and lower
 */

defined('_CMSEXEC') or die('Restricted access');

//XSS protect
function defender_xss($arr){
   $filter = array("<", ">","="," (",")",";","/");  
     foreach($arr as $num=>$xss){
        $arr[$num]=str_replace ($filter, "|", $xss);
     }
       return $arr;
} 

//SQL Injection Protection 
function sip($icheck){
     return "unhex('".bin2hex($icheck)."')";   
}

/*
 $section = $_GET[section]; // Читаем параметр 
if (!escape_inj ($section)) { // Проверяем параметр 
  echo "Это SQL-инъекция."; 
  exit (); 
} else { 
  $result = mysql_query ("SELECT * FROM `tbl_name` WHERE `section` = $section "); 
  ... // Продолжаем работу 
}
 */
function escape_inj ($text) { 
  $text = strtolower($text); // Приравниваем текст параметра к нижнему регистру 
  if ( 
  !strpos($text, "select") && //  
  !strpos($text, "union") && // 
  !strpos($text, "select") && // 
  !strpos($text, "order") && // Ищем вхождение слов в параметре 
  !strpos($text, "where") && //  
  !strpos($text, "char") && // 
  !strpos($text, "from") // 
  ) { 
  return true; // Вхождений нету - возвращаем true 
  } else { 
  return false; // Вхождения есть - возвращаем false 
  } 
} 

function a(){
    //Проверяем Пост, Гет и куки на ненужные символы 
    $arrs=array('_GET', '_POST', '_COOKIE'); 
    foreach($arrs as $arr_key => $arr_value){ 
        if(is_array($$arr_value)){ 
            foreach($$arr_value as $key => $value){ 
                $nbz1=substr_count($value,'--'); 
                $nbz2=substr_count($value,'/*'); 
                $nbz3=substr_count($value,"'"); 
                $nbz4=substr_count($value,'"'); 
                if($nbz1>0 || $nbz2>0 || $nbz3>0 || $nbz4>0){ 
                    print '<div class="error">Вы используете недопустимые символы в '.str_replace('_','',$arr_value).'-запросе!<br><a href="javascript:window.history.back();">Назад</a></div>'; 
                    exit(); 
                } 
            } 
        } 
    } 
}
 function no_injection($str='') { 
    $str = stripslashes($str); 
    $str = mysql_real_escape_string($str); 
    $str = trim($str); 
    $str = htmlspecialchars($str); 
    return $str; 
} 


?>