<?php
require_once ('ConfigException.php');

class Database
{
    private const configFile = "../src/config.ini";
    private const timezone = 'Europe/Moscow';
    private $host;
    private $dbname;
    private $user;
    private $password;
    private $connection;

    // database class construct
    function __construct() {
        // check config file
        if (!is_file(self::configFile)) {
            throw (new ConfigException("Can't load config file"));
        }
        // read config file
        $ini_array = parse_ini_file(self::configFile, true);
        // check mandatory variables in config file
        if (!isset($ini_array['db']['host']) || !isset($ini_array['db']['dbname']) || !isset($ini_array['db']['user']) || !isset($ini_array['db']['password'])) {
            throw (new ConfigException("Config file corrupted (database section)"));
        }
        // check empty config variables
        if (empty($ini_array['db']['host']) || empty($ini_array['db']['dbname']) || empty($ini_array['db']['user'])) {
            throw (new ConfigException("You must set database config variables"));
        }
        // set properties
        $this->host = $ini_array['db']['host'];
        $this->dbname = $ini_array['db']['dbname'];
        $this->user = $ini_array['db']['user'];
        $this->password = $ini_array['db']['password'];
    }

    // open connection with database using PDO
    public function connect()
    {
        // connection string
        $dsn = "pgsql:host={$this->host};dbname={$this->dbname}";
        // connection settings
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ];
        // connect to database
        $this->connection = new PDO($dsn, $this->user, $this->password, $options);
        // set correct timezone
        $this->connection->exec("SET timezone = '" . self::timezone . "'");
        return $this->connection;
    }

    // close connection with database
    public function close(){
        $this->connection = null;
    }
}