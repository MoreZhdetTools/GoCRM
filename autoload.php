<?php
//Кодировка в UTF-8
mb_internal_encoding('utf-8');
//Старт сессии 
session_start();
//Подключение функций
include 'lib/functions.php';
include 'lib/vk.php';
//Подключение моделей
include 'models/DatabaseConfig.php';
include 'models/Users.php';
include 'models/Friends.php';
//Подключение контроллеров
include 'controllers/AuthorizationController.php';
include 'controllers/FriendsController.ph