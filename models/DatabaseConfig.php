<?php
//Подключение к БД 
class DB
{
    private static $dbname   = 'testvk74'; //Имя БД
    private static $username = 'testvk74'; //Имя пользователя
    private static $password = 's1jPHEmt'; //Пароль
    private static $dbo;                   //Объект подключения к БД
    
    protected static function dbo()
    {
        try
        {
            if (!self::$dbo)  
            {
                self::$dbo = new PDO('mysql:host=127.0.0.1;dbname='.self::$dbname, 
                                                                    self::$username, 
                                                                    self::$password);
                self::$dbo->exec('SET NAMES "utf8";');
            }
         
            return self::$dbo;
        }
        catch(Exception $error) 
        {
            echo "Ошибка подключения к БД";
        }
    }
}