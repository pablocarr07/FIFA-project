<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use Cake\Log\Log;

/**
* AsiVasuGasto Controller
*
* @property \App\Model\Table\AsiVasuGastoTable $AsiVasuGasto
*/
class AsiVaSuGastoController extends AppController {

  protected $cookie_vigencia_fifa;
  protected $user_group;

  public function initialize() {
    parent::initialize();

    $this->cookie_vigencia_fifa = Router::getRequest()->session()->read('cookie_vigencia_fifa');

    $this->user_group = TableRegistry::get('GroupsUsers')->find()
    ->where(['user_id' => $this->AuthUser->user('id')])
    ->where(['validity_id' => $this->cookie_vigencia_fifa->id ])
    ->where(['deleted is null'])
    ->first()
    ;

    $this->usergroup_id = 0;
    if ($this->user_group) {
      $this->usergroup_id = $this->user_group->group_id;
    }

    $this->loadComponent('RequestHandler');
    $this->loadModel('Groups');
    $this->loadModel('Users');
  }

  /**
  * Index method
  *
  * @return \Cake\Network\Response|null
  */
  public function index() {

    $rolesvertodo=[2,3,7,8,4,6];

    $roles = $this->AuthUser->roles();

    $rolvertodo=FALSE;
    $documento_soporte=[];
    $dependencies=[];
    $group=false;
    $subgroup=false;

    foreach($rolesvertodo as $rol){
      if (in_array($rol, $roles)) {
        $rolvertodo=TRUE;
        break;
      }
    }

    foreach($this->Fifa->tipo_documento_soporte as $key=>$documento){
      $documento_soporte[$key]=$key;
    }

    if($rolvertodo){
      $dependencies = $this->Groups
      ->find('list', ['limit' => 200])
      ->where(
        [
          'parent_id IS NULL',
          'validity_id' => $this->cookie_vigencia_fifa->id
        ]
      )
      ;
      $group=[''=>''];
    }else{

      $esdepencia = $this->request->session()->read('Auth.User.group.parent_id');
      $group_name = $this->request->session()->read('Auth.User.group.name');

      if ($this->user_group) {
        $group_id = $this->user_group->id;
      }

      if(empty($esdepencia)){
        $dependencies =[$group_id=>$group_name];
        $group=[''=>''];
      }else{

        if ($this->user_group) {
          $query = $this->Groups->find('all')
          ->where(['id'=>$group_id])
          ->contain(['ChildGroups']);
        } else {
          $query = $this->Groups->find('all')
          // ->where(['id'=>$group_id])
          ->contain(['ChildGroups']);
        }

        if(!empty($query->first()->child_groups)){
          $group=[''=>''];
          $group[$query->first()->id]=$query->first()->name;
        }else{
          $subgroup=[$query->first()->id=>$query->first()->name];
        }

      }
    }

    $this->set(compact('documento_soporte', 'dependencies','group','subgroup'));
  }

/*
  public function general($id = null) {
    $asiVasuGastoDetallado = $this->Fifa->asiVaSuGastoGeneral($this->usergroup_id);

    foreach ($asiVasuGastoDetallado as $key => $d) {
      print_r($key . '=>totalPagado ->' . $d['totalPagado'] . '* totalRp-> ' . $d['totalRp'] . '<br>');
    }

    echo'<pre>general';
    die();

    $this->set('asiVasuGastoDetallado', $asiVasuGastoDetallado);
    $this->set('_serialize', ['asiVasuGastoDetallado']);
  }

  public function detallado($id = null) {

    //$documentoSporte='Honorarios';
    $documentoSporte = ['Viáticos', 'Honorarios', 'Proveedores'];
    $asiVasuGastoDetallado = $this->Fifa->asiVaSuGastoDetallado($this->usergroup_id, $documentoSporte);

    foreach ($asiVasuGastoDetallado as $key => $d) {
      print_r($key . '=>tercero ->' . $d['tercero'] . '* fecha-> ' . $d['fecha'] . '* valorRp-> ' . $d['valorRp'] . '* valorPagado-> ' . $d['valorPagado'] . '* concepto-> ' . $d['concepto'] . '* documentoSoporte-> ' . $d['documentoSoporte'] . '<br>');
    }

    $this->set('asiVasuGastoDetallado', $asiVasuGastoDetallado);
    $this->set('_serialize', ['asiVasuGastoDetallado']);
  }

*/

  public function getGroups($id = '') {

    $this->RequestHandler->renderAs($this, 'json');
    $this->response->type('application/json');
    $groups=[];

    $groupsQuery = $this->Groups->find('all')->where(['parent_id IN' => $this->request->data['id']]);
    $groupsQuery = $this->Groups->find('all')->where(['parent_id' => $this->request->data['id']]);

    foreach($groupsQuery as $group){//print_r($group);die();
      $groups[]=['id'=>$group->id,'name'=>$group->name];
    }

    $this->set('groups', $groups);
    $this->set('_serialize', ['groups']);

  }

