<?php

namespace App\Controller;

use App\Controller\AppController;

/**
 * Tasks Controller
 *
 * @property \App\Model\Table\TasksTable $Tasks
 */
class TasksController extends AppController {

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index() {

        $query = $this->Tasks->find('search', ['search' => $this->request->query]);
        $tasks = $this->paginate($query);

        $this->set(compact('tasks'));
        $this->set('_serialize', ['tasks']);
    }

    /**
     * View method
     *
     * @param string|null $id Task id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null) {
        $task = $this->Tasks->get($id, [
            'contain' => []
        ]);

        $this->set('task', $task);
        $this->set('_serialize', ['task']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add() {
        $task = $this->Tasks->newEntity();
        if ($this->request->is('post')) {
            $task = $this->Tasks->patchEntity($task, $this->request->data);
            if ($this->Tasks->save($task)) {
               $this->Flash->success(__('Información guardada'));

                return $this->redirect(['action' => 'index']);
            } else {
                 $this->Flash->error(__('La información no se pudo guardar. Por favor, inténtelo de nuevo.'));
            }
        }
        $this->set(compact('task'));
        $this->set('_serialize', ['task']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Task id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null) {
        $task = $this->Tasks->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $task = $this->Tasks->patchEntity($task, $this->request->data);
            if ($this->Tasks->save($task)) {
                $this->Flash->success(__('Información guardada'));

                return $this->redirect(['action' => 'index']);
            } else {
                 $this->Flash->error(__('La información no se pudo guardar. Por favor, inténtelo de nuevo.'));
            }
        }
        $this->set(compact('task'));
        $this->set('_serialize', ['task']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Task id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $task = $this->Tasks->get($id);
        if ($this->Tasks->delete($task)) {
            $this->Flash->success(__('Información guardada'));
        } else {
           $this->Flash->error(__('La información no se pudo guardar. Por favor, inténtelo de nuevo.'));
        }

        return $this->redirect(['action' => 'index']);
    }

}
