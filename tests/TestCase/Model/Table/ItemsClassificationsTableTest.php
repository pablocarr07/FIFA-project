<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ItemsClassificationsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ItemsClassificationsTable Test Case
 */
class ItemsClassificationsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ItemsClassificationsTable
     */
    public $ItemsClassifications;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.items_classifications'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('ItemsClassifications') ? [] : ['className' => 'App\Model\Table\ItemsClassificationsTable'];
        $this->ItemsClassifications = TableRegistry::get('ItemsClassifications', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ItemsClassifications);

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
