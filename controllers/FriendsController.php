<?php

class FriendsController
{
  	private $vk_friend_id; //ID друга в ВК
  	private $email;        //Почта
  	private $phone;        //Телефон 
  	private $fio;          //ФИО
  
		public function __construct($post = [])
    {
      	$this->vk_friend_id = checkArray($post, 'vk_friend_id');
        $this->email 				= checkArray($post, 'email');
      	$this->phone 				= checkArray($post, 'phone');
      	$this->fio   				= checkArray($post, 'fio');
    }
  
  	public function update()
    {
      	Friends::updateFriend($this->vk_friend_id, $this->email, $this->phone, $this->fio); //Изменяю данные в БД
      	header("Location: /friends");                                                       //Редирект
    }
}