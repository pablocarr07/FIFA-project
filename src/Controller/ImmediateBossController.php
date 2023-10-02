<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;

/**
 * Budgets Controller
 *
 * @property \App\Model\Table\BudgetsTable $Budgets
 */
class ImmediateBossController extends AppController {

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index() {
        $immediateboss = $this->Fifa->ImmediateBoss();
        $this->set(compact('immediateboss'));
    }

    public function update($id = null) {

        $this->Groups = TableRegistry::get('Groups');

        $dependency = $this->Groups->get($id, [
            'contain' => []
        ]);
         $output = ['success' => FALSE,'message' => FALSE];
        if ($this->request->is(['patch', 'post', 'put'])) {
            $dependency = $this->Groups->patchEntity($dependency, $this->request->data);
            if ($this->Groups->save($dependency)) {
                $output = ['success' => TRUE, 'id' => $id, 'message' => 'The dependency has been saved.'];
            } else {
                $this->Flash->error(__('The dependency could not be saved. Please, try again.'));
                $output = ['success' => FALSE, 'id' => FALSE, 'message' => 'The dependency could not be saved. Please, try again.'];
            }
        }
        $this->set('output', $output);
        $this->set('_serialize', ['output']);
    }

}
