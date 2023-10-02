<?php
namespace App\Test\TestCase\Controller;

use App\Controller\ResourcesController;
use Cake\TestSuite\IntegrationTestCase;

/**
 * App\Controller\ResourcesController Test Case
 */
class ResourcesControllerTest extends IntegrationTestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.resources',
        'app.cdprequests_items',
        'app.items',
        'app.items_classifications',
        'app.items_types',
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
        'app.movement_types',
        'app.timeline',
        'app.cdpsstates',
        'app.taks'
    ];

    /**
     * Test index method
     *
     * @return void
     */
    public function testIndex()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test view method
     *
     * @return void
     */
    public function testView()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add method
     *
     * @return void
     */
    public function testAdd()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     */
    public function testEdit()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     */
    public function testDelete()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
