<?php
namespace App\Controller;

use Cake\ORM\Behavior\TreeBehavior;
use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use Cake\Log\Log;


/**
* ItemsClassifications Controller
*
* @property \App\Model\Table\ItemsClassificationsTable $ItemsClassifications
*/
class ItemsClassificationsController extends AppController
{


  public function initialize() {
    parent::initialize();
    $this->loadModel('ItemsClassifications');
  }

  /**
  * Index method
  *
  * @return \Cake\Network\Response|null
  */
  public function index()
  {

    $cookie_vigencia_fifa = Router::getRequest()->session()->read('cookie_vigencia_fifa');

    $this->paginate = [
      'contain' => ['ItemsTypes', 'ParentItemsClassifications']
    ];

    $query = $this->ItemsClassifications
    // ->find('treeList')
    ->find('search', [
      'search' => $this->request->query,
      'order'=>'ItemsClassifications.name ASC']
      )
      ->contain(['ParentItemsClassifications'])
      ->where(['ItemsClassifications.validity_id' => $cookie_vigencia_fifa->id])
      ;

      $itemsClassifications = $this->paginate($query);

      // echo "<pre>";
      // print_r( (Array)$itemsClassifications );
      // echo "</pre>";
      // die();

      $this->set(compact('itemsClassifications'));
      $this->set('_serialize', ['itemsClassifications']);

    }

    /**
    * View method
    *
    * @param string|null $id Items Classification id.
    * @return \Cake\Network\Response|null
    * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
    */
    public function view($id = null)
    {
      $itemsClassification = $this->ItemsClassifications->get($id, [
        'contain' => ['ItemsTypes']
      ]);

      $this->set('itemsClassification', $itemsClassification);
      $this->set('_serialize', ['itemsClassification']);
    }

    /**
    * Add method
    *
    * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
    */
    public function add()
    {

      $cookie_vigencia_fifa = Router::getRequest()->session()->read('cookie_vigencia_fifa');

      $itemsClassification = $this->ItemsClassifications->newEntity();
      if ($this->request->is('post')) {

        // Validamos si es cuenta principal o subcuenta
        if (trim($this->request->data['parent_id']) != '') {
          // Obtenemos los datos de la cuenta Padre
          $parentItemsClassifications = TableRegistry::get('ItemsClassifications')
          ->find()
          ->where(
            [
              'id' => $this->request->data['parent_id']
            ]
          )
          ->first()
          ;

          $this->request->data['item_type_id']=$parentItemsClassifications->item_type_id;
        }

        $this->request->data['validity_id']=$cookie_vigencia_fifa->id;

        $itemsClassification = $this->ItemsClassifications->patchEntity($itemsClassification, $this->request->data);
        if ($this->ItemsClassifications->save($itemsClassification)) {
          $this->Flash->success(__('Información guardada'));

          return $this->redirect(['action' => 'index']);
        } else {
          $this->Flash->error(__('La información no se pudo guardar. Por favor, inténtelo de nuevo.'));
        }
      }

      $parentItemsClassifications = $this->ItemsClassifications->ParentItemsClassifications
      ->find('list', ['limit' => 200])
      ->where(['validity_id' => $cookie_vigencia_fifa->id])
      ;

      $itemsTypes = $this->ItemsClassifications->ItemsTypes->find('list', ['limit' => 200]);

      $this->set(compact('itemsClassification', 'itemsTypes', 'parentItemsClassifications'));
      $this->set('_serialize', ['itemsClassification']);
    }

    /**
    * Edit method
    *
    * @param string|null $id Items Classification id.
    * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
    * @throws \Cake\Network\Exception\NotFoundException When record not found.
    */
    public function edit($id = null)
    {

      $cookie_vigencia_fifa = Router::getRequest()->session()->read('cookie_vigencia_fifa');

      $itemsClassification = $this->ItemsClassifications->get($id, [
        'contain' => []
      ]);

      if ($this->request->is(['patch', 'post', 'put'])) {

        // Validamos si es cuenta principal o subcuenta
        if (trim($this->request->data['parent_id']) != '') {
          // Obtenemos los datos de la cuenta Padre
          $parentItemsClassifications = TableRegistry::get('ItemsClassifications')
          ->find()
          ->where([
            'id' => $this->request->data['parent_id']
          ]
          )
          ->first()
          ;

          $this->request->data['item_type_id']=$parentItemsClassifications->item_type_id;
        }

        $itemsClassification = $this->ItemsClassifications->patchEntity($itemsClassification, $this->request->data);

        if ($this->ItemsClassifications->save($itemsClassification)) {
          $this->Flash->success(__('Información guardada'));
          return $this->redirect(['action' => 'index']);
        } else {
          $this->Flash->error(__('La información no se pudo guardar. Por favor, inténtelo de nuevo.'));
        }
      }

      $parentItemsClassifications = $this->ItemsClassifications->ParentItemsClassifications
      ->find('list', ['limit' => 200])
      ->where(['validity_id' => $cookie_vigencia_fifa->id])
      ;

      $itemsTypes = $this->ItemsClassifications->ItemsTypes->find('list', ['limit' => 200]);

      $this->set(compact('itemsClassification', 'itemsTypes', 'parentItemsClassifications'));
      $this->set('_serialize', ['itemsClassification']);
    }

    /**
    * Delete method
    *
    * @param string|null $id Items Classification id.
    * @return \Cake\Network\Response|null Redirects to index.
    * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
    */
    public function delete($id = null)
    {
      $this->request->allowMethod(['post', 'delete']);
      $itemsClassification = $this->ItemsClassifications->get($id);
      if ($this->ItemsClassifications->delete($itemsClassification)) {
        $this->Flash->success(__('Se ha eliminado.'));
      } else {
        $this->Flash->error(__('La información no se pudo eliminar. Por favor, inténtelo de nuevo.'));
      }

      return $this->redirect(['action' => 'index']);
    }
  }
