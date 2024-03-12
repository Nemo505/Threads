<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ActiveUsersTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ActiveUsersTable Test Case
 */
class ActiveUsersTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ActiveUsersTable
     */
    protected $ActiveUsers;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.ActiveUsers',
        'app.Users',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('ActiveUsers') ? [] : ['className' => ActiveUsersTable::class];
        $this->ActiveUsers = $this->getTableLocator()->get('ActiveUsers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->ActiveUsers);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\ActiveUsersTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\ActiveUsersTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
