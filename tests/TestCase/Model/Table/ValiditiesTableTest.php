<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ValiditiesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ValiditiesTable Test Case
 */
class ValiditiesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ValiditiesTable
     */
    public $Validities;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.validities'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Validities') ? [] : ['className' => 'App\Model\Table\ValiditiesTable'];
        $this->Validities = TableRegistry::get('Validities', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Validities);

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