  public function getSubGroups($id = '') {
    $this->RequestHandler->renderAs($this, 'json');
    $this->response->type('application/json');

    $groups=[];
    $dependencies = $this->Groups->find('all')->where(['parent_id'=>$this->request->data['id']]);

    foreach ($dependencies as $data){
      $groups[]=['id'=>$data->id,'name'=>$data->name];
    }

    $this->set('groups', $groups);
    $this->set('_serialize', ['groups']);
  }

  public function getReports(){

    $output=[];

    //$this->RequestHandler->renderAs($this, 'json');
    //$this->response->type('application/json');

    if($this->request->data['typeReport']=='general'){
      $output=$this->asiVaSuGastoGeneral();
    }elseif($this->request->data['typeReport']=='detallado'){
      $output=$this->asiVaSuGastoDetallado();
    }

    $this->set('output', $output);
    $this->set('_serialize', ['output']);
  }

  private function asiVaSuGastoGeneral(){

    $group = '';
    if(isset($this->request->data['subgroup']) AND !empty($this->request->data['subgroup'])){
      $group=$this->request->data['subgroup'];
    }elseif(isset($this->request->data['group']) AND !empty($this->request->data['group'])){
      $group=$this->request->data['group'];
    }elseif(isset($this->request->data['dependency']) AND !empty($this->request->data['dependency'])){
      $group=$this->request->data['dependency'];
    }

    Log::error('asiVaSuGastoGeneral: group');
    Log::error($group);

    return $this->Fifa->asiVaSuGastoGeneral($group,$this->request->data['concepts']);
  }

  private function asiVaSuGastoDetallado(){

    $group = '';

    if(isset($this->request->data['subgroup']) AND !empty($this->request->data['subgroup'])){
      $group=$this->request->data['subgroup'];
    }elseif(isset($this->request->data['group']) AND !empty($this->request->data['group'])){
      $group=$this->request->data['group'];
    }elseif(isset($this->request->data['dependency']) AND !empty($this->request->data['dependency'])){
      $group=$this->request->data['dependency'];
    }

    return $this->Fifa->asiVaSuGastoDetallado($group,$this->request->data['concepts']);
  }

  /**
  * Add method
  *
  * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
  */
  public function add() {

    $asiVasuGasto = $this->AsiVasuGasto->newEntity();
    if ($this->request->is('post')) {
      $asiVasuGasto = $this->AsiVasuGasto->patchEntity($asiVasuGasto, $this->request->data);
      if ($this->AsiVasuGasto->save($asiVasuGasto)) {
        $this->Flash->success(__('The asi vasu gasto has been saved.'));
        return $this->redirect(['action' => 'index']);
      } else {
        $this->Flash->error(__('The asi vasu gasto could not be saved. Please, try again.'));
      }
    }
    $this->set(compact('asiVasuGasto'));
    $this->set('_serialize', ['asiVasuGasto']);
  }

  /**
  * Edit method
  *
  * @param string|null $id Asi Vasu Gasto id.
  * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
  * @throws \Cake\Network\Exception\NotFoundException When record not found.
  */
  public function edit($id = null) {
    $asiVasuGasto = $this->AsiVasuGasto->get($id, [
      'contain' => []
    ]);
    if ($this->request->is(['patch', 'post', 'put'])) {
      $asiVasuGasto = $this->AsiVasuGasto->patchEntity($asiVasuGasto, $this->request->data);
      if ($this->AsiVasuGasto->save($asiVasuGasto)) {
        $this->Flash->success(__('The asi vasu gasto has been saved.'));
        return $this->redirect(['action' => 'index']);
      } else {
        $this->Flash->error(__('The asi vasu gasto could not be saved. Please, try again.'));
      }
    }
    $this->set(compact('asiVasuGasto'));
    $this->set('_serialize', ['asiVasuGasto']);
  }

  /**
  * Delete method
  *
  * @param string|null $id Asi Vasu Gasto id.
  * @return \Cake\Network\Response|null Redirects to index.
  * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
  */
  public function delete($id = null) {
    $this->request->allowMethod(['post', 'delete']);
    $asiVasuGasto = $this->AsiVasuGasto->get($id);
    if ($this->AsiVasuGasto->delete($asiVasuGasto)) {
      $this->Flash->success(__('The asi vasu gasto has been deleted.'));
    } else {
      $this->Flash->error(__('The asi vasu gasto could not be deleted. Please, try again.'));
    }
    return $this->redirect(['action' => 'index']);
  }

}
