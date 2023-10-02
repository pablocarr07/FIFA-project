<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use Cake\Log\Log;

/**
* Cdpsxcomprometer Controller
*
* @property \App\Model\Table\CdpsxcomprometerTable $Cdpsxcomprometer
*/
class CdpsxcomprometerController extends AppController {


  public function initialize() {
    parent::initialize();
  }

  /**
  * Index method
  *
  * @return \Cake\Network\Response|null
  */
  public function index() {

    $cookie_vigencia_fifa = Router::getRequest()->session()->read('cookie_vigencia_fifa');

    $user_group = TableRegistry::get('GroupsUsers')->find()
    ->where(['user_id' => $this->AuthUser->user('id')])
    ->where(['validity_id' => $cookie_vigencia_fifa->id ])
    ->where(['deleted is null'])
    ->first()
    ;

    $usergroup_id = 0;
    if($user_group){
      $usergroup_id = $user_group->group_id;
    }

    $query=$this->Fifa->cdpsxComprometer($usergroup_id);

    $cdpsxcomprometer = $this->paginate($query);
    $this->set(compact('cdpsxcomprometer'));
    $this->set('_serialize', ['cdpsxcomprometer']);
  }

  /**
  * View method
  *
  * @param string|null $id Cdpsxcomprometer id.
  * @return \Cake\Network\Response|null
  * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
  */
  public function view($id = null) {
    $cdpxcomprometer = $this->Cdpsxcomprometer->get($id, [
      'contain' => []
    ]);

    $this->set('cdpxcomprometer', $cdpxcomprometer);
    $this->set('_serialize', ['cdpxcomprometer']);
  }

  /**
  * Add method
  *
  * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
  */
  public function add() {
    $cdpxcomprometer = $this->Cdpsxcomprometer->newEntity();
    if ($this->request->is('post')) {
      $cdpxcomprometer = $this->Cdpsxcomprometer->patchEntity($cdpxcomprometer, $this->request->data);
      if ($this->Cdpsxcomprometer->save($cdpxcomprometer)) {
        $this->Flash->success(__('The cdpxcomprometer has been saved.'));
        return $this->redirect(['action' => 'index']);
      } else {
        $this->Flash->error(__('The cdpxcomprometer could not be saved. Please, try again.'));
      }
    }
    $this->set(compact('cdpxcomprometer'));
    $this->set('_serialize', ['cdpxcomprometer']);
  }

  /**
  * Edit method
  *
  * @param string|null $id Cdpsxcomprometer id.
  * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
  * @throws \Cake\Network\Exception\NotFoundException When record not found.
  */
  public function edit($id = null) {
    $cdpxcomprometer = $this->Cdpsxcomprometer->get($id, [
      'contain' => []
    ]);
    if ($this->request->is(['patch', 'post', 'put'])) {
      $cdpxcomprometer = $this->Cdpsxcomprometer->patchEntity($cdpxcomprometer, $this->request->data);
      if ($this->Cdpsxcomprometer->save($cdpxcomprometer)) {
        $this->Flash->success(__('The cdpxcomprometer has been saved.'));
        return $this->redirect(['action' => 'index']);
      } else {
        $this->Flash->error(__('The cdpxcomprometer could not be saved. Please, try again.'));
      }
    }
    $this->set(compact('cdpxcomprometer'));
    $this->set('_serialize', ['cdpxcomprometer']);
  }

  /**
  * Delete method
  *
  * @param string|null $id Cdpsxcomprometer id.
  * @return \Cake\Network\Response|null Redirects to index.
  * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
  */
  public function delete($id = null) {
    $this->request->allowMethod(['post', 'delete']);
    $cdpxcomprometer = $this->Cdpsxcomprometer->get($id);
    if ($this->Cdpsxcomprometer->delete($cdpxcomprometer)) {
      $this->Flash->success(__('The cdpxcomprometer has been deleted.'));
    } else {
      $this->Flash->error(__('The cdpxcomprometer could not be deleted. Please, try again.'));
    }
    return $this->redirect(['action' => 'index']);
  }

}
