<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use Cake\Log\Log;

/**
 * Validities Controller
 *
 * @property \App\Model\Table\ValiditiesTable $Validities
 */
class ValiditiesController extends AppController
{


  public function initialize() {
      parent::initialize();
      $this->loadModel('Validities');
  }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        // $validities = $this->paginate($this->Validities);
        $query = $this->Validities->find('search', ['search' => $this->request->query]);
        $validities = $this->paginate($query);


        $this->set(compact('validities'));
        $this->set('_serialize', ['validities']);
    }

    /**
     * View method
     *
     * @param string|null $id Validity id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $validity = $this->Validities->get($id, [
            'contain' => []
        ]);

        $this->set('validity', $validity);
        $this->set('_serialize', ['validity']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $validity = $this->Validities->newEntity();
        if ($this->request->is('post')) {
            $validity = $this->Validities->patchEntity($validity, $this->request->data);
            if ($this->Validities->save($validity)) {
                $this->Flash->success(__('The validity has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The validity could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('validity'));
        $this->set('_serialize', ['validity']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Validity id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $validity = $this->Validities->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $validity = $this->Validities->patchEntity($validity, $this->request->data);
            if ($this->Validities->save($validity)) {
                $this->Flash->success(__('The validity has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The validity could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('validity'));
        $this->set('_serialize', ['validity']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Validity id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $validity = $this->Validities->get($id);
        if ($this->Validities->delete($validity)) {
            $this->Flash->success(__('Se ha eliminado.'));
        } else {
            $this->Flash->error(__('La información no se pudo eliminar. Por favor, inténtelo de nuevo.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function change ($id, $url='Cdprequestsdashboard') {

        $cookie_vigencia_fifa = Router::getRequest()->session()->read('cookie_vigencia_fifa');

        //Obtener última vigencia y guardarla en cookies
        $cookie_vigencia_fifa = $tareasXDependencia = TableRegistry::get('Validities')
        ->find()
        ->select(['id', 'name'])
        ->where(['id' => $id])
        ->order([
        'name' => 'DESC'
        ])
        ->first()
        ;

        $this->request->session()->write('cookie_vigencia_fifa', $cookie_vigencia_fifa);
        
        //Retornarlo a la página actual
        return $this->redirect($url);

    }
}
