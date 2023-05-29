# Database Installer : v2

Install or update the database. This script uses the database configuration in `/api/.env`.

1. Run installer script
2. Select mode

## Modes

### New Database

Select option `1` to drop all tables from the database and install fresh tables and data.

### Update

Select option `2` to run updates created after `version 2.0` release.

### Sample Data

Select option `3` to import sample data used for development purposes.

If sample data has already been imported you will need to rerun option `1`.

## Run

`./installer.sh`

### Permissions

`chmod +x installer.sh`

## Dump

`- mysqldump -u workout -p workout > file.sql`