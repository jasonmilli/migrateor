<?php

if (!isset($argv[1])) {
    throw new Exception('Incorrect number of command line arguments, require a method');
}

if (!in_array($argv[1], ['up', 'down', 'create'])) {
    throw new Exception('Bad method call');
}

$pdo = new PDO('mysql:dbname=migrateor;host=127.0.0.1', 'root', '', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

switch ($argv[1]) {
    case 'up':
        require_once 'up.php';
        break;
    case 'down':
        require_once 'down.php';
        break;
    case 'create':
        require_once 'create.php';
        break;
}
