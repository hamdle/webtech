<?php

namespace Core;

class Database {
    private static $db = null;

    public static function db()
    {
        if (is_null(self::$db)) {
            $dsn = "mysql:host=".$_ENV["DB_HOST"].";dbname=".$_ENV["DB_NAME"].";charset=utf8mb4";
            $options = [
                \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                \PDO::ATTR_EMULATE_PREPARES   => false,
            ];
            self::$db = new \PDO($dsn, $_ENV["DB_USER"], $_ENV["DB_PASS"], $options);
        }
        return self::$db;
    }

    public static function execute($file, $args)
    {
        $results = null;
        $path = dirname(__FILE__).'/Sql/'.$file;

        if (is_readable($path)) {
            $sql = file_get_contents($path);

            if ($_ENV['DEBUG'] == 1) {
                \Core\Utils\Log::error(date('Y-m-d H:i:s'));
                \Core\Utils\Log::error($sql, "SQL query");
                \Core\Utils\Log::error($args, "SQL args");
            }

            $stmt = self::db()->prepare($sql);
            foreach($args as $key => $value) {
                $stmt->bindValue($key, $value);
            }

            $stmt->execute();

            foreach ($stmt as $row) {
                $results[] = $row;
            }
        }

        return $results;
    }
}