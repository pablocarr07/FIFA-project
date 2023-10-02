<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CdpsmovementtypeTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CdpsmovementtypeTable Test Case
 */
class CdpsmovementtypeTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\CdpsmovementtypeTable
     */
    public $Cdpsmovementtype;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.cdpsmovementtype'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Cdpsmovementtype') ? [] : ['className' => 'App\Model\Table\CdpsmovementtypeTable'];
        $this->Cdpsmovementtype = TableRegistry::get('Cdpsmovementtype', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Cdpsmovementtype);

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
