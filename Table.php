<?php namespace Migrateor;

class Table
{
    private $columns = [];

    public function unsignedInteger($name, $autoIncrement = false)
    {
        $column = new Column($name, 'INT(11) UNSIGNED' . ($autoIncrement ? ' PRIMARY KEY AUTO_INCREMENT' : ''));
        $this->columns[] = $column;
        return $column;
    }

    public function string($name, $length = 255)
    {
        $column = new Column($name, "VARCHAR({$length})");
        $this->columns[] = $column;
        return $column;
    }

    public function toSql()
    {
        $columns = [];
        foreach ($this->columns as $column) {
            $columns[] = $column->toSql();
        }
        return implode(', ', $columns);
    }
}