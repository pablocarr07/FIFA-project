<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CompromisosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CompromisosTable Test Case
 */
class CompromisosTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\CompromisosTable
     */
    public $Compromisos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.compromisos',
        'app.loads',
        'app.cdps',
        'app.cdps_tmp',
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
        $config = TableRegistry::exists('Compromisos') ? [] : ['className' => 'App\Model\Table\CompromisosTable'];
        $this->Compromisos = TableRegistry::get('Compromisos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Compromisos);

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
