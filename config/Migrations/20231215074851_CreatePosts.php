<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreatePosts extends AbstractMigration
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
        $postTable = $this->table('posts');
        
        $postTable->addColumn('title', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);

        $postTable->addColumn('body', 'text', [
            'default' => null,
            'null' => false,
        ]);
        $postTable->addColumn('user_id', 'integer', [
            'default' => null,
            'null' => true,
        ]);
        $postTable->addForeignKey('user_id', 'users', 'id', [
            'delete' => 'SET_NULL', // Define behavior on DELETE
            'update' => 'CASCADE', // Define behavior on UPDATE
        ]);

        $postTable->addColumn('created', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
        $postTable->addColumn('modified', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
        $postTable->create();
        
    }
}
