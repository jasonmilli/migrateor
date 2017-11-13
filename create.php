<?php

if (!isset($argv[2])) {
    throw new Exception('Migrateor name not found');
}

$migrateorFile = 'migrateors/' . date('Ymdhis') . $argv[2] . '.php';

file_put_contents($migrateorFile, str_replace('__TEMPLATE__', $argv[2], file_get_contents('Template.php')));

echo "{$migrateorFile} created\n";