<?php
//Функция отладки, вывод и завершение скрипта (dump and die) 
function dd($value = 'Error, no argument. Stopping the application.')
{
    var_dump($value);
    exit();
}
//Получение URI
function getURI()
{
    $uri = $_SERVER['REQUEST_URI'];
  	
  	if(preg_match('/\\?.*/', $uri)) {
      	$array = explode("?", $uri);  
      	$uri 	 = $array[0];
    }

    return $uri;
}
//Проверка массива на пустоту
function checkArray($array, $key, $default = '')
{
		if(isset($array[$key])) {
				return $array[$key];
		} 
		return $default;
}
//Проверка времени нахождения на сайте
function checkingTime()
{
  	if(isset($_SESSION['end_session']))
    {
      	if(strtotime($_SESSION['end_session']) <= strtotime(date('d.m.Y H:i:s')))
        {
        		session_destroy();
          	header('Location: /');
        }
    }
}
//Отправка и получение данных в асоц. массиве 
function getCurlArray($request)
{
  	$curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $request);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
    $answer = curl_exec($curl); 
    curl_close($curl);   
  	$answer = json_decode($answer, true);
      
  	return $answer;
}
//Выход
function exitSession() {
		session_destroy();
  	header('Location: /');
}