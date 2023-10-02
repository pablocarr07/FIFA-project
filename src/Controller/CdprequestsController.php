<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use Cake\I18n\Time;
use Cake\Log\Log;
use CsvView\View\CsvView;
use Cake\Network\Email\Email;
use App\Controller\CakeSession;

/**
 * Cdprequests Controller
 *
 * @property \App\Model\Table\CdprequestsTable $Cdprequests
 */
class CdprequestsController extends AppController
{

  public function initialize()
  {
    parent::initialize();
    $this->loadModel('ItemsTypes');
    $this->loadModel('Items');
    $this->loadModel('ItemsClassifications');
    $this->loadModel('Resources');
    $this->loadModel('CdprequestsItems');
    $this->loadModel('Users');
  }

  /**
   * Index method
   *
   * @return \Cake\Network\Response|null
   */
  public function index()
  {
    $this->loadModel('Users');
    $preloader = $this->preloader();

    $cdprequests = $this->paginate($preloader['query']);
    $state_id = $preloader['state_id'];

    $this->set(compact(['cdprequests', 'state_id']));
    $this->set('_serialize', ['cdprequests', 'state_id']);
  }

  /**
   * View method
   *
   * @param string|null $id Cdprequest id.
   * @return \Cake\Network\Response|null
   * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
   */
  public function view()
  {

    $cookie_vigencia_fifa = Router::getRequest()->session()->read('cookie_vigencia_fifa');

    $preloader = $this->preloader();
    $query = $preloader['query']->where(['Cdprequests.id' => $preloader['id']]);

    if ($query->count() == 0) {
      $this->Flash->error(__('No se encontro la Solicitud de CDP ' . $preloader['id']));
      return $this->redirect(['controller' => 'Cdprequestsdashboard', 'action' => 'index']);
    }

    $cdprequest = $query->first();

    $resources = $this->Resources
      ->find('list', ['limit' => 200])
      ->where(
        [
          'validity_id' => $cookie_vigencia_fifa->id
        ]
      );

    $itemsdata = $this->Fifa->obtenerDatosCdpRequestsItems($cdprequest->id);
    $applicants = $this->Cdprequests->Applicants->find('list', ['limit' => 1000]);
    $movementTypes = $this->Cdprequests->Movement_types->find('list', ['limit' => 200]);
    $itemstypes = $this->ItemsTypes->find('list', ['limit' => 200]);
    $items = $this->Cdprequests->Items->find('list', ['limit' => 200]);
    $states = $this->Cdprequests->States->find('list', ['limit' => 200]);

    $this->set(compact('cdprequest', 'applicants', 'movementTypes', 'items', 'itemstypes', 'resources', 'itemsdata', 'states'));
    $this->set('_serialize', ['cdprequest']);
  }

  /**
   * Add method
   *
   * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
   */
  public function add()
  {

    $cookie_vigencia_fifa = Router::getRequest()->session()->read('cookie_vigencia_fifa');

    $cdprequest = $this->Cdprequests->newEntity();

    if ($this->request->is('post')) {

      $user_group = TableRegistry::get('GroupsUsers')->find()
        ->where(['user_id' => $this->Auth->user('id')])
        ->where(['validity_id' => $cookie_vigencia_fifa->id])
        ->where(['deleted is null'])
        ->first();

      $this->usergroup_id = 0;
      if ($user_group) {
        $this->usergroup_id = $user_group->group_id;
      }

      $cdprequest = $this->Cdprequests->patchEntity($cdprequest, $this->request->data);

      $applicantinfo = $this->applicantinfo($this->request->data['applicant_id']);

      $this->request->data['created_by'] = $this->Auth->user('id');
      $this->request->data['group_id'] = $this->usergroup_id; 

      $validations = $this->validations($cdprequest->itemsdata);

      // $validations['success'] = TRUE; //Para probar cuando es true
      if ($validations['success']) {


        //validación de estado....
        if ($this->request->data['state'] == 1) {
          $this->request->data['state'] = 11; //Cuando es borrador
        } else {
          $this->request->data['state'] = 3;
        }

        foreach ($this->request->data['itemsdata'] as $d) {
          $d = json_decode($d);
          $items = $this->Cdprequests->Items->get($d->items->id);
          $items->value = $d->value;
          $items->resource_id = $d->resources->id;
          $items->created = \Cake\I18n\Time::now();
          $items->document = '';
          $items = $items->toArray();
          $this->request->data['items'][] = [
            'id' => $d->items->id,
            '_joinData' => $items
          ];
        }

        $cdprequest['cdp'] = 0;
        $cdprequest['soprtecdp'] = '';
        $cdprequest['value_letter'] = '';
        $cdprequest['value_number'] = 0;

        $cdprequest = $this->Cdprequests->patchEntity($cdprequest, $this->request->data);

  if ($this->Cdprequests->save($cdprequest)) {
          $nuevo = $cdprequest->id;
          $usuarioes =  $this->Auth->user('id');
          $correofifa =  TableRegistry::get('users')
          ->find()
          ->select(['email'])
          ->where(['id' => $usuarioes])
          ->first();
          $correoes = $correofifa["email"];          
          Email::configTransport('mail1', [
            'host' => 'smtp.gmail.com', 
            'port' => 587,
            'tls' => true, 
            'username' => 'soporte.tecnologia@serviciodeempleo.gov.co', 
            'password' => 'yazmgrusghjjmxae',
            'className' => 'Smtp', 
            'context' => [
              'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
              ]
            ]
        ]); 
        $correo = new Email(); 
        $correo
          ->transport('mail1') 
          ->template('nuevocdp')
          ->emailFormat('html') 
          ->to($correoes) 
          ->from('soporte.tecnologia@serviciodeempleo.gov.co')
          ->subject('Nueva Petición CDP con el Consecutivo '.$nuevo)
          ->set('nuevo', $nuevo);
        if($correo->send())
        {
          //echo "Correo enviado";
        }else{
         
	}    
          $this->Flash->success(__('La Solicitud de CDP ' . $cdprequest->id . ' se guardo.'));
          return $this->redirect(['controller' => 'cdprequestsdashboard', 'action' => 'index']);
        } else {
          $this->Flash->error(__('The cdprequest could not be saved. Please, try again.'));
        }
      } else {
        $this->Flash->error(__('Error al validar Recursos Seleccionados, Inténtalo de nuevo.'));
      }
    }

