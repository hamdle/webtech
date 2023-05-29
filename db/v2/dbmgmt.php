<?php

require dirname(__DIR__,2)."/autoload.php";

use Core\Database;

if (count($argv) !== 2 || !in_array($argv[1], ["-i", "-u", "-d"]))
{
    print "Invalid arguments, exiting script. No changes were made to the database.".PHP_EOL;
    exit();
}

$host = $_ENV["DB_HOST"];
$name = $_ENV["DB_NAME"];
$user = $_ENV["DB_USER"];
$pass = $_ENV["DB_PASS"];
$port = $_ENV["DB_PORT"];

if ($argv[1] === "-i")
{
    echo "Importing database...".PHP_EOL;
    exec("mysql"." ".
        "-u ".$_ENV['DB_USER']." ".
        "-p".$_ENV['DB_PASS']." ".
        "--database ".$_ENV['DB_NAME']." ".
        "< ".__DIR__."/import.sql"
    );
    echo "Done".PHP_EOL;
}
else if ($argv[1] === "-u")
{
    // TODO: implement update
    echo "No update script to run...".PHP_EOL;
    echo "Done".PHP_EOL;
}
else if ($argv[1] === "-d")
{
    echo "Importing sample data...".PHP_EOL;
    exec("mysql"." ".
        "-u ".$_ENV['DB_USER']." ".
        "-p".$_ENV['DB_PASS']." ".
        "--database ".$_ENV['DB_NAME']." ".
        "< ".__DIR__."/sampledata.sql"
    );
    echo "Done".PHP_EOL;
}