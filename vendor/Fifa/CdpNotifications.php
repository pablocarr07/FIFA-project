<?php

namespace Fifa;

use Cake\ORM\TableRegistry;
use Cake\Network\Session;
use Cake\Log\Log;

class CdpNotifications 
{

    public function __construct()
    {
        $this->email = new FifaEmail();
        $this->Users = TableRegistry::get('Users');
        $this->cdpautorizacion = new CdpAutorizacion();
    }

    /* class notificacion */

    function cdpRequestNotifications($table, $entity, $method)
    {

        $email = FALSE;
        $complemento = 'para su gestión';

        $cdprequest = $table->get($entity->id, ['contain' => ['States', 'Movement_types', 'Applicants', 'Created_by']]); //'Timeline',

        $attachments = FALSE;

        if ($cdprequest->state == 1) { //rechazado
            $email = $this->cdpautorizacion->usercdpautorizanemail($cdprequest->id);
            $complemento = '';
        } elseif ($cdprequest->state == 2) { //Solicitar Modificación
            $email = $this->cdpautorizacion->usercdpautorizanemail($cdprequest->id);
        } elseif ($cdprequest->state == 3) { //Aprobar Solicitante
            $user = $this->cdpautorizacion->users->get($cdprequest->applicant_id);
            $email = $user->email;
        } elseif ($cdprequest->state == 4) { //Aprobar  Jefe Inmediato
            $user = $this->cdpautorizacion->getImmediateBossInfo($cdprequest->group_id);
            $email = $user->email;
        } elseif ($cdprequest->state == 5) { //Aprobar Asesor de Planeación
            $email = $this->cdpautorizacion->proximaAutorizacionUserRoleemail(7);
        } elseif ($cdprequest->state == 6) { //aprobar asesor de de compras
            $email = $this->cdpautorizacion->proximaAutorizacionUserRoleemail(6);
        } elseif ($cdprequest->state == 7) { //Aprobar Secretario General
            $email = $this->cdpautorizacion->proximaAutorizacionUserRoleemail(3);
        } elseif ($cdprequest->state == 8) { //Coordinador Financiera
            $email = $this->cdpautorizacion->proximaAutorizacionUserRoleemail(4);
        } elseif ($cdprequest->state == 9) { //Gestionada
            $email = $this->cdpautorizacion->usercdpautorizanemail($cdprequest->id);
            $complemento = '';
            $attachments = $cdprequest->soprtecdp;
        } elseif ($cdprequest->state == 10) { //Aplazar
            $email = $this->cdpautorizacion->usercdpautorizanemail($cdprequest->id);
        }

        $items = $this->obtenerDatosCdpRequestsItems($cdprequest->id);

        if (!empty($email) or is_array($email)) {
            $asunto = 'Solcitud de CDP ' . $cdprequest->id . ' ( ' . $cdprequest->State->name . ' )';
            $template = 'solicitudcdp';
            $dataemail = [
                'cdp' => $cdprequest->id,
                'estado' => $cdprequest->State->name,
                'complemento' => $complemento,
                'attachments' => $attachments,
                'solicitante' => $cdprequest->Applicants->name,
                'creado_por' => $cdprequest->Created_by->name,
                'tipo_movimiento' => $cdprequest->Movement_types->name,
                'objecto' => $cdprequest->object,
                'justificacion' => $cdprequest->justification,
                'items' => json_decode($items, true),
                'timeline' => $method->timeline->CdprequestsTimeline($cdprequest->id)
            ];

            $this->email->send($asunto, $email, $template, $dataemail);
        }

    }

