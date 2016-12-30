<?php
//Таблица фоловерсов 
class Friends extends DB
{
    //Функция получения всех друзей из БД
		public static function getAllFriends()
    {
      	$dbo = DB::dbo();                             //Подключаюсь к БД
        
      	$friends = VK::getAllFriends();               //Получаю массив друзей из ВК   
     		$user_id = Users::getID($_SESSION['user_id']);//Получаю id пользователя по id вк
      
      	foreach($friends as $friend)
        {
          	//Запрос на получение друга из БД по id друга ВК
          	$sql = $dbo->prepare('SELECT * FROM `vk_friends` 
            															WHERE `vk_friend_id` = :vk_friend_id
                                            AND `user_id` = :user_id;');
          
      			$sql->execute([':vk_friend_id' => $friend['uid'],
                           ':user_id' 		 => $user_id]);
            
          	//Если друг не найден
          	if($sql->fetch(PDO::FETCH_ASSOC) === false)
            {
                //Добавлю его в БД 
                $sql = $dbo->prepare('INSERT INTO `vk_friends` (`user_id`, `vk_friend_id`, `vk_fio`, `vk_photo`) 
                													 VALUES (:user_id, :vk_friend_id, :vk_fio, :vk_photo);');
              
                $sql->execute([':user_id' 		 => $user_id,
                  						 ':vk_friend_id' => $friend['uid'],
                               ':vk_fio'			 => $friend['first_name']." ".$friend['last_name'], 
                               ':vk_photo' 		 => $friend['photo_50']
                              ]);
            } 
          	else
            {
                //Иначе друг найден, изменяю статус удаления на 0
              	$sql = $dbo->prepare("UPDATE `vk_friends` SET `retired` = 0
                																				WHERE `vk_friend_id` = :vk_friend_id
                                                        	AND `retired` = 1	
                                                          AND `user_id` = :user_id;");
              
                $sql->execute([':user_id' 		 => $user_id,
                               ':vk_friend_id' => $friend['uid']]);
            }
        }	
        
        //Получаю список всех пользователей по ID пользователя
        $sql = $dbo->query("SELECT * FROM `vk_friends`
        														WHERE `user_id` ='".$user_id."';");
      
        $friends_dbo = $sql->fetchAll(PDO::FETCH_ASSOC);
      	
      	foreach($friends_dbo as $friend_dbo)
        {
          	$flag = false;
          
          	foreach($friends as $friend)
        		{
          			if($friend['uid'] == $friend_dbo['vk_friend_id'])
                {
                 		$flag = true; 
                }  
        		}
            
            //Если друг удалился, меняю статус на 1
          	if($flag === false)
            {
              	$sql = $dbo->prepare("UPDATE `vk_friends` 
                												 SET `retired` = 1
                											 WHERE `vk_friend_id` = :vk_friend_id
                                         AND `user_id` = :user_id;");
              
                $sql->execute([':user_id' 		 => $user_id,
                  						 ':vk_friend_id' => $friend_dbo['vk_friend_id']
                              ]);
            }
        }
        
     		//Получаю список всех пользователей по ID пользователя
        $sql = $dbo->query("SELECT * FROM `vk_friends` 
        														WHERE `retired` = 0 
                                    	AND `user_id` =".$user_id.";");
      
        $answer = $sql->fetchAll(PDO::FETCH_ASSOC);
                                     
        return $answer;
    }
  
    //Функция изменения данных в таблице 
  	public static function updateFriend($vk_friend_id, $email, $phone, $fio)
    {
      	$user_id = Users::getID($_SESSION['user_id']);
      
      	$dbo = DB::dbo();
      	$sql = $dbo->prepare("UPDATE `vk_friends` 
        												 SET `email` = :email, `phone` = :phone,`fio` = :fio
      												 WHERE `vk_friend_id` = :vk_friend_id
                            		 AND `user_id` = :user_id;");
      
      	$sql->execute([':user_id' 		 => $user_id,
          						 ':email'   		 => $email,
                     	 ':phone'   		 => $phone,
                     	 ':fio'     		 => $fio,
                       ':vk_friend_id' => $vk_friend_id]);
      	
    }
}