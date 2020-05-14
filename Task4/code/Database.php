<?php

class Database
{
    private const databaseConfigFile = "config.ini";
    private $host;
    private $dbname;
    private $user;
    private $password;
    private $connection;

    // database class construct
    function __construct() {
        // check database config file
        if (!is_file(self::databaseConfigFile)) {
            die("Error: Can't load database config file!" . "<br/>");
        }
        // read database config file
        $ini_array = parse_ini_file(self::databaseConfigFile, true);
        // check mandatory variables in config file
        if (!isset($ini_array['db']['host']) || !isset($ini_array['db']['dbname']) || !isset($ini_array['db']['user']) || !isset($ini_array['db']['password'])) {
            die("Error: Database config file corrupted!" . "<br/>");
        }
        // check empty config variables
        if (empty($ini_array['db']['host']) || empty($ini_array['db']['dbname']) || empty($ini_array['db']['user'])) {;
            die("Error: You must set config variables" . "<br/>");
        }
        // set database properties
        $this->host = $ini_array['db']['host'];
        $this->dbname = $ini_array['db']['dbname'];
        $this->user = $ini_array['db']['user'];
        $this->password = $ini_array['db']['password'];
    }

    // open connection with database using pg_connect
    public function connectPgConnect(){
        // connect to database
        $this->connection = pg_connect("host=" . $this->host . " dbname=" . $this->dbname . " user=" . $this->user . " password=" . $this->password)
            or die("Error: " . pg_last_error() . "<br/>");
        return $this->connection;
    }

    // open connection with database using PDO
    public function connectPDO()
    {
        // connection string
        $dsn = "pgsql:host={$this->host};dbname={$this->dbname}";
        // connection settings
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        // connect to database
        try {
            $this->connection = new PDO($dsn, $this->user, $this->password, $options);
            return $this->connection;
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage() . "<br/>");
        }
    }

    // close connection with database
    public function close(){
        $this->connection = null;
    }
}