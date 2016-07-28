<?php

namespace Inspiration\Database;

class Connection
{

    public function __construct($config = null)
    {
        if (!isset($config)) {
            return $this;
        }

        if (is_array($config)) {
            $this->config = $config;
            return $this;
        }

        if (!file_exists($config)) {
            throw new \Exception('Configuration file not found in path: ' . $config);
        }

        $this->config = include $config;
    }

    protected $config;
    protected $dsn;
    protected $credentials;
    protected $driver;
    protected $context;

    public function setConfig($config)
    {
        $this->config = $config;
        return $this;
    }

    public function getConfig()
    {
        return $this->config;
    }

    public function setContext($context)
    {
        $this->context = $context;
        return $this;
    }

    public function getContext()
    {
        return $this->context;
    }

    public function getDriver()
    {
        return $this->driver;
    }

    public function connect()
    {
        $dsn = $this->getDsn();

        $this->driver = new \PDO($dsn, $this->credentials['user'], $this->credentials['password']);
    }

    public function getConfigFromContext()
    {
        if (!isset($context)) {
            $context = $this->context;
        }

        if (!array_key_exists($context, $this->config)) {
            return [];
        }

        return $this->config[$context];
    }

    public function getDsn()
    {
        if (!isset($this->context)) {
            throw new \Exception("Connection context is not defined");
        }
        
        if (!isset($this->config)) {
            throw new \Exception("Connection configuration is not defined");
        }

        if (!array_key_exists($this->context, $this->config)) {
            throw new \Exception("Connection context dont't exists in connection configuration");
        }

        $contextSettings = $this->config[$this->context];

        $driver = $host = $port = $dbname = $unix_socket = $options = $user = $password = null;
        foreach ($contextSettings as $parameter => $value) {

            switch ($parameter) {
                case 'driver':
                    $driver = $value;
                    break;
                case 'host':
                case 'hostname':
                    $host = $value;
                    break;
                case 'port':
                    $port = $value;
                    break;
                case 'unix_socket':
                    $unix_socket = $value;
                    break;
                case 'driver_options':
                case 'options':
                    $options = $value;
                    break;
                case 'dbname':
                case 'database':
                    $dbname = $value;
                    break;
                case 'user':
                case 'username':
                    $user = $value;
                    break;
                case 'pass':
                case 'password':
                    $password = $value;
                    break;
            }
        }

        if (isset($unix_socket) && isset($host)) {
            throw new \Exception("Both host and unix_socket were set");
        }

        if ($driver == 'sqlite') {
            $this->credentials['user'] = null;
            $this->credentials['password'] = null;
            return $driver . ':' . $dbname;
        }

        $this->credentials['user'] = $user;
        $this->credentials['password'] = $password;
        return $driver . ':' . 'host=' . $host . ';port=' . $port . ';dbname=' . $dbname;
    }
}
