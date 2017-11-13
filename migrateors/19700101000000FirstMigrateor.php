<?php namespace Migrateor;

class FirstMigrateor extends Migrateor
{
    public function up()
    {
        $this->create('migrateors', function(Table $table) {
            $table->unsignedInteger('id', true);
            $table->string('name')->unique();
        });
    }

    public function down()
    {
        $this->dropTable('migrateors');
    }
}