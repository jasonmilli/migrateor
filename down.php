<?php

require 'Column.php';
require './Table.php';
require 'Migrateor.php';

$sth = $pdo->prepare("SELECT * FROM `migrateors` ORDER BY `id` DESC LIMIT 1");
$sth->execute();

$migrateorRow = $sth->fetch(PDO::FETCH_ASSOC);

require "migrateors/{$migrateorRow['name']}";

$className = '\Migrateor\\' . substr($migrateorRow['name'], 14, strlen($migrateorRow['name']) - 18);
$migrateor = new $className($pdo);

try {
    $pdo->beginTransaction();

    $migrateor->down();
    if ($migrateorRow['name'] != '19700101000000FirstMigrateor.php') {
        $pdo->exec("DELETE FROM `migrateors` WHERE `id` = {$migrateorRow['id']};");
    }

    echo "{$migrateorRow['name']} rolled back\n";

    $pdo->commit();
}
catch (\Exception $e) {
    $pdo->rollBack();
    throw $e;
}