    $resources = $this->Resources
      ->find('list', ['limit' => 200])
      ->where(
        [
          'validity_id' => $cookie_vigencia_fifa->id
        ]
      );

    $user_group = TableRegistry::get('GroupsUsers')->find()
      ->where(['user_id' => $this->request->session()->read('Auth.User.id')])
      ->where(['validity_id' => $cookie_vigencia_fifa->id])
      ->where(['deleted is null'])
      ->first();

    $usergroup_id = 0;
    if ($user_group) {
      $usergroup_id = $user_group->group_id;
    }

    //Obtener grupo de usuario
    $immediate_boss = $this->Fifa->getImmediateBoss($usergroup_id);
    $itemsdata = $cdprequest->itemsdata;
    $applicants = $this->Cdprequests->Applicants->find('list')->where(['id' => $immediate_boss]);
    $movementTypes = $this->Cdprequests->Movement_types->find('list');
    $itemstypes = $this->ItemsTypes->find('list');
    $items = $this->Cdprequests->Items->find('list');

    $this->set(compact('cdprequest', 'applicants', 'movementTypes', 'items', 'itemstypes', 'resources', 'itemsdata'));
    $this->set('_serialize', ['cdprequest']);
  }

  /**
   * Edit method
   *
   * @param string|null $id Cdprequest id.
   * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
   * @throws \Cake\Network\Exception\NotFoundException When record not found.
   */
  public function edit()
  {

    $cookie_vigencia_fifa = Router::getRequest()->session()->read('cookie_vigencia_fifa');

    $preloader = $this->preloader();
    $query = $preloader['query']->where(['Cdprequests.id' => $preloader['id']]);

    if ($query->count() == 0) {
      $this->Flash->error(__('No se Puede editar la Solicitud de CDP'));
      return $this->redirect(['controller' => 'Cdprequestsdashboard', 'action' => 'index']);
    }

    $cdprequest = $query->first();

    if ($this->request->is(['patch', 'post', 'put'])) {
      $cdprequest = $this->Cdprequests->patchEntity($cdprequest, $this->request->data);
      $cdprequest->created_by = $this->Auth->user('id');
      $cdprequest->group_id = $this->Auth->user('group_id');

      $validations = $this->validations($cdprequest->itemsdata);

      if ($cdprequest->commentary) {
        $cdprequest->commentary = $this->request->commentary;
      }

      if ($validations['success']) {

        //validación de estado....
        if ($this->request->data['state'] == 1) {
          $this->request->data['state'] = 0;
        } else {
          $this->request->data['state'] = 3;
        }

        foreach ($this->request->data['itemsdata'] as $d) {
          $d = json_decode($d);
          $items = $this->Cdprequests->Items->get($d->items->id);
          $items->value = $d->value;
          $items->resource_id = $d->resources->id;
          $items->created = \Cake\I18n\Time::now();
          $items = $items->toArray();
          $this->request->data['items'][] = [
            'id' => $d->items->id,
            '_joinData' => $items
          ];
        }

        $cdprequest = $this->Cdprequests->patchEntity($cdprequest, $this->request->data);

        if ($this->Cdprequests->save($cdprequest)) {
          $this->Flash->success(__('La Solicitud de CDP ' . $cdprequest->id . ' se guardo.'));
          return $this->redirect(['action' => 'index', '?' => ['state-id' => $preloader['state_id']]]);
        } else {
          $this->Flash->error(__('The cdprequest could not be saved. Please, try again.'));
        }
      } else {
        $this->Flash->error(__('Error al validar Recursos Seleccionados, Inténtalo de nuevo.'));
      }
    }

    if ($cdprequest->itemsdata) {
      $itemsdata = $cdprequest->itemsdata;
    } else {
      $itemsdata = $this->Fifa->obtenerDatosCdpRequestsItems($cdprequest->id);
    }

    $resources = $this->Resources
      ->find('list', ['limit' => 200])
      ->where(
        [
          'validity_id' => $cookie_vigencia_fifa->id
        ]
      );

    $user_group = TableRegistry::get('GroupsUsers')->find()
      ->where(['user_id' => $this->request->session()->read('Auth.User.id')])
      ->where(['validity_id' => $cookie_vigencia_fifa->id])
      ->where(['deleted is null'])
      ->first();

    $usergroup_id = 0;
    if ($user_group) {
      $usergroup_id = $user_group->group_id;
    }

    //Obtener grupo de usuario
    $immediate_boss = $this->Fifa->getImmediateBoss($usergroup_id);

    $applicants = $this->Cdprequests->Applicants->find('list', ['limit' => 1000]);
    $movementTypes = $this->Cdprequests->Movement_types->find('list', ['limit' => 200]);
    $itemstypes = $this->ItemsTypes->find('list', ['limit' => 200]);
    $items = $this->Cdprequests->Items->find('list', ['limit' => 200]);

    $this->set(compact('cdprequest', 'applicants', 'movementTypes', 'items', 'itemstypes', 'resources', 'itemsdata'));
    $this->set('_serialize', ['cdprequest']);
  }

  /**
   * Delete method
   *
   * @param string|null $id Cdprequest id.
   * @return \Cake\Network\Response|null Redirects to index.
   * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
   */
  public function delete($id = null)
  {

    $this->request->allowMethod(['post', 'delete']);

    $preloader = $this->preloader();
    $query = $preloader['query']->where(['created_by' => $this->Auth->user('id'), 'Cdprequests.id' => $preloader['id'], 'Cdprequests.state IN' => [0, 2]]);

    if ($query->count() == 0) {
      $this->Flash->error(__('No se Puede Eliminar la Solicitud de CDP'));
      return $this->redirect(['action' => 'index', '?' => ['state-id' => $preloader['state_id']]]);
    }

    $cdprequest = $query->first();

    if ($this->Cdprequests->delete($cdprequest)) {
      $this->Flash->success(__('The cdprequest has been deleted.'));
    } else {
      $this->Flash->error(__('The cdprequest could not be deleted. Please, try again.'));
    }

    return $this->redirect(['action' => 'index', '?' => ['state-id' => $preloader['state_id']]]);
  }

  public function itemClassification($item_type_id)
  {

    $cookie_vigencia_fifa = Router::getRequest()->session()->read('cookie_vigencia_fifa');

    $output = $this->ItemsClassifications
      ->find('list')
      ->where(
        [
          'item_type_id' => $item_type_id,
          'validity_id' => $cookie_vigencia_fifa->id
        ]
      );

    $this->set('output', $output);
    $this->set('_serialize', ['output']);
  }

  public function items($item_type_id)
  {
    $output = $this->Cdprequests->Items->find('all')->select(['id', 'name', 'item'])->where(['item_classification_id' => $item_type_id]);
    $this->set('output', $output);
    $this->set('_serialize', ['output']);
  }

  private function validations($data, $cdprequest_id = FALSE)
  {

    $output = ['success' => FALSE];

    if (is_array($data)) {

      foreach ($data as $d) {
        $itemsdata = json_decode($d);
        $item = $this->Items->get($itemsdata->items->id);
        $resource = $this->Resources->get($itemsdata->resources->id);
        if (is_numeric($resource->id) and is_numeric($item->id) and is_numeric($itemsdata->value)) {
          $output['items'][] = array('resource_id' => $resource->id, 'item_id' => $item->id, 'value' => $itemsdata->value, 'cdprequest_id' => $cdprequest_id);
          $output['success'] = TRUE;
        } else {
          $output['success'] = FALSE;
          break;
        }
      }
    }

    return $output;
  }

  private function preloader()
  {

    $cdprequests = $this->Fifa->Cdprequests();
    $state_id = $this->request->query('state-id');
    $query = [];

    if ($state_id == '-1') { // Reporte total de CDPs
      $query = $cdprequests->Cdprequests_total();
    } elseif ($state_id == '0') {
      $query = $cdprequests->Cdprequests_borrador();
    } elseif ($state_id == '1') {
      $query = $cdprequests->Cdprequests_rechazada();
    } elseif ($state_id == '2') {
      $query = $cdprequests->Cdprequests_modificacion();
    } else {
      $query = $cdprequests->Cdprequests_getionada_por_mi();
    }

    return ['query' => $query, 'state_id' => $state_id, 'id' => $this->request->query('id')];
  }

  private function applicantinfo($id)
  {

    $cookie_vigencia_fifa = Router::getRequest()->session()->read('cookie_vigencia_fifa');

    $user = TableRegistry::get('users')
      ->find()
      ->select(
        [
          'users.id',
          'groups_users.group_id'
        ]
      )
      ->join([
        'table' => 'groups_users',
        'type' => 'INNER',
        'conditions' => 'users.id=groups_users.user_id',
      ])
      ->where(['users.id' => $id])
      ->where(['groups_users.validity_id' => $cookie_vigencia_fifa->id])
      ->where(['users.deleted is null'])
      ->first();

    return $user;
  }
  
}
