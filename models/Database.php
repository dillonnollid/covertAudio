<?php
namespace models;

use Dotenv\Dotenv;

class Database {
    private static $instance = null;
    private $con;

    private function __construct() {
        require_once __DIR__ . '\..\vendor\autoload.php';
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
        $dotenv->load();

        // Private constructor to prevent instantiation from outside
        $dbHost = $_ENV['DB_HOST'];
        $dbUsername = $_ENV['DB_USERNAME'];
        $dbPassword = $_ENV['DB_PASSWORD'];
        $dbDatabase = $_ENV['DB_DATABASE'];
        $this->con = mysqli_connect($dbHost, $dbUsername, $dbPassword, $dbDatabase);

        // Check connection
        if (mysqli_connect_errno()) {
            die("Failed to connect to MySQL: " . mysqli_connect_error());
        }
    }

    //Singleton design pattern to prevent $con object being created many times.
    public static function getInstance() {
        // Method to get the single instance of the database connection
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection() {
        // Method to get the actual database connection
        return $this->con;
    }
}
?>
