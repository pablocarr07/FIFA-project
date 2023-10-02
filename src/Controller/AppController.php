<?php

/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */

namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\Log\Log;
use Fifa\LogicFifa;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{

    public $helpers = [
        'Less.Less', // required for parsing less files
        'BootstrapUI.Form',
        'BootstrapUI.Html',
        'BootstrapUI.Flash',
        'BootstrapUI.Paginator',
        'Fifah'
    ];
    public $Fifa = '';

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $this->loadComponent('Bootstrap.Flash');
        $this->loadComponent('Tools.AuthUser');
        $this->loadComponent('Search.Prg', ['actions' => ['index', 'lookup']]);

        $this->Fifa = new LogicFifa();

        $this->loadComponent('Auth', [
            'authenticate' => [
                'Form' => [
                    'finder' => 'auth',
                    'scope' => [
                        'Users.active' => 1
                    ]
                ]
            ],
            'authorize' => [
                'TinyAuth.Tiny' => [
                    'multiRole' => true
                ]
            ],
            'loginRedirect' => [
                'controller' => 'Home',
                'action' => 'index'
            ],
            'logoutRedirect' => [
                'controller' => 'Home',
                'action' => 'login'
            ],
            'loginAction' => [
                'controller' => 'Home',
                'action' => 'login'
            ]
        ]);
        ///print_r($this->AuthUser->roles());die();
        if ($this->AuthUser->roles()) {
            $menu = $this->Fifa->get_menu_tree(0, $this->AuthUser->roles());
            $validities = $this->Fifa->getValidities();
            $vigencia_fifa = $this->request->session()->read('cookie_vigencia_fifa');
        }
        $this->set(compact('menu', 'validities', 'vigencia_fifa'));
    }

    /**
     * Before render callback.
     *
     * @param \Cake\Event\Event $event The beforeRender event.
     * @return void
     */
    public function beforeRender(Event $event)
    {
        if (
            !array_key_exists('_serialize', $this->viewVars) &&
            in_array($this->response->type(), ['application/json', 'application/xml'])
        ) {
            $this->set('_serialize', true);
        }
        $this->viewBuilder()->theme('AdminTheme');

        $this->Auth->allow('login', 'logout');
    }
}
