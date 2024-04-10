<?php

namespace Api\Core\Database;

use Api\Core\Utils\Log;

class Database {
    private static $db = null;

    public static function db()
    {
        if (is_null(self::$db)) {
            try
            {
                $dsn = "mysql:host=".getenv("DB_HOST").";dbname=".getenv("DB_NAME").";charset=utf8mb4";
                $options = [
                    \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
                    \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                    \PDO::ATTR_EMULATE_PREPARES   => false,
                ];
                self::$db = new \PDO($dsn, getenv("DB_USER"), getenv("DB_PASS"), $options);
            }
            catch (\Exception $e)
            {
                Log::error("Error connecting to database.");
            }
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

            if (getenv("LOG_SQL_QUERIES"))
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
        if (getenv("LOG_SQL_QUERIES"))
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

    public static function config($key, $userId = null)
    {
        if (is_null($userId))
        {
            // TODO default to logged in user id
            $userId = 1; // System user
        }
        return self::execute("system-config.sql", ["ref" => $key, "userId" => $userId])[0]["data"];
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

    public static function insert($table, $fields, $values)
    {
        $query = "
            INSERT INTO {$table} (
                ".implode(',', array_map(function ($entry) { return "`{$entry}`"; }, $fields))."
            ) VALUES (
                ".implode(',', array_fill(0, count($values), '?'))."
            )";

        $stmt = self::$db->prepare($query);
        foreach ($values as $key => $value){
            $stmt->bindValue($key+1, $value);
        }

        $stmt->execute();

        return self::$db->lastInsertId();
    }

    public static function update($table, $fields, $values, $where)
    {
        $query = "
            UPDATE {$table} SET 
            " . implode(', ', array_map(function ($entry) { return "`{$entry}` = ?"; }, $fields)) . " 
            WHERE 
            ".$where;

        $stmt = self::$db->prepare($query);
        foreach ($values as $key => $value){
            $stmt->bindValue($key+1, $value);
        }

        return $stmt->execute();
    }

    public static function select($table, $selects, $where = null)
    {
        $query = "SELECT ";
        if ($selects == '*')
            $query .= $selects;
        else if (is_array($selects))
            $query .= implode(",", $selects);
        $query .= " FROM " . $table;

        $params = [];
        if (is_array($where))
        {
            $query .= " WHERE ";
            $count = 0;
            foreach ($where as $key => $attribute)
            {
                $count++;
                if (!is_array($attribute))
                {
                    $query .= $key . " = :".$key;
                    if (count($where) !== $count)
                        $query .= " AND ";

                    $params[":".$key] = $attribute;
                }
            }
        }

        $db = self::db();
        $stmt = $db->prepare($query);
        $stmt->execute($params);

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}