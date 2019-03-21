<?php
Class DBConnect{
    private static $host = "localhost";
    private static $user = "root";
    private static $pwd = "";
    private static $db = "php";
    private static $obj = null;

    private function __construct()
    {
    }

    static function getInstance(){
        if(self::$obj == null){
            self::$obj = new mysqli(self::$host, self::$user, self::$pwd, self::$db);
            if (self::$obj -> connect_errno)
            {
                printf("Loi xay ra %s\n", $mysqli->connect_error);
                exit();
            }
            self::$obj->set_charset("utf8");
        }
        return self::$obj;
    }
}