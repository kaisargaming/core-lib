<?php
namespace KGaming\Core;

class Dbo
{
    private static $conn = null;
    protected $messenger;

    public function __construct()
    {
        $this->messenger = new Messenger();
    }

    public static function getConnection()
    {
        /**
         * The Database credentials should be placed
         * using dotenv file, this class will pickup
         * the configuration through it.
         */
        $dbuser = getenv('DB_USER');
        $dbpass = getenv('DB_PASS');
        $dbhost = getenv('DB_HOST');
        $dbname = getenv('DB_NAME');

        if (self::$conn)
        {
            return self::$conn;
        }

        try
        {
            $dsn = "mysql:host={$dbhost};dbname={$dbname}";
            self::$conn = new \PDO($dsn, $dbuser, $dbpass);
            self::$conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            return self::$conn;
        }
        catch (\PDOException $e)
        {
            $this->messenger
                ->show("Error while connection to the database.", 'FATAL')
                ->debug($e->getMessage(), 'PDO Exception')
                ->shutdown();
        }
    }
}
