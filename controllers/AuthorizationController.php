<?php
//Авторизация
class AuthorizationController
{
    private $code; //Код для получения access_token

    public function __construct($get = [])
    {
        $this->code = checkArray($get, 'code');
      	$this->authorize();
    }
  
  	private function authorize()
    {
 		if($this->code === '') 
        {
            VK::authorize(); //Получаю код 
        } 
      	
      	$answer = VK::getAccessToken($this->code); //Получаю access_token
      
      	if(empty($answer['error'])) 
        {
        	$_SESSION['access_token'] = $answer['access_token'];                                         //Сохраняю токен в сессии
        	$_SESSION['user_id']      = $answer['user_id'];                                              //ID пользователя
        	$_SESSION['end_session']  = date('d.m.Y H:i:s', strtotime($answer['expires_in']." seconds"));//Время принудительного разлогирования
         
          	$user = VK::getUser();                                                                      //Получаю информацию о пользователе
          	Users::addUser($user['uid'], $user['first_name'], $user['last_name'], date('Y-m-d H:i:s')); //Добавляю нового пользователя в БД 
     
          	header('Location: /'); //Редитрект на главную страницу 
        } 
    }
}
