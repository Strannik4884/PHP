<?php

class Database
{
    private $databaseConfigFile = "config.ini";
    private $connection;

    public function connect()
    {
        // check database config file
        if (!is_file($this->databaseConfigFile)) {
            print("Error: Can't load database config file!");
            die();
        }
        // read database config file
        $ini_array = parse_ini_file($this->databaseConfigFile, true);
        // check mandatory variables in config file
        if (!isset($ini_array['db']['host']) || !isset($ini_array['db']['dbname']) || !isset($ini_array['db']['user']) || !isset($ini_array['db']['password'])) {
            print("Error: Database config file corrupted!");
            die();
        }
        // check empty config variables
        if (empty($ini_array['db']['host']) || empty($ini_array['db']['dbname']) || empty($ini_array['db']['user'])) {
            print("Error: You must set config variables");
            die();
        }
        // connection string
        $dsn = "pgsql:host={$ini_array['db']['host']};dbname={$ini_array['db']['dbname']}";
        // connection settings
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        // connect to database
        try {
            $this->connection = new PDO($dsn, $ini_array['db']['user'], $ini_array['db']['password'], $options);
            return $this->connection;
        } catch (PDOException $e) {
            print "Error: " . $e->getMessage();
            die();
        }
    }

    public function close(){
        $this->connection = null;
    }
}