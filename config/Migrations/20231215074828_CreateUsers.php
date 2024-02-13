<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateUsers extends AbstractMigration
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
        $userTable = $this->table('users');
        
        $userTable->addColumn('name', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);

        $userTable->addColumn('email', 'string', [
            'default' => null,
            'null' => false,
        ]);

        $userTable->addColumn('password', 'string', [
            'default' => null,
            'null' => false,
        ]);
        $userTable->addColumn('role', 'enum', [
            'values' => ['admin', 'user'], // Possible values for the role
            'default' => 'user', // Default role is 'user'
            'null' => false,
        ]);
        $userTable->addColumn('created', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
        $userTable->addColumn('modified', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
        $userTable->create();

        
        
    }
}
