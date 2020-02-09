<?php

class Database
{
    private static $db = null;

    private function __construct()
    {
    }

    public static function getDB()
    {

        if (self::$db == NULL) {
            try {
                $servername = "localhost";
                $db = "weinshop";

                self::$db = new PDO("mysql:host=$servername;dbname=$db", 'root');
                self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$db->exec("set names utf8");
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }
        return self::$db;
    }
}
