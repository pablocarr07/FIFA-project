<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Routing\Router;

/**
* Groups Controller
*
* @property \App\Model\Table\GroupsTable $Groups
*/
class DependenciesController extends AppController
{

	public function initialize() {
		parent::initialize();
		$this->loadModel('Groups');
	}

	/**
	* Index method
	*
	* @return \Cake\Network\Response|null
	*/
	public function index()
	{

		$cookie_vigencia_fifa = Router::getRequest()->session()->read('cookie_vigencia_fifa');

		$query = $this->Groups->find(
			'search',
			[
				'search' => $this->request->query,
				'contain' => ['ParentGroups']
			]
		)
		->where([
			'Groups.parent_id IS NULL',
			'Groups.validity_id' => $cookie_vigencia_fifa->id
		])
		;

		$dependencies = $this->paginate($query);

		$this->set(compact('dependencies'));
		$this->set('_serialize', ['dependencies']);

	}

		/**
		* View method
		*
		* @param string|null $id Dependency id.
		* @return \Cake\Network\Response|null
		* @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
		*/
		public function view($id = null)
		{
			$dependency = $this->Groups->get($id, [
				'contain' => ['Users','ChildGroups']
			]);
			$this->set('dependency', $dependency);
			$this->set('_serialize', ['dependency']);

		}

		/**
		* Add method
		*
		* @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
		*/
		public function add()
		{

			$cookie_vigencia_fifa = Router::getRequest()->session()->read('cookie_vigencia_fifa');

			$dependency = $this->Groups->newEntity();
			if ($this->request->is('post')) {

				$this->request->data['budget']=0;
				$this->request->data['validity_id']=$cookie_vigencia_fifa->id;

				$dependency = $this->Groups->patchEntity($dependency, $this->request->data);

				if ($this->Groups->save($dependency)) {
					$this->Flash->success(__('La dependencia ha sido guardado.'));
					return $this->redirect(['action' => 'index']);
				} else {
					$this->Flash->error(__('La dependencia no pudo ser guardado. Por favor, inténtelo de nuevo.'));
				}
			}
			$this->set(compact('dependency'));
			$this->set('_serialize', ['dependency']);
		}

		/**
		* Edit method
		*
		* @param string|null $id Dependency id.
		* @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
		* @throws \Cake\Network\Exception\NotFoundException When record not found.
		*/
		public function edit($id = null)
		{
			$dependency = $this->Groups->get($id, [
				'contain' => []
			]);
			if ($this->request->is(['patch', 'post', 'put'])) {
				$dependency = $this->Groups->patchEntity($dependency, $this->request->data);
				if ($this->Groups->save($dependency)) {
					$this->Flash->success(__('La dependencia ha sido guardado.'));
					return $this->redirect(['action' => 'index']);
				} else {
					$this->Flash->error(__('La dependencia no pudo ser guardado. Por favor, inténtelo de nuevo.'));
				}
			}
			$this->set(compact('dependency'));
			$this->set('_serialize', ['dependency']);
		}

		/**
		* Delete method
		*
		* @param string|null $id Dependency id.
		* @return \Cake\Network\Response|null Redirects to index.
		* @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
		*/
		public function delete($id = null)
		{
			$this->request->allowMethod(['post', 'delete']);
			$dependency = $this->Groups->get($id);
			if ($this->Groups->delete($dependency)) {
				$this->Flash->success(__('La dependencia ha sido eliminada.'));
			} else {
				$this->Flash->error(__('La dependencia no pudo ser Eliminada. Por favor, inténtelo de nuevo.'));
			}
			return $this->redirect(['action' => 'index']);
		}
	}
