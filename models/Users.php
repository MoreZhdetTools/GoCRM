<?php
//Запросы к таблице Users 
class Users extends DB
{
    //Добавление нового пользователя
  	public static function addUser($vk_id, $vk_first_name, $vk_last_name, $last_login_date)
    {
      	$dbo = DB::dbo();
      	$sql = $dbo->prepare("SELECT * FROM `users` WHERE `vk_id` = :vk_id;");
      	$sql->execute([':vk_id' => $vk_id]);
        
        //Если пользователя нет в таблице добовляю
      	if($sql->fetch(PDO::FETCH_ASSOC) === false)
        {
            $sql = $dbo->prepare("INSERT INTO `users` (`vk_id`,`vk_first_name`,`vk_last_name`,`last_login_date`) VALUES 
            																					(:vk_id, :vk_first_name, :vk_last_name, :last_login_date );");
          
          	$sql->execute([':vk_id' 				 => $vk_id,
                           ':vk_first_name'  => $vk_first_name,
                           ':vk_last_name'   => $vk_last_name,
                           ':last_login_date'=> $last_login_date]);
        } 
        else 
        {
            //Иначе обновляю время входа на сайт
        		$sql = $dbo->prepare("UPDATE `users` SET `last_login_date` = :last_login_date 
            																	 WHERE `vk_id` = :vk_id;");
          	
          	$sql->execute([':vk_id' 				 => $vk_id,
                           ':last_login_date'=> $last_login_date]);
        }
    }
  
    //Получение ID пользователя по VK_ID
  	public static function getID($vk_id)
    {
      	$dbo = DB::dbo();
      	$sql = $dbo->prepare("SELECT `id` FROM `users` WHERE `vk_id` = :vk_id;");
      	$sql->execute([':vk_id' => $vk_id]);
      	$answer = $sql->fetch(PDO::FETCH_ASSOC);
      
      	return $answer['id'];
    }
}