<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateActiveUsers extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     * @return void
     */
    public function change(): void
    {
        $active_table = $this->table('active_users');

        //user_id
        $active_table->addColumn('user_id', 'integer', [
            'default' => null,
            'null' => true,
        ]);
        $active_table->addForeignKey('user_id', 'users', 'id', [
            'delete' => 'SET_NULL', 
            'update' => 'CASCADE', 
        ]);

        //enum
        $active_table->addColumn('status', 'enum', [
            'values' => ['active', 'inactive'],
            'default' => 'active',
            'null' => false,
        ]);

        $active_table->addColumn('created', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
        
        $active_table->addColumn('modified', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
        $active_table->create();
    }
}
