<?php

namespace  Source\Core;

use PDO;
use PDOException;

class Connect
{
    /*** @var */
    private static $instance;

    /*** @const */
    private const OPTIONS = [
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        PDO::ATTR_CASE => PDO::CASE_NATURAL
    ];

    /**
     * @return PDO
     */
    public static function getInstance():PDO
    {
        if(empty(self::$instance)) {
            try {
                //example: mysql:host=localhost;port=3306;dbname=testdb, user, pass
                self::$instance = new PDO(
                    env('DB_DRIVER') . ":host=" . env('DB_HOST') . ";port=" . env("DB_PORT") . ";dbname=" . env('DB_DATABASE'),
                    env('DB_USERNAME'),
                    env('DB_PASSWORD'),
                    self::OPTIONS
                );
            } catch (PDOException $exception) {
                die("Opss! Erro ao conectar... Erro: {$exception}");
            }
        }

        return self::$instance;
    }

    final public function __clone() {

    } 

    final public function __construct() {
        
    }
}
