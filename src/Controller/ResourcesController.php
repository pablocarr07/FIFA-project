<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Routing\Router;

/**
* Resources Controller
*
* @property \App\Model\Table\ResourcesTable $Resources
*/
class ResourcesController extends AppController
{

  /**
  * Index method
  *
  * @return \Cake\Network\Response|null
  */
  public function index()
  {

    $cookie_vigencia_fifa = Router::getRequest()->session()->read('cookie_vigencia_fifa');

    $query = $this->Resources->find(
      'search',
      [
        'search' => $this->request->query
      ]
    )
    ->where([
			'validity_id' => $cookie_vigencia_fifa->id
		])
    ;

    $resources = $this->paginate($query);

    $this->set(compact('resources'));
    $this->set('_serialize', ['resources']);
  }

  /**
  * View method
  *
  * @param string|null $id Resource id.
  * @return \Cake\Network\Response|null
  * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
  */
  public function view($id = null)
  {
    $resource = $this->Resources->get($id, [
      'contain' => ['CdprequestsItems']
    ]);

    $this->set('resource', $resource);
    $this->set('_serialize', ['resource']);
  }

  /**
  * Add method
  *
  * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
  */
  public function add()
  {

    $cookie_vigencia_fifa = Router::getRequest()->session()->read('cookie_vigencia_fifa');

    $resource = $this->Resources->newEntity();
    if ($this->request->is('post')) {

      $this->request->data['validity_id']=$cookie_vigencia_fifa->id;

      $resource = $this->Resources->patchEntity($resource, $this->request->data);
      if ($this->Resources->save($resource)) {
        $this->Flash->success(__('Información guardada'));

        return $this->redirect(['action' => 'index']);
      } else {
        $this->Flash->error(__('La información no se pudo guardar. Por favor, inténtelo de nuevo.'));
      }
    }
    $this->set(compact('resource'));
    $this->set('_serialize', ['resource']);
  }

  /**
  * Edit method
  *
  * @param string|null $id Resource id.
  * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
  * @throws \Cake\Network\Exception\NotFoundException When record not found.
  */
  public function edit($id = null)
  {
    $resource = $this->Resources->get($id, [
      'contain' => []
    ]);
    if ($this->request->is(['patch', 'post', 'put'])) {
      $resource = $this->Resources->patchEntity($resource, $this->request->data);
      if ($this->Resources->save($resource)) {
        $this->Flash->success(__('Información guardada'));

        return $this->redirect(['action' => 'index']);
      } else {
        $this->Flash->error(__('La información no se pudo guardar. Por favor, inténtelo de nuevo.'));
      }
    }
    $this->set(compact('resource'));
    $this->set('_serialize', ['resource']);
  }

  /**
  * Delete method
  *
  * @param string|null $id Resource id.
  * @return \Cake\Network\Response|null Redirects to index.
  * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
  */
  public function delete($id = null)
  {
    $this->request->allowMethod(['post', 'delete']);
    $resource = $this->Resources->get($id);
    if ($this->Resources->delete($resource)) {
      $this->Flash->success(__('Se ha eliminado.'));
    } else {
      $this->Flash->error(__('La información no se pudo eliminar. Por favor, inténtelo de nuevo.'));
    }

    return $this->redirect(['action' => 'index']);
  }
}
