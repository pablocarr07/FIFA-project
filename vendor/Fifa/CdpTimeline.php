<?php

namespace Fifa;

use Cake\Network\Session;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;

class CdpTimeline
{

    public function __construct()
    {
        $this->session = new Session();
        $this->cdptimeline = TableRegistry::get('Cdptimeline'); 
        $this->users = TableRegistry::get('Users');
    }

    /* class timeline */

    public function cdp($entity, $table, $todo)
    {

        $commentary = '';
        $cdprequest = $table->get($entity->id, ['contain' => ['States', 'Movement_types', 'Applicants', 'Created_by']]);
        $user = $this->users->get($this->session->read('Auth.User.id'));

        if (isset($entity->commentary)) {
            $commentary = $entity->commentary;
        }

        /* ,
          'document' => $document,
          'signature' => $path */
        $data = [
            'created_by' => $this->session->read('Auth.User.id'),
            'cdpsstates_id' => $entity->state,
            'cdprequest_id' => $entity->id,
            'commentary' => $commentary
        ];

        $cdptimeline = $this->cdptimeline->newEntity($data);
        $cdptimeline = $this->cdptimeline->patchEntity($cdptimeline, $data);

        $this->cdptimeline->save($cdptimeline);

        $items = $this->obtenerDatosCdpRequestsItems($cdprequest->id);

        $document = json_encode([
            'cdp' => $cdprequest->id,
            'estado' => $cdprequest->State->name,
            'solicitante' => $cdprequest->Applicants->name,
            'creado_por' => $cdprequest->Created_by->name,
            'tipo_movimiento' => $cdprequest->Movement_types->name,
            'objecto' => $cdprequest->object,
            'justificacion' => $cdprequest->justification,
            'items' => json_decode($items, true),
            'timeline' => $this->CdprequestsTimeline($cdprequest->id)
        ]);

        $signature = Signature::sign($document, $user->privatekey);

        $path = 'signature/' . \Cake\Utility\Text::uuid() . '.dat';
        //$file = new \Cake\Filesystem\File(__DIR__ . '../../../' . $path, true, 0644);
        $file = new \Cake\Filesystem\File('/var/www/html/fifa/' . $path, true, 0644);
        $file->write($signature, 'w', false);

        $cdptimeline->document = $document;
        $cdptimeline->signature = $path;

        $this->cdptimeline->save($cdptimeline);

    }

    public function CdprequestsTimeline($cdprequest_id, $json = FALSE)
    {
        $output = [];

        $timeline =
            $this->cdptimeline
            ->find()
            ->select([
                'Cdptimeline.document',
                'Cdptimeline.signature',
                'Cdptimeline.created',
                'Cdptimeline.commentary',
                'cdpsstate.id',
                'cdpsstate.name',
                'created_by.id',
                'created_by.name'
            ])
            ->join([
                'table' => 'cdpsstates',
                'alias' => 'cdpsstate',
                'type' => 'INNER',
                'conditions' => 'Cdptimeline.cdpsstates_id = cdpsstate.id',
            ])
            ->join([
                'table' => 'users',
                'alias' => 'created_by',
                'type' => 'INNER',
                'conditions' => 'Cdptimeline.created_by = created_by.id',
            ])
            ->order(['Cdptimeline.created' => 'DESC'])
            ->where(['Cdptimeline.cdprequest_id' => $cdprequest_id]);

        foreach ($timeline as $i) {
            $output[] = [
                'cdpsstate' => [
                    'id' => $i->cdpsstate['id'],
                    'name' => $i->cdpsstate['name']
                ],
                'created_by' => [
                    'id' => $i->created_by['id'],
                    'name' => $i->created_by['name']
                ],
                'signature' => [
                    'document' => $i->document,
                    'signature' => $i->signature
                ],
                'created' => $i->created->timeAgoInWords(['format' => 'dd MMMM YYYY', 'end' => '+1 year']),
                'createdFull' => $i->created,
                'commentary' => $i->commentary
            ];
        }

        if ($json) {
            foreach ($output as $key => $o) {
                $output[$key] = json_encode($o);
            }
        }

        return $output;
    }

    public function obtenerDatosCdpRequestsItems($cdpRequestsId)
    {

        //Obtener listado de cdprequest_item
        $config = TableRegistry::config('cdprequest_item', [
            'table' => 'cdprequests_items',
            'alias' => 'cdprequest_item'
        ]);

        //Obtener listado de cdprequests_items_tasks
        $configItemsTasks = TableRegistry::config('item_task', [
            'table' => 'cdprequests_items_tasks',
            'alias' => 'item_task'
        ]);

        $listadoCdpRequestsItems = TableRegistry::get('cdprequest_item', $config)
            ->find()
            ->select([
                'cdprequests_items' => 'cdprequest_item.id',
                'cdprequest_item.value',
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
                'conditions' => 'cdprequest_item.item_id = item.id',
            ])
            ->join([
                'table' => 'resources',
                'alias' => 'resource',
                'type' => 'INNER',
                'conditions' => 'cdprequest_item.resource_id = resource.id',
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
            ->where(['cdprequest_item.cdprequest_id' => $cdpRequestsId]);

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

            $listadoCdpRequestsTasks = TableRegistry::get('item_task', $configItemsTasks)
                ->find()
                ->select([
                    'task.id',
                    'task.name',
                ])
                ->join([
                    'table' => 'tasks',
                    'alias' => 'task',
                    'type' => 'INNER',
                    'conditions' => 'item_task.task_id = task.id',
                ])
                ->where(['item_task.cdprequest_item_id' => $cdpRequestItemId]);


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
