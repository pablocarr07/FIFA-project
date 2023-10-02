<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CdptimelineTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CdptimelineTable Test Case
 */
class CdptimelineTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\CdptimelineTable
     */
    public $Cdptimeline;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.cdptimeline',
        'app.cdpsstates',
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
        'app.items',
        'app.items_classifications',
        'app.items_types',
        'app.cdprequests_items',
        'app.resources'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Cdptimeline') ? [] : ['className' => 'App\Model\Table\CdptimelineTable'];
        $this->Cdptimeline = TableRegistry::get('Cdptimeline', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Cdptimeline);

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
