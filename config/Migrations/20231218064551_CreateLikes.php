<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateLikes extends AbstractMigration
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
        $likeTable = $this->table('likes');
        $likeTable->addColumn('user_id', 'integer', [
            'default' => null,
            'null' => true,
        ]);
        $likeTable->addForeignKey('user_id', 'users', 'id', [
            'delete' => 'SET_NULL', // Define behavior on DELETE
            'update' => 'CASCADE', // Define behavior on UPDATE
        ]);

        $likeTable->addColumn('post_id', 'integer', [
            'default' => null,
            'null' => true,
        ]);
        $likeTable->addForeignKey('post_id', 'posts', 'id', [
            'delete' => 'SET_NULL', // Define behavior on DELETE
            'update' => 'CASCADE', // Define behavior on UPDATE
        ]);

        $likeTable->addColumn('created', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
        $likeTable->addColumn('modified', 'datetime', [
            'default' => null,
            'null' => false,
        ]);

        $likeTable->create();
    }
}
