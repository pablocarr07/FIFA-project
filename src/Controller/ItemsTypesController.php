<?php
namespace App\Controller;
use App\Controller\AppController;

/**
 * ItemsTypes Controller
 *
 * @property \App\Model\Table\ItemsTypesTable $ItemsTypes
 */
class ItemsTypesController extends AppController
{

    
    
    public function initialize() {
        parent::initialize();
        $this->loadModel('ItemsTypes');
    }
    
    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        //$itemsTypes = $this->paginate($this->ItemsTypes);
        $query = $this->ItemsTypes->find('search', ['search' => $this->request->query]);
        $itemsTypes = $this->paginate($query);
        
        $this->set(compact('itemsTypes'));
        $this->set('_serialize', ['itemsTypes']);
    }

    /**
     * View method
     *
     * @param string|null $id Items Type id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $itemsType = $this->ItemsTypes->get($id, [
            'contain' => []
        ]);

        $this->set('itemsType', $itemsType);
        $this->set('_serialize', ['itemsType']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
         
        $itemsType = $this->ItemsTypes->newEntity();
        if ($this->request->is('post')) {
            $itemsType = $this->ItemsTypes->patchEntity($itemsType, $this->request->data);
            if ($this->ItemsTypes->save($itemsType)) {
                $this->Flash->success(__('Información guardada'));

                return $this->redirect(['action' => 'index']);
            } else {
                 $this->Flash->error(__('La información no se pudo guardar. Por favor, inténtelo de nuevo.'));
            }
        }
        $this->set(compact('itemsType'));
        $this->set('_serialize', ['itemsType']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Items Type id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $itemsType = $this->ItemsTypes->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $itemsType = $this->ItemsTypes->patchEntity($itemsType, $this->request->data);
            if ($this->ItemsTypes->save($itemsType)) {
                $this->Flash->success(__('Información guardada'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('La información no se pudo guardar. Por favor, inténtelo de nuevo.'));
            }
        }
        $this->set(compact('itemsType'));
        $this->set('_serialize', ['itemsType']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Items Type id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $itemsType = $this->ItemsTypes->get($id);
        if ($this->ItemsTypes->delete($itemsType)) {
            $this->Flash->success(__('Se ha eliminado.'));
        } else {
            $this->Flash->error(__('La información no se pudo eliminar. Por favor, inténtelo de nuevo.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
