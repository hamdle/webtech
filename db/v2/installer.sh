#!/bin/bash

echo "Workout.dev"
echo -e "\e[32mDatabase Management Installer\e[0m"
echo "Modes:"
echo "  1 - Import new database"
echo -e "\e[31m      WARNING: This mode will DELETE ALL EXISTING TABLES AND DATA\e[0m"
echo "  2 - Update database"
echo "  3 - Import sample data"
echo "  4 - Exit"
read -p "Select mode: " mode

if [ "$mode" = "1" ]
then
  php dbmgmt.php -i
elif [ "$mode" = "2" ]; then
  php dbmgmt.php -u
elif [ "$mode" = "3" ]; then
  php dbmgmt.php -d
fi