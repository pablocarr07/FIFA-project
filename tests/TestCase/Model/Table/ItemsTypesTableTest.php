<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ItemsTypesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ItemsTypesTable Test Case
 */
class ItemsTypesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ItemsTypesTable
     */
    public $ItemsTypes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.items_types'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('ItemsTypes') ? [] : ['className' => 'App\Model\Table\ItemsTypesTable'];
        $this->ItemsTypes = TableRegistry::get('ItemsTypes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ItemsTypes);

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
