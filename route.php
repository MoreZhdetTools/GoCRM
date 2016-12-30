<?php
//Подключаю классы, модели и функции
require_once 'autoload.php';
//Получение uri
$uri  = getUri();
//GET иначе (POST, PUT) запросы
if ($_SERVER['REQUEST_METHOD'] === 'GET') 
{
  	//Доступ к страницам  
  	if(isset($_SESSION['user_id'])) {
      	
      	//Проверка времени нахождения на сайте 
      	checkingTime(); 
     
      	switch ($uri) {
            case '/':
                include 'views/dashboard/index.html';
                break;
          	case '/friends':
          			$friends = Friends::getAllFriends();
          			include 'views/friends/index.php';
          			break;
          	case '/exit':
          			exitSession();
          			break;
            default:
                include 'views/errors/404.html';
                break;
    		}
      
    } else {
      
    		switch ($uri) {
            case '/':
                include 'views/index/index.html';
                break;
            case '/authorize':
                $AuthorizationController = new AuthorizationController($_GET);
                break;
            default:
                include 'views/errors/404.html';
                break;
    		}
    
    }
} 
else 
{
  	switch ($uri) {
        case '/friends/update':
            $FriendsController = new FriendsController($_POST); 
      			$FriendsController->update();
            break;
    }
}   
