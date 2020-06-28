<?php

require_once ('Exceptions/ConfigException.php');

class Config
{
    private const configFile = "../src/config.ini";
    private $key;
    private $domain;

    // config class construct
    function __construct() {
        // check config file
        if (!is_file(self::configFile)) {
            throw new ConfigException("Can't load config file");
        }
        // read config file
        $ini_array = parse_ini_file(self::configFile, true);
        // check mandatory variables in config file
        if (!isset($ini_array['API']['key']) and !isset($ini_array['API']['domain'])) {
            throw new ConfigException("Config file corrupted");
        }
        // check config variables for empty
        if (empty($ini_array['API']['key']) and empty($ini_array['API']['domain'])) {
            throw new ConfigException("You must set API config variables");
        }
        // set properties
        $this->key = $ini_array['API']['key'];
        $this->domain = $ini_array['API']['domain'];
    }

    // get api key
    public function getKey(): string
    {
        return $this->key;
    }

    // get api domain
    public function getDomain(): string
    {
        return $this->domain;
    }
}