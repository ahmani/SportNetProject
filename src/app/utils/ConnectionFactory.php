<?php

namespace app\utils;
require_once "phpPasswordHashingLib-master/passwordLib.php";
require_once "phpPasswordHashingLib-master/passwordLibClass.php";
class ConnectionFactory{

  private static $config;
  private static $db;

  public static function setConfig($nom_fichier){
    $parse = parse_ini_file($nom_fichier);
    self::$config["host"] =  $parse["host"];
    self::$config["user"] =  $parse["user"];
    self::$config["base"] =  $parse["base"];
    self::$config["pass"] =  $parse["pass"];
  }

  public static function makeConnection(){
    $dsn = "mysql:host=".self::$config['host'].";dbname=".self::$config['base'];

    try{
      $db = new \PDO($dsn, self::$config['user'], self::$config['pass']);
    } catch(PDOException $e){
      echo "Connection error : $dsn" . $e->getMessage();
      exit;
    }
    return $db;
  }
}
