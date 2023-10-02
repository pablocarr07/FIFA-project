<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CdprequestsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CdprequestsTable Test Case
 */
class CdprequestsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\CdprequestsTable
     */
    public $Cdprequests;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
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
        'app.movement_types'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Cdprequests') ? [] : ['className' => 'App\Model\Table\CdprequestsTable'];
        $this->Cdprequests = TableRegistry::get('Cdprequests', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Cdprequests);

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

    /**
     * Test query method
     *
     * @return void
     */
    public function testQuery()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test deleteAll method
     *
     * @return void
     */
    public function testDeleteAll()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test getSoftDeleteField method
     *
     * @return void
     */
    public function testGetSoftDeleteField()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test hardDelete method
     *
     * @return void
     */
    public function testHardDelete()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test hardDeleteAll method
     *
     * @return void
     */
    public function testHardDeleteAll()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test restore method
     *
     * @return void
     */
    public function testRestore()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test currentUser method
     *
     * @return void
     */
    public function testCurrentUser()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
