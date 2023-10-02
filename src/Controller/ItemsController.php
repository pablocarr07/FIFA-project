<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use Cake\Log\Log;

/**
* Items Controller
*
* @property \App\Model\Table\ItemsTable $Items
*/
class ItemsController extends AppController
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
      'contain' => ['ItemsClassifications']
    ];

    $query = $this->Items
    ->find('search', ['search' => $this->request->query])
    ->where(
      [
        'Items.validity_id' => $cookie_vigencia_fifa->id
      ]
      )
      ;

      $items = $this->paginate($query);

      $this->set(compact('items'));
      $this->set('_serialize', ['items']);
    }

    /**
    * View method
    *
    * @param string|null $id Item id.
    * @return \Cake\Network\Response|null
    * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
    */
    public function view($id = null)
    {
      $item = $this->Items->get($id, [
        'contain' => ['ItemsClassifications']
      ]);

      $this->set('item', $item);
      $this->set('_serialize', ['item']);
    }

    /**
    * Add method
    *
    * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
    */
    public function add()
    {

      $cookie_vigencia_fifa = Router::getRequest()->session()->read('cookie_vigencia_fifa');

      $item = $this->Items->newEntity();
      if ($this->request->is('post')) {

        $this->request->data['validity_id']=$cookie_vigencia_fifa->id;

        $item = $this->Items->patchEntity($item, $this->request->data);

        if ($this->Items->save($item)) {
          $this->Flash->success(__('Información guardada'));
          return $this->redirect(['action' => 'index']);
        } else {
          $this->Flash->error(__('La información no se pudo guardar. Por favor, inténtelo de nuevo.'));
        }

      }

      $itemsClassifications = $this->Items->ItemsClassifications
      ->find('list', ['limit' => 200])
      ->where(
        [
          'validity_id' => $cookie_vigencia_fifa->id
        ]
      )
      ;

      $cdprequests = $this->Items->Cdprequests->find('list', ['limit' => 200]);
      $types = $this->Items->Types->find('list', ['limit' => 200]);

      $this->set(compact('item', 'itemsClassifications', 'cdprequests', 'types'));
      $this->set('_serialize', ['item']);
    }

    /**
    * Edit method
    *
    * @param string|null $id Item id.
    * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
    * @throws \Cake\Network\Exception\NotFoundException When record not found.
    */
    public function edit($id = null)
    {

      $cookie_vigencia_fifa = Router::getRequest()->session()->read('cookie_vigencia_fifa');

      $item = $this->Items->get($id, [
        'contain' => ['ItemsClassifications']
      ]);

      if ($this->request->is(['patch', 'post', 'put'])) {

        $item = $this->Items->patchEntity($item, $this->request->data);
        if ($this->Items->save($item)) {
          $this->Flash->success(__('Información guardada'));

          return $this->redirect(['action' => 'index']);
        } else {
          $this->Flash->error(__('La información no se pudo guardar. Por favor, inténtelo de nuevo.'));
        }
      }

      $itemsClassifications = $this->Items->ItemsClassifications
      ->find('list', ['limit' => 200])
      ->where(
        [
          'validity_id' => $cookie_vigencia_fifa->id
        ]
      )
      ;

      $cdprequests = $this->Items->Cdprequests->find('list', ['limit' => 200]);
      $types = $this->Items->Types->find('list', ['limit' => 200]);

      $this->set(compact('item', 'itemsClassifications', 'cdprequests', 'types'));
      $this->set('_serialize', ['item']);
    }

    /**
    * Delete method
    *
    * @param string|null $id Item id.
    * @return \Cake\Network\Response|null Redirects to index.
    * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
    */
    public function delete($id = null)
    {
      $this->request->allowMethod(['post', 'delete']);
      $item = $this->Items->get($id,[
        'contain' => ['ItemsClassifications']
      ]);
      if ($this->Items->delete($item)) {
        $this->Flash->success(__('Se ha eliminado.'));
      } else {
        $this->Flash->error(__('La información no se pudo eliminar. Por favor, inténtelo de nuevo.'));
      }

      return $this->redirect(['action' => 'index']);
    }
  }
