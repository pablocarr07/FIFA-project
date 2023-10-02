<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CdpsTmpTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CdpsTmpTable Test Case
 */
class CdpsTmpTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\CdpsTmpTable
     */
    public $CdpsTmp;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.cdps_tmp',
        'app.loads',
        'app.cdps',
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
        $config = TableRegistry::exists('CdpsTmp') ? [] : ['className' => 'App\Model\Table\CdpsTmpTable'];
        $this->CdpsTmp = TableRegistry::get('CdpsTmp', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CdpsTmp);

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
