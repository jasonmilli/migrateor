<?php

require 'Column.php';
require './Table.php';
require 'Migrateor.php';

$migrateorFiles = array_diff(scandir('migrateors'), ['..', '.']);

try {
    $sth = $pdo->prepare("SELECT `name` FROM `migrateors`");
    $sth->execute();

    $migrateors = $sth->fetchAll();
} catch (Exception $e) {
    $migrateors = [];
}

$migrateored = false;
foreach ($migrateorFiles as $migrateorFile) {
    $found = false;
    foreach ($migrateors as $migrateor) {
        if ($migrateor['name'] == $migrateorFile) {
            $found = true;
            break;
        }
    }
    if ($found) {
        continue;
    }

    require "migrateors/{$migrateorFile}";

    $className = '\Migrateor\\' . substr($migrateorFile, 14, strlen($migrateorFile) - 18);
    $migrateor = new $className($pdo);

    try {
        $pdo->beginTransaction();

        $migrateor->up();

        $pdo->exec("INSERT INTO `migrateors` VALUES(NULL, '{$migrateorFile}');");

        $pdo->commit();

        echo "{$migrateorFile} migrateored\n";
        $migrateored = true;
    }
    catch (Exception $e) {
        $pdo->rollBack();

        throw $e;
    }

    if (!$migrateored) {
        echo "Nothing to migrateor\n";
    }
}