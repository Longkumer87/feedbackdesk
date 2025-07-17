<?php

class Database
{
    public function getDb()
    {

        try {

            $db_host = "localhost";
            $db_username = "ghckb";
            $db_password = "ghckb";
            $db_name = "feedbackdesk";

            $dsn = "mysql:host=$db_host;dbname=$db_name;charset=utf8mb4";
        
            $pdo = new PDO($dsn, $db_username, $db_password);

            $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

            return $pdo;

        } catch (PDOException $e) {
            echo "Database connection fail".$e->getMessage();
            return null;
        }
    }
}
