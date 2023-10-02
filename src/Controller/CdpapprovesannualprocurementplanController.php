<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Log\Log;


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

class CdpapprovesannualprocurementplanController extends AppController {

    public function initialize() {
        parent::initialize();
        $this->loadModel('Cdprequests');
        $this->loadModel('ItemsTypes');
        $this->loadModel('Resources');
        $this->query = $this->Fifa->Cdprequests()->Cdprequests_aprobacion_asesor_compras();
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index() {
        $query = $this->query->where(array('Cdprequests.state' => 6));
        $cdprequests = $this->paginate($query);
        $this->set(compact('cdprequests'));
        $this->set('_serialize', ['cdprequests']);
    }

    public function view($id = null) {

        $query = $this->query->where(array('Cdprequests.state' => 6, 'Cdprequests.id' => $id));

        if ($query->count() > 0) {
            $cdprequest=$query->first();
            $itemsdata = $this->Fifa->obtenerDatosCdpRequestsItems($cdprequest->id);
            $applicants = $this->Cdprequests->Applicants->find('list', ['limit' => 1000]);
            $movementTypes = $this->Cdprequests->Movement_types->find('list', ['limit' => 200]);
            $itemstypes = $this->ItemsTypes->find('list', ['limit' => 200]);
            $items = $this->Cdprequests->Items->find('list', ['limit' => 200]);
            $resources = $this->Resources->find('list', ['limit' => 200]);
            $states = $this->Cdprequests->States->find('list', ['limit' => 200]);
            $this->set(compact('cdprequest', 'applicants', 'movementTypes', 'items', 'itemstypes', 'resources', 'itemsdata', 'states'));
            $this->set('_serialize', ['cdprequest']);
        } else {
            return $this->redirect(['action' => 'index']);
        }
    }

    public function approve() {
        Log::error('approve');
        $output = $this->action(6, 7, 'aprobar');
        $this->set('output', $output);
        $this->set('_serialize', ['output']);
    }

    public function cancel() {
        if (!empty($this->request->data['commentary'])) {
            $output = $this->action(6, 1);
        } else {
            $output = ['success' => FALSE, 'id' => FALSE, 'message' => 'El campo Comentario es Obligatorio', 'url' => FALSE];
        }
        $this->set('output', $output);
        $this->set('_serialize', ['output']);
    }

    public function update() {
        if (!empty($this->request->data['commentary'])) {
            $output = $this->action(6, 2);
        } else {
            $output = ['success' => FALSE, 'id' => FALSE, 'message' => 'El campo Comentario es Obligatorio', 'url' => FALSE];
        }
        $this->set('output', $output);
        $this->set('_serialize', ['output']);
    }

    private function action($state_in, $state_out) {
        $output = ['success' => FALSE, 'id' => FALSE, 'message' => FALSE, 'url' => FALSE];

        if ($this->request->is(['patch', 'post', 'put'])) {
           
            $cdprequest = $this->query->where(array('Cdprequests.id' => $this->request->data['id']))->first();
            

            if ($cdprequest) {
                $cdprequest->state = $state_out;

                $cdprequest->commentary = '';

                if ($this->request->data['commentary']) {
                    $cdprequest->commentary = $this->request->data['commentary'];
                }

                $cdprequest = $this->Cdprequests->patchEntity($cdprequest, $this->request->data, ['validate' => 'certificate']);

                if ($this->Cdprequests->save($cdprequest, ['validate' => 'certificate'])) {
                    //$this->Fifa->cdpRequestNotifications($this->Cdprequests, $cdprequest->id);
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

}
