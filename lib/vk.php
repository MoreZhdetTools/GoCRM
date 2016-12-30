<?php

class VK 
{ 
  	private static $client_id     = '5799587';                        //Индификатор приложения 
    private static $client_secret = 'DZ1hangjAex6NxnmeJD0';           //Защищенный ключ
    private static $redirect_uri  = 'http://testvk.fl8.ru/authorize'; //Адресс, на который будет передан code 
    private static $scope         = 'friends,photos';                  //Настройки доступа приложения
  	
  	public static function authorize()
    {
    		$request = 'https://oauth.vk.com/authorize'.
  			         	 '?client_id='.self::$client_id.
  			         	 '&display=popup'.
                 	 '&redirect_uri='.self::$redirect_uri.
                 	 '&scope='.self::$scope.
                 	 '&response_type=code'.
                 	 '&v=3.0';
          
      	header('Location: '.$request);  
    }
  
  	public static function getAccessToken($code)
    {
    		$request = 'https://oauth.vk.com/access_token'.
           				 '?client_id='.self::$client_id.
           				 '&client_secret='.self::$client_secret.
           				 '&redirect_uri='.self::$redirect_uri.
           				 '&code='.$code; 
      
      	$answer  = getCurlArray($request);
      	
      	return $answer;
    }
  
  	public static function getUser()
    {
      	$request = file_get_contents('https://api.vk.com/method/users.get?user_id='.$_SESSION['user_id'].'&access_token='.$_SESSION['access_token'].'&v=3.0 ', true);
      	$answer  = json_decode($request, true);
      
      	return $answer['response'][0];
    }
  	
  	public static function getAllFriends()
    {
    		$request = file_get_contents('https://api.vk.com/method/friends.get?user_id='.$_SESSION['user_id'].'&access_token='.$_SESSION['access_token'].'&fields=photo_50&v=3.0', true);
      	$answer  = json_decode($request, true);
      
      	return $answer['response'];
    }	
}