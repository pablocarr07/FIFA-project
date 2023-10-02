<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LoadsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LoadsTable Test Case
 */
class LoadsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\LoadsTable
     */
    public $Loads;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.loads',
        'app.cdps',
        'app.cdps_tmp',
        'app.compromisos',
        'app.compromisos_tmp'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Loads') ? [] : ['className' => 'App\Model\Table\LoadsTable'];
        $this->Loads = TableRegistry::get('Loads', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Loads);

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
}
