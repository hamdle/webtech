<?php

$commands = [
    'schema' => 'ReloadDatabaseSchema',
    'data' => 'ImportTestData',
    'reload' => 'ReloadAndImport',
    'export' => 'ExportData',
    'help' => 'Help'
];

class DatabaseCommand
{
    // Use Env loader TODO
    private $db_name = 'workouts';
    private $db_user = 'homestead';
    private $db_pass = 'secret';
    private $db_schema = '../../docs/db/schema.sql';
    private $db_data = '../../docs/db/testdata.sql';

    public function reloadSchema()
    {
        return "mysql -u {$this->db_user} -p{$this->db_pass} --database {$this->db_name} < {$this->db_schema}";
    }

    public function importData()
    {
        return "mysql -u {$this->db_user} -p{$this->db_pass} --database {$this->db_name} < {$this->db_data}";
    }

    public function exportData()
    {
        return "mysqldump -u {$this->db_user} -p{$this->db_pass} {$this->db_name} > workout_export.sql";
    }
}

foreach ($argv as $value)
{
    if (array_key_exists($value, $commands))
    {
        $commands[$value]();
    } 
}

function ReloadDatabaseSchema()
{
    echo "Reloading database...\n";
    $dbCmd = new DatabaseCommand();
    exec($dbCmd->reloadSchema());
    echo "Done.\n";
}

function ImportTestData()
{
    echo "Importing test data...\n";
    $dbCmd = new DatabaseCommand();
    exec($dbCmd->importData());
    echo "Done.\n";
}

function ReloadAndImport()
{
    ReloadDatabaseSchema();
    ImportTestData();
}

function ExportData()
{
    echo "Exporting data...\n";
    $dbCmd = new DatabaseCommand();
    exec($dbCmd->exportData());
    echo "Done.\n";
}

function Help()
{
    echo "\nCommands:\n\n";
    echo "schema\t\t- Reload database schema\n";
    echo "data\t\t- Reimport database test data\n";
    echo "reload\t\t- Reload schema and reimport test data\n";
    echo "export\t\t- Export data here\n";
    echo "\nUsage: php database.php reload\n";
}
