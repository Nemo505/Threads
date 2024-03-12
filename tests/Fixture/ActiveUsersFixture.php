<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ActiveUsersFixture
 */
class ActiveUsersFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'user_id' => 1,
                'status' => 'Lorem ipsum dolor sit amet',
                'created' => '2024-03-12 09:21:31',
                'modified' => '2024-03-12 09:21:31',
            ],
        ];
        parent::init();
    }
}
