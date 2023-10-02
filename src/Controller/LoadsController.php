<?php
namespace App\Controller;

use App\Controller\AppController;
use Fifa;

/**
 * Loads Controller
 *
 * @property \App\Model\Table\LoadsTable $Loads
 */
class LoadsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $loads = $this->paginate($this->Loads);

        $this->set(compact('loads'));
        $this->set('_serialize', ['loads']);
    }

    /**
     * View method
     *
     * @param string|null $id Load id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $load = $this->Loads->get($id, [
            'contain' => ['Cdps', 'CdpsTmp', 'Compromisos', 'CompromisosTmp']
        ]);

        $this->set('load', $load);
        $this->set('_serialize', ['load']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $load = $this->Loads->newEntity();
        $fileload = new Fifa\LoadFile();
        
        if ($this->request->is('post')) {
            
             $datain = array(
                'cdp' => $this->request->data['cdp'],
                'compromiso' => $this->request->data['compromiso']
            );
             $fileload->load($datain);
             
             if ($fileload->output['exito']) {
                $load->id = $fileload->output['uuid'];
				$load->user_id = $this->Auth->user('id');
                $this->request->data['cdp'] = $fileload->output['upload']['cdp']['file'];
                $this->request->data['compromiso'] = $fileload->output['upload']['compromiso']['file'];
                $load = $this->Loads->patchEntity($load, $this->request->data);

                if ($this->Loads->save($load)) {
                    $this->Flash->success(__('Se ha guardado los archivos.'));
                    return $this->redirect(['action' => 'index']);
                } else {
                    $this->Flash->error(__('No se pueden guardar los archivos. Por favor, inténtelo de nuevo.'));
                }
            } else {
                $this->Flash->error(__($fileload->output['mensaje']));
            }
        }
        $this->set(compact('load'));
        $this->set('_serialize', ['load']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Load id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $load = $this->Loads->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $load = $this->Loads->patchEntity($load, $this->request->data);
            if ($this->Loads->save($load)) {
                $this->Flash->success(__('Se ha guardado los archivos.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('No se pueden guardar los archivos. Por favor, inténtelo de nuevo.'));
            }
        }
        $this->set(compact('load'));
        $this->set('_serialize', ['load']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Load id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $load = $this->Loads->get($id);
        if ($this->Loads->delete($load)) {
            $this->Flash->success(__('Se han eliminado los archivos.'));
        } else {
            $this->Flash->error(__('No se pudieron borrar los archivos. Por favor, inténtelo de nuevo.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
