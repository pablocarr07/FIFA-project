<?php

namespace Cake\ORM\Behavior;

use Cake\Datasource\EntityInterface;
use Cake\Event\Event;
use Cake\ORM\Behavior;
use Cake\ORM\Entity;
use ArrayObject;
use Cake\Log\Log;
use Fifa\LogicFifa;
use Cake\Validation\Validator;

class FifaBehavior extends Behavior
{

    function initialize(array $config)
    {
        // parent::initialize($config);
        $this->Fifa = new LogicFifa();
    }

    public function beforeSave(Event $event, Entity $entity, ArrayObject $options)
    {
        $this->Fifa->proximaAutorizacion($event, $entity, $options);
    }

    public function afterSave(Event $event, EntityInterface $entity, ArrayObject $options)
    {
        $this->Fifa->planningTasks($entity, $this->_table);
        $this->Fifa->cdpRequestTimeline($entity, $this->_table);
        $this->Fifa->cdpRequestNotifications($entity, $this->_table);
        //$this->Fifa->cdpRequestSignature($entity,$this->_table);
    }

    public function validationCertificate(Validator $validator)
    {

        $validator
            ->requirePresence('certificate', 'update')
            ->add('certificate', [
                'validExtension' => [
                    'rule' => ['extension', ['dat']],
                    'message' => __('Certificado solo se permiten archivos con extensión .dat')
                ],
                'validationCertificate' => [
                    'rule' => 'customValidationCertificate',
                    'provider' => 'table'
                ]
            ])->notEmpty('certificate', 'El campo Cerficado es obligatorio.');

        $validator
            ->add('soprtecdp_file', [
                'validExtension' => [
                    'rule' => ['extension', ['pdf']],
                    'message' => __('solo se permiten archivos con extensión .pdf')
                ]
            ])
            ->notEmpty('soprtecdp_file', 'El campo Soporte Cdp es obligatorio.');


        $validator
            ->add('cdp', [
                'naturalNumber' => [
                    'rule' => 'naturalNumber',
                    'message' => 'El campo Número Cdp debe ser entero positivo'
                ]
            ])
            ->notEmpty('cdp', 'El campo Número Cdp es obligatorio.');

        return $validator;
    }

    public function customValidationCertificate($value, $context)
    {
        return $this->Fifa->customValidationCertificate($value);
    }
}
