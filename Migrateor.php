<?php namespace Migrateor;

abstract class Migrateor
{
    protected $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public abstract function up();

    public abstract function down();

    protected function create($name, Callable $callable)
    {
        $table = new Table();
        $callable($table);

        $this->pdo->exec("CREATE TABLE `{$name}` (" . $table->toSql() . ");");
    }

    protected function dropTable($name)
    {
        $this->pdo->exec("DROP TABLE `{$name}`");
    }
}