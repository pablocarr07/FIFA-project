<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Routing\Router;

/**
* Groups Controller
*
* @property \App\Model\Table\GroupsTable $Groups
*/
class GroupsController extends AppController
{

  /**
  * Index method
  *
  * @return \Cake\Network\Response|null
  */
  public function index()
  {

    $cookie_vigencia_fifa = Router::getRequest()->session()->read('cookie_vigencia_fifa');

    $this->paginate = [
      'contain' => ['ParentGroups']
    ];

    $query = $this->Groups->find(
      'search', [
        'search' => $this->request->query
      ]
      )
      ->where([
        'Groups.parent_id IS NOT NULL',
        'Groups.validity_id' => $cookie_vigencia_fifa->id
      ])
      ->contain(['ParentGroups'])
      ;

      $groups = $this->paginate($query);

      $this->set(compact('groups'));
      $this->set('_serialize', ['groups']);
    }

    /**
    * View method
    *
    * @param string|null $id Group id.
    * @return \Cake\Network\Response|null
    * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
    */
    public function view($id = null)
    {
      $group = $this->Groups->get($id, [
        'contain' => ['ParentGroups', 'ChildGroups', 'Users']
      ]);
      $dependency='';
      if($group->parent_id){
        $query=$this->Groups->find('all')->where(['id'=>$group->parent_id])->first();

        if(!$query->parent_id){
          $dependency = $query->name;
        }else{
          $dependency = $query->name;
        }

      }else{
        $dependency=$group->name;
      }

      $this->set(compact('group','dependency'));
      $this->set('_serialize', ['group']);
    }

    /**
    * Add method
    *
    * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
    */
    public function add()
    {

      $cookie_vigencia_fifa = Router::getRequest()->session()->read('cookie_vigencia_fifa');

      $group = $this->Groups->newEntity();
      if ($this->request->is('post')) {

        $this->request->data['validity_id'] = $cookie_vigencia_fifa->id;

        if(empty($this->request->data['parent_id'])){
          $this->request->data['parent_id'] = $this->request->data['dependency_id'];
        }
        $group = $this->Groups->patchEntity($group, $this->request->data);
        if ($this->Groups->save($group)) {
          $this->Flash->success(__('El grupo ha sido guardado.'));
          return $this->redirect(['action' => 'index']);
        } else {
          $this->Flash->error(__('El grupo no pudo ser guardado. Por favor, inténtelo de nuevo.'));
        }
      }

      $dependency_id='';
      if($group->parent_id){
        $query=$this->Groups->find('all')->where(['id'=>$group->parent_id])->first();

        if(!$query->parent_id){
          $dependency_id = $query->id;
        }else{
          $dependency_id = $query->parent_id;
        }

      }else{
        $dependency_id=$group->id;
      }

      $dependencies = $this->Groups
      ->find('list', ['limit' => 200])
      ->where([
        'parent_id IS NULL',
        'validity_id' => $cookie_vigencia_fifa->id
      ])
      ;

      // $parentGroups = [];//$this->Groups->ParentGroups->find('treeList', ['limit' => 200])->where(['parent_id IS NOT NULL']);
      $parentGroups = $this->Groups->ParentGroups
      ->find('list', ['limit' => 200])
      ->where([
        'parent_id'=>$dependency_id,
        'validity_id' => $cookie_vigencia_fifa->id
      ])
      ;

      $this->set(compact('group', 'dependencies', 'parentGroups', 'dependency_id'));
      $this->set('_serialize', ['group']);
    }

    /**
    * Edit method
    *
    * @param string|null $id Group id.
    * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
    * @throws \Cake\Network\Exception\NotFoundException When record not found.
    */
    public function edit($id = null)
    {

      $cookie_vigencia_fifa = Router::getRequest()->session()->read('cookie_vigencia_fifa');

      $group = $this->Groups->get($id, [
        'contain' => []
      ]);
      if ($this->request->is(['patch', 'post', 'put'])) {
        if(empty($this->request->data['parent_id'])){
          $this->request->data['parent_id'] = $this->request->data['dependency_id'];
        }
        $group = $this->Groups->patchEntity($group, $this->request->data);
        if ($this->Groups->save($group)) {
          $this->Flash->success(__('El grupo ha sido guardado.'));
          return $this->redirect(['action' => 'index']);
        } else {
          $this->Flash->error(__('El grupo no pudo ser guardado. Por favor, inténtelo de nuevo.'));
        }
      }


      $dependency_id='';
      if($group->parent_id){
        $query=$this->Groups->find('all')->where(['id'=>$group->parent_id])->first();

        if(!$query->parent_id){
          $dependency_id = $query->id;
        }else{
          $dependency_id = $query->parent_id;
        }

      }else{
        $dependency_id=$group->id;
      }

      $dependencies = $this->Groups
      ->find('list', ['limit' => 200])
      ->where([
        'parent_id IS NULL',
        'validity_id' => $cookie_vigencia_fifa->id
      ])
      ;

      $parentGroups = $this->Groups->ParentGroups
      ->find('list', ['limit' => 200])
      ->where([
        'parent_id'=>$dependency_id,
        'validity_id' => $cookie_vigencia_fifa->id
      ])
      ;

      $this->set(compact('group', 'dependencies', 'parentGroups','dependency_id'));
      $this->set('_serialize', ['group']);
    }

    /**
    * Delete method
    *
    * @param string|null $id Group id.
    * @return \Cake\Network\Response|null Redirects to index.
    * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
    */
    public function delete($id = null)
    {
      $this->request->allowMethod(['post', 'delete']);
      $group = $this->Groups->get($id);
      if ($this->Groups->delete($group)) {
        $this->Flash->success(__('El grupo ha sido eliminado.'));
      } else {
        $this->Flash->error(__('No se pudo eliminar el grupo. Por favor, inténtelo de nuevo.'));
      }
      return $this->redirect(['action' => 'index']);
    }

    public function getGroups(){
      $this->RequestHandler->renderAs($this, 'json');
      $groups = $this->Groups->find('all')->where(['parent_id'=>$this->request->data['id']]);
      $this->set('groups', $groups);
      $this->set('_serialize', ['groups']);
    }
  }
