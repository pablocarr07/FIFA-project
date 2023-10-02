<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CdpsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CdpsTable Test Case
 */
class CdpsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\CdpsTable
     */
    public $Cdps;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.cdps',
        'app.loads',
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
        $config = TableRegistry::exists('Cdps') ? [] : ['className' => 'App\Model\Table\CdpsTable'];
        $this->Cdps = TableRegistry::get('Cdps', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Cdps);

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