    public function obtenerDatosCdpRequestsItems($cdpRequestsId)
    {
  
      //Obtener listado de cdprequest_item
      $config = TableRegistry::config('cdprequest_items', [
        'table' => 'cdprequests_items',
        'alias' => 'cdprequest_item'
      ]);
  
      //Obtener listado de cdprequests_items_tasks
      $configItemsTasks = TableRegistry::config('item_tasks', [
        'table' => 'cdprequests_items_tasks',
        'alias' => 'item_task'
      ]);
  
      $listadoCdpRequestsItems = TableRegistry::get('cdprequest_items', $config)
        ->find()
        ->select([
          'cdprequests_items' => 'cdprequest_items.id',
          'cdprequest_items.value',
          'item.id',
          'item.name',
          'resource.id',
          'resource.name',
          'item_classification.id',
          'item_classification.name',
          'item_type.id',
          'item_type.name'
        ])
        ->join([
          'table' => 'items',
          'alias' => 'item',
          'type' => 'INNER',
          'conditions' => 'cdprequest_items.item_id = item.id',
        ])
        ->join([
          'table' => 'resources',
          'alias' => 'resource',
          'type' => 'INNER',
          'conditions' => 'cdprequest_items.resource_id = resource.id',
        ])
        ->join([
          'table' => 'items_classifications',
          'alias' => 'item_classification',
          'type' => 'INNER',
          'conditions' => 'item.item_classification_id = item_classification.id',
        ])
        ->join([
          'table' => 'items_types',
          'alias' => 'item_type',
          'type' => 'INNER',
          'conditions' => 'item_classification.item_type_id = item_type.id',
        ])
        ->where(['cdprequest_items.cdprequest_id' => $cdpRequestsId]);
  
      $cdpRequestsItems = array();
      foreach ($listadoCdpRequestsItems as $cdpRequestItem) {
  
        $cdpRequestItemId = json_decode($cdpRequestItem)->cdprequests_items;
        $cdpRequestItemValue = json_decode($cdpRequestItem)->value;
        $itemId = json_decode($cdpRequestItem)->item->id;
        $itemName = json_decode($cdpRequestItem)->item->name;
        $resourceId = json_decode($cdpRequestItem)->resource->id;
        $resourceName = json_decode($cdpRequestItem)->resource->name;
        $itemClassificationId = json_decode($cdpRequestItem)->item_classification->id;
        $itemClassificationName = json_decode($cdpRequestItem)->item_classification->name;
        $itemTypeId = json_decode($cdpRequestItem)->item_type->id;
        $itemTypeName = json_decode($cdpRequestItem)->item_type->name;
  
        $listadoCdpRequestsTasks = TableRegistry::get('item_tasks', $configItemsTasks)
          ->find()
          ->select([
            'task.id',
            'task.name',
          ])
          ->join([
            'table' => 'tasks',
            'alias' => 'task',
            'type' => 'INNER',
            'conditions' => 'item_tasks.task_id = task.id',
          ])
          ->where(['item_tasks.cdprequest_item_id' => $cdpRequestItemId]);
  
  
        $tasks = array();
        foreach ($listadoCdpRequestsTasks as $cdpRequestTask) {
          $cdpRequestTaskId = json_decode($cdpRequestTask)->task->id;
          $cdpRequestTaskName = json_decode($cdpRequestTask)->task->name;
  
          $dataFormateada = [
            'id' => $cdpRequestTaskId,
            'name' => $cdpRequestTaskName,
          ];
          array_push($tasks, $dataFormateada);
        }
  
        $dataFormateada = [
          'cdprequests_items' => $cdpRequestItemId,
          'value' => $cdpRequestItemValue,
          'items' => [
            'id' => $itemId,
            'name' => $itemName
          ],
          'resources' => [
            'id' => $resourceId,
            'name' => $resourceName
          ],
          'classifications' => [
            'id' => $itemClassificationId,
            'name' => $itemClassificationName
          ],
          'itemstypes' => [
            'id' => $itemTypeId,
            'name' => $itemTypeName,
          ],
          'tasks' => $tasks,
  
        ];
  
        array_push($cdpRequestsItems, $dataFormateada);
      }
  
      return json_encode($cdpRequestsItems);
    }
}
