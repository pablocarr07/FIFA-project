<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ItemsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ItemsTable Test Case
 */
class ItemsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ItemsTable
     */
    public $Items;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.items',
        'app.items_classifications',
        'app.items_types',
        'app.cdprequests',
        'app.applicants',
        'app.types_identification',
        'app.groups',
        'app.immediate_boss',
        'app.types',
        'app.charges',
        'app.roles',
        'app.roles_users',
        'app.users',
        'app.created_by',
        'app.states',
        'app.movement_types',
        'app.cdprequests_items',
        'app.resources',
        'app.timeline',
        'app.cdpsstates'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Items') ? [] : ['className' => 'App\Model\Table\ItemsTable'];
        $this->Items = TableRegistry::get('Items', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Items);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
