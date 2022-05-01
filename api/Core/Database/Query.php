<?php

/*
 * Core/Database/Query.php: run database queries
 *
 * Copyright (C) 2021 Eric Marty
 */

namespace Core\Database;

use mysqli;
use \Core\Utils\Log;

class Query
{
    // a mysqli connection object
    protected static $mysql = null;

    public static function connection()
    {
        if (is_null(self::$mysql))
        {
            self::$mysql = new mysqli(
                $_ENV["DB_HOST"],
                $_ENV["DB_USER"],
                $_ENV["DB_PASS"],
                $_ENV["DB_NAME"]
            );

            if (self::$mysql->connect_errno)
            {
                // TODO this should throw an error instead
                exit("Database connection failed.");
            }
        }

        return self::$mysql;
    }

    public static function close()
    {
        if (!is_null(self::$mysql))
            self::$mysql->close();
    }

    // Run a sql query using OO version of mysqli.
    // $query = a complete SQL query
    // return = array | id | false | null
    public static function run($query)
    {
        $db = self::connection();
        $rows = [];

        if ($results = $db->query($query))
        {
            if ($results === false)
            {
                if ($db->error)
                    Log::error($db->error, "DATABASE");

                return null;
            }
            if (is_bool($results))
            {
                if ($results)
                    return $db->insert_id;

                return null;
            }
            if ($db->error)
            {
                Log::error($db->error, "DATABASE");
                return null;
            }

            while ($row = $results->fetch_assoc())
            {
                $rows[] = $row;
            }

            $results->free();
        }

        return $rows;
    }

    // return = id | null
    public static function insert($table, $fields, $values)
    {
        $query = "insert into ".$table;

        $query .= " (";
        $query .= implode(
            ",",
            array_map(
                function ($entry) {
                    return "`".$entry."`";
                },
                $fields
            )
        );
        $query .= ")";

        $query .= " values (";
        $query .= implode(
            ",",
            array_map(
                function ($entry) {
                    return "'".mysqli_real_escape_string(self::connection(), $entry)."'";
                },
                $values
            )
        );
        $query .= ")";

        return self::run($query);
    }

    public static function delete($table, $where = null)
    {
        $query = "delete from ".$table;

        if (is_array($where))
        {
            $query .= " where ";

            $count = 0;
            foreach ($where as $key => $attribute)
            {
                $count++;
                if (!is_array($attribute))
                {
                    $query .= $key . " = '" . mysqli_real_escape_string(self::connection(), $attribute) . "'";
                    if (count($where) !== $count)
                        $query .= " and ";
                }
            }
        }

        return self::run($query);
    }

    // return = array | false
    public static function select($table, $selects, $where = null)
    {
        $query = "select ";

        if ($selects == '*')
            $query .= $selects;
        else if (is_array($selects))
            $query .= implode(",", $selects);

        $query .= " from ".$table;

        if (is_array($where))
        {
            $query .= " where ";

            $count = 0;
            foreach ($where as $key => $attribute)
            {
                $count++;
                if (!is_array($attribute))
                {
                    $query .= $key . " = '" . mysqli_real_escape_string(self::connection(), $attribute) . "'";
                    if (count($where) !== $count)
                        $query .= " and ";
                }
            }
        }

        return self::run($query);
    }
}
