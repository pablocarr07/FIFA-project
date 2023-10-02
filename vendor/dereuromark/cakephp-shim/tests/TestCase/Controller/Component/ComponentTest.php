<?php
namespace Shim\Test\TestCase\Controller\Component;

use Cake\Controller\ComponentRegistry;
use Cake\Controller\Controller;
use Shim\Controller\Component\Component;
use Cake\Network\Request;
use Shim\TestSuite\TestCase;
use Cake\Event\Event;
/**
 * SessionComponentTest class
 *
 */
class ComponentTest extends TestCase {

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		$this->Controller = new Controller(new Request());
		$this->ComponentRegistry = new ComponentRegistry($this->Controller);
	}

/**
 * testBeforeFilter method
 *
 * @return void
 */
	public function testBeforeFilter() {
		$Component = new Component($this->ComponentRegistry);

		$this->assertInstanceOf('Cake\Controller\Controller', $Component->Controller);
	}

}
