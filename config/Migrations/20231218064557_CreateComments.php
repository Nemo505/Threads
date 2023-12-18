<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateComments extends AbstractMigration
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
        $commentTable = $this->table('comments');
        $commentTable->addColumn('user_id', 'integer', [
            'default' => null,
            'null' => true,
        ]);
        $commentTable->addForeignKey('user_id', 'users', 'id', [
            'delete' => 'SET_NULL', // Define behavior on DELETE
            'update' => 'CASCADE', // Define behavior on UPDATE
        ]);

        $commentTable->addColumn('post_id', 'integer', [
            'default' => null,
            'null' => true,
        ]);
        $commentTable->addForeignKey('post_id', 'posts', 'id', [
            'delete' => 'SET_NULL', // Define behavior on DELETE
            'update' => 'CASCADE', // Define behavior on UPDATE
        ]);

        $commentTable->addColumn('content', 'text', [
            'default' => null,
            'null' => false,
        ]);
        
        $commentTable->addColumn('created', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
        $commentTable->addColumn('modified', 'datetime', [
            'default' => null,
            'null' => false,
        ]);

        $commentTable->create();
    }
}
