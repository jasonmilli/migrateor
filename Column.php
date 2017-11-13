<?php namespace Migrateor;

class Column
{
    private $name;
    private $type;
    private $notNull = true;
    private $unique = false;

    public function __construct($name, $type)
    {
        $this->name = $name;
        $this->type = $type;
    }

    public function nullable()
    {
        $this->notNull = false;
    }

    public function unique()
    {
        $this->unique = true;
    }

    public function toSql()
    {
        return "`{$this->name}` {$this->type}" . ($this->notNull ? ' NOT NULL' : '') . ($this->unique ? ' UNIQUE' : '');
    }
}