<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CdprequestsItemsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CdprequestsItemsTable Test Case
 */
class CdprequestsItemsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\CdprequestsItemsTable
     */
    public $CdprequestsItems;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.cdprequests_items',
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
        $config = TableRegistry::exists('CdprequestsItems') ? [] : ['className' => 'App\Model\Table\CdprequestsItemsTable'];
        $this->CdprequestsItems = TableRegistry::get('CdprequestsItems', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CdprequestsItems);

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
