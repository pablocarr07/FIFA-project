<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Menus Controller
 *
 * @property \App\Model\Table\MenusTable $Menus
 */
class MenusController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['ParentMenus']
        ];
        $menus = $this->paginate($this->Menus);

        $this->set(compact('menus'));
        $this->set('_serialize', ['menus']);
    }

    /**
     * View method
     *
     * @param string|null $id Menu id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $menu = $this->Menus->get($id, [
            'contain' => ['ParentMenus', 'Roles', 'ChildMenus']
        ]);

        $this->set('menu', $menu);
        $this->set('_serialize', ['menu']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $menus = $this->Menus->newEntity();
        if ($this->request->is('post')) {
            $menus = $this->Menus->patchEntity($menus, $this->request->data);
            if ($this->Menus->save($menus)) {
                $this->Flash->success(__('The menu has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The menu could not be saved. Please, try again.'));
            }
        }
        $parentMenus = $this->Menus->ParentMenus->find('list', ['limit' => 200]);
        $roles = $this->Menus->Roles->find('list', ['limit' => 200]);
        $this->set(compact('menus', 'parentMenus', 'roles'));
        $this->set('_serialize', ['menus']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Menu id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $menus = $this->Menus->get($id, [
            'contain' => ['Roles']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $menus = $this->Menus->patchEntity($menus, $this->request->data);
            if ($this->Menus->save($menus)) {
                $this->Flash->success(__('The menu has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The menu could not be saved. Please, try again.'));
            }
        }
        $parentMenus = $this->Menus->ParentMenus->find('list', ['limit' => 200]);
        $roles = $this->Menus->Roles->find('list', ['limit' => 200]);
        $this->set(compact('menus', 'parentMenus', 'roles'));
        $this->set('_serialize', ['menus']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Menu id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $menu = $this->Menus->get($id);
        if ($this->Menus->delete($menu)) {
            $this->Flash->success(__('The menu has been deleted.'));
        } else {
            $this->Flash->error(__('The menu could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
