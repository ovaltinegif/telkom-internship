<?php
use Database\Seeders\DatabaseSeeder;

try {
    $seeder = new DatabaseSeeder();
    $seeder->run();
    echo "Seeding successful!\n";
}
catch (\Exception $e) {
    echo "Seeding failed: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString();
}
