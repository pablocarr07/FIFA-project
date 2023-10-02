<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CdpsstatesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CdpsstatesTable Test Case
 */
class CdpsstatesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\CdpsstatesTable
     */
    public $Cdpsstates;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
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
        $config = TableRegistry::exists('Cdpsstates') ? [] : ['className' => 'App\Model\Table\CdpsstatesTable'];
        $this->Cdpsstates = TableRegistry::get('Cdpsstates', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Cdpsstates);

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
