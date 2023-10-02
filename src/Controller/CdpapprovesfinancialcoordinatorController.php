<?php

namespace App\Controller;

use App\Controller\AppController;

/**
 * Cdprequests Controller
 *
 * @property \App\Model\Table\CdprequestsTable $Cdprequests
 */
/* matriz aprobación */
/*
 * estados	cdp
  0	borrador
  1	rechazar
  2	solicitar modificacion
  3	aprobar solicitante
  4	aprobar  jefe inmediato
  5	aprobar asesor de planeacion
  6	aprobar asesor de de compras
  7	aprobar secretario general
  8	coordinador financiera
  9	Aprobar
  10	Aplazar
 * 
 * */

class CdpapprovesfinancialcoordinatorController extends AppController {

    public function initialize() {
        parent::initialize();
        $this->loadModel('Cdprequests');
        $this->loadModel('ItemsTypes');
        $this->loadModel('Resources');
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index() {
        /*
          $query = $this->Cdprequests->find('all')
          ->where(array('cdprequests.state IN' => [8, 10]))
          ->contain(['Applicants', 'Created_by', 'States', 'Movement_types', 'Groups', 'Items'])
          ->order(['cdprequests.created' => 'DESC']);
         */

        $preloader = $this->preloader();
        $state_id = $preloader['state_id'];
        $cdprequests = $this->paginate($preloader['query']);
        $this->set(compact(['cdprequests', 'state_id']));
        $this->set('_serialize', ['cdprequests', 'state_id']);
    }

    public function view() {
        /*
          $cdprequest = $this->Cdprequests->find()
          ->where(array('cdprequests.state IN' => [8, 10], 'Cdprequests.id' => $id))
          ->contain(['Applicants', 'Created_by', 'States', 'Movement_types', 'Groups', 'Items'])
          ->first();
         */
        $preloader = $this->preloader();
        $query = $preloader['query']->where(array('Cdprequests.state IN' => [8, 10], 'Cdprequests.id' => $preloader['id']));
        if ($query->count() > 0) {
            $state_id = $preloader['state_id'];
            $cdprequest=$query->first();
            $itemsdata = $this->Fifa->obtenerDatosCdpRequestsItems($cdprequest->id);
            $applicants = $this->Cdprequests->Applicants->find('list', ['limit' => 1000]);
            $movementTypes = $this->Cdprequests->Movement_types->find('list', ['limit' => 200]);
            $itemstypes = $this->ItemsTypes->find('list', ['limit' => 200]);
            $items = $this->Cdprequests->Items->find('list', ['limit' => 200]);
            $resources = $this->Resources->find('list', ['limit' => 200]);
            $states = $this->Cdprequests->States->find('list', ['limit' => 200]);
            $this->set(compact('cdprequest', 'applicants', 'movementTypes', 'items', 'itemstypes', 'resources', 'itemsdata', 'states','state_id'));
            $this->set('_serialize', ['cdprequests']);
        } else {
            return $this->redirect(['action' => 'index', '?' => ['state-id' => $preloader['state_id']]]);
        }
    }

    public function approve() {

        if (!empty($this->request->data['soprtecdp_file'])) {
            $output = $this->action([8, 10], 9, 'aprobar');
        } else {
            $output = ['success' => FALSE, 'id' => FALSE, 'message' => 'El campo Soporte Cdp es Obligatorio', 'url' => FALSE];
        }
        $this->set('output', $output);
        $this->set('_serialize', ['output']);
    }

    public function cancel() {
        if (!empty($this->request->data['commentary'])) {
            $output = $this->action([8, 10], 1);
        } else {
            $output = ['success' => FALSE, 'id' => FALSE, 'message' => 'El campo Comentario es Obligatorio', 'url' => FALSE];
        }
        $this->set('output', $output);
        $this->set('_serialize', ['output']);
    }

    public function update() {
        if (!empty($this->request->data['commentary'])) {
            $output = $this->action([8, 10], 2);
        } else {
            $output = ['success' => FALSE, 'id' => FALSE, 'message' => 'El campo Comentario es Obligatorio', 'url' => FALSE];
        }
        $this->set('output', $output);
        $this->set('_serialize', ['output']);
    }

    public function postpone() {
        if (!empty($this->request->data['commentary'])) {
            $output = $this->action([8, 10], 10);
        } else {
            $output = ['success' => FALSE, 'id' => FALSE, 'message' => 'El campo Comentario es Obligatorio', 'url' => FALSE];
        }
        $this->set('output', $output);
        $this->set('_serialize', ['output']);
    }

    private function action($state_in, $state_out) {
        $output = ['success' => FALSE, 'id' => FALSE, 'message' => FALSE, 'url' => FALSE];

        if ($this->request->is(['patch', 'post', 'put'])) {

            $preloader = $this->preloader();
            $cdprequest = $preloader['query']->where(['Cdprequests.id'=>$this->request->data['id']])->first();

            if ((in_array($cdprequest->state, $state_in))) {
                $cdprequest->state = $state_out;

                $cdprequest->commentary = '';

                $cdprequest->cd = '';
                
                if ($this->request->data['commentary']) {
                    $cdprequest->commentary = $this->request->data['commentary'];
                }

                if ($state_out == 9) {
                    $cdprequest->cd = $this->request->data['cdp'];
                } else {
                    unset($this->request->data['soprtecdp_file']);
                }

                $cdprequest = $this->Cdprequests->patchEntity($cdprequest, $this->request->data, ['validate' => 'certificate']);
				

                if ($this->Cdprequests->save($cdprequest, ['validate' => 'certificate'])) {

                    $output = ['success' => TRUE, 'id' => $cdprequest->id, 'message' =>'la Solicitud de CDP '.$cdprequest->id.' se Actualizado', 'url' => 'index'];
                } else {
                    $output = ['success' => FALSE, 'id' => FALSE, 'message' => $this->Fifa->show_erros($cdprequest->errors()), 'url' => FALSE];
                }
            } else {
                $output = ['success' => FALSE, 'id' => FALSE, 'message' => 'No se encontro CDP', 'url' => FALSE];
            }
        } else {
            $output = ['success' => FALSE, 'id' => FALSE, 'message' => $validate, 'url' => FALSE];
        }

        return $output;
    }

    private function preloader() {

        $cdprequests = $this->Fifa->Cdprequests();
        $state_id = $this->request->query('state-id');
        $query = FALSE;

        if ($state_id == 10) {
            $query = $cdprequests->Cdprequests_aplazada();
        } elseif ($state_id == 8) {
            $query = $cdprequests->Cdprequests_aprobacion_coordinador_financiera();
        } else {
            $this->redirect(['controller' => 'Cdprequestsdashboard', 'action' => 'index']);
        }
        return ['query' => $query, 'state_id' => $state_id, 'id' => $this->request->query('id')];
    }

}
