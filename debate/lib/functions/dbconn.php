<?php
// Extend this class to re-use db connection
class DbConn
{
    public $conn;
    public function __construct()
    {
        require __DIR__ . '/../config.php';
        $host = $config['db']['host']; // Host name
		$port = $config['db']['port']; // Port
        $username = $config['db']['user']; // Mysql username
        $password = $config['db']['pass']; // Mysql password
        $db_name = $config['db']['name']; // Database name

		$this->conn = new PDO('mysql:host=' . $host . ';port=' . $port . ';dbname=' . $db_name . ';charset=utf8', $username, $password);
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    }
}