<?php
/**
 * Command line tool for quickly updating and modifying the database.
 *
 * "import" uses data defined as .sql in /api/database/
 * "export" puts data defined as .sql in /tmp/
 *
 */

require dirname(__DIR__,2)."/autoload.php";

if (count($argv) < 2) {
    print "Error: Invalid number of arguments.".PHP_EOL.PHP_EOL;
    print help();
    exit();
}

if ($argv[1] == "import") {
    switch ($argv[2]) {
        case "data":
            exec("mysql -u ".$_ENV['DB_USER'].
                " -p".$_ENV['DB_PASS'].
                " --database ".$_ENV['DB_NAME'].
                " < ".dirname(__DIR__,1)."/database/testdata.sql"
            );
            break;
        case "schema":
            exec("mysql -u ".$_ENV['DB_USER'].
                " -p".$_ENV['DB_PASS'].
                " --database ".$_ENV['DB_NAME'].
                " < ".dirname(__DIR__,1)."/database/schema.sql"
            );
            break;
        default:
            print help();
    }
} else if ($argv[1] == "export") {
    exec("mysqldump".
        " --column-statistics=0".
        " -u ".$_ENV['DB_USER'].
        " -p".$_ENV['DB_PASS'].
        " ".$_ENV['DB_NAME'].
        " > /tmp/workout__".date("Y-m-d--H:i:s").".sql"
    );
} else {
    print help();
}

function help() {
    return "Usage:".PHP_EOL.PHP_EOL.
        "$ php db.php import data".PHP_EOL.
        "$ php db.php import schema".PHP_EOL.
        "$ php db.php export".PHP_EOL;
}