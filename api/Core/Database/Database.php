<?php

namespace api\Core\Database;

use api\Core\Utils\Log;

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

    public static function execute($file, $args, $path = null)
    {
        $results = null;
        if (is_null($path))
        {
            $path = dirname(__DIR__,1).'/Sql/'.$file;
        }
        else
        {
            $path = $path.'/'.$file;
        }

        if (is_readable($path)) {
            $sql = file_get_contents($path);

            if ($_ENV['DEBUG'] == 1)
            {
                Log::error($sql, "SQL query");
                Log::error($args, "SQL args");
            }

            $stmt = self::db()->prepare($sql);
            $stmt->execute($args);

            foreach ($stmt as $row) {
                $results[] = $row;
            }
        }

        return $results;
    }

    public static function run($sql, $args = [])
    {
        if ($_ENV['DEBUG'] == 1)
        {
            Log::error($sql, "SQL query");
            Log::error($args, "SQL args");
        }

        $stmt = self::db()->prepare($sql);
        $stmt->execute($args);

        foreach ($stmt as $row) {
            $results[] = $row;
        }

        return $results;
    }

    public static function log($message, $type, $user)
    {
        $sql = "
            insert into logs 
            (log_type_id, user_id, timestamp, message)
            values ((select id from log_types where log_type='{$type}'), :user, now(), :message)";
        $args = [
            "message" => $message,
            "user" => $user
        ];
        $stmt = self::db()->prepare($sql);
        $stmt->execute($args);
    }
}