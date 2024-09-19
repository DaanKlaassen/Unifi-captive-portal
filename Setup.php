<?php

//Check if database exists
$dbpath = __DIR__ . '/database/db.sqlite';

if (file_exists($dbpath)) {
    echo "Database already exists, Exiting...\n Delete the database file\n";
    exit(1);
}

//run doctrine schema creation...
echo "Creating schema... \n";
exec('php bin/doctrine orm:schema-tool:create', $output, $returnVar);

if ($returnVar !== 0) {
    echo "Schema creation failen: \n";
    print_r($output);
    exit(1);
}

echo "Schema created successfully!\n";

//run the seeder
echo "Running the seeder...\n";
require_once 'database/Seeder.php';

echo "Seeding complete!\n";
