<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Fifa;

use Cake\Network\Session;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use Cake\Log\Log;

/**
 * Description of Signature
 *
 * @author oscar.ruiz
 */
class Cdprequests
{

    public $usergroup_id = 0;
    public $vigencia_id = 0;
    public $groups_id = [];

    public function __construct($todo)
    {
        $this->session = new Session();
        $this->Cdprequests = TableRegistry::get('Cdprequests');

        $cookie_vigencia_fifa = Router::getRequest()->session()->read('cookie_vigencia_fifa');

        $this->vigencia_id = $cookie_vigencia_fifa->id;

        $user_group = TableRegistry::get('GroupsUsers')->find()
            ->where(['user_id' => $this->session->read('Auth.User.id')])
            ->where(['validity_id' => $this->vigencia_id])
            ->where(['deleted is null'])
            ->first();

        //Obtener los grupo de la vigencia
        $this->groups_id = TableRegistry::get('Groups')
            ->find()
            ->where(['validity_id' => $this->vigencia_id])
            ->where(['deleted is null'])
            ->select(['id']);

        $this->usergroup_id = 0;
        if ($user_group) {
            $this->usergroup_id = $user_group->group_id;
        }

        //$todo->getImmediateBossGroups($this->session->read('Auth.User.group_id'), $this->session->read('Auth.User.id'));
        $this->grupos = array_keys($todo->getImmediateBossGroups($this->usergroup_id, $this->session->read('Auth.User.id')));
        //$this->Auth->user('group_id'), $this->session->read('Auth.User.id')
    }

    public function Cdprequests_total()
    {
        $output = $this->Cdprequests->find('all')
            ->contain(['Applicants', 'Created_by', 'States', 'Movement_types', 'Groups', 'Items'])
            ->where(['Groups.validity_id' => $this->vigencia_id])
            ->where(['Cdprequests.deleted IS NULL'])
            ->order(['Cdprequests.created' => 'ASC']);

        return $output;
    }

    public function Cdprequests_borrador()
    {
        $output = $this->Cdprequests->find('all')
            ->contain(['Applicants', 'Created_by', 'States', 'Movement_types', 'Groups', 'Items'])
            ->where(['created_by' => $this->session->read('Auth.User.id')])
            ->where(['Cdprequests.state' => 11])
            ->where(['Groups.validity_id' => $this->vigencia_id])
            ->where(['Cdprequests.deleted IS NULL'])
            ->order(['Cdprequests.created' => 'DESC']);
        return $output;
    }

    public function Cdprequests_rechazada()
    {
        $output = $this->Cdprequests->find('all')
            ->contain(['Applicants', 'Created_by', 'States', 'Movement_types', 'Groups', 'Items'])
            ->where(['created_by' => $this->session->read('Auth.User.id'), 'Cdprequests.state' => 1])
            ->where(['Groups.validity_id' => $this->vigencia_id])
            ->where(['Cdprequests.deleted IS NULL'])
            ->order(['Cdprequests.created' => 'DESC']);
        return $output;
    }

    public function Cdprequests_modificacion()
    {
        $output = $this->Cdprequests->find('all')
            ->contain(['Applicants', 'Created_by', 'States', 'Movement_types', 'Groups', 'Items'])
            ->where(['created_by' => $this->session->read('Auth.User.id'), 'Cdprequests.state' => 2])
            ->where(['Groups.validity_id' => $this->vigencia_id])
            ->where(['Cdprequests.deleted IS NULL'])
            ->order(['Cdprequests.created' => 'DESC']);
        return $output;
    }

    public function Cdprequests_aprobacion_solicitante()
    {
        $output = $this->Cdprequests->find('all')
            ->contain(['Applicants', 'Created_by', 'States', 'Movement_types', 'Groups', 'Items'])
            ->where(array('applicant_id' => $this->session->read('Auth.User.id'), 'Cdprequests.state' => 3))
            ->where(['Groups.validity_id' => $this->vigencia_id])
            ->where(['Cdprequests.deleted IS NULL'])
            ->order(['Cdprequests.created' => 'DESC']);
        return $output;
    }

    public function Cdprequests_aprobacion_jefe()
    {
        $output = $this->Cdprequests->find('all')
            ->contain(['Applicants', 'Created_by', 'States', 'Movement_types', 'Groups', 'Items'])
            ->where(array('Cdprequests.group_id IN' => $this->grupos, 'Cdprequests.state' => 4))
            ->where(['Groups.validity_id' => $this->vigencia_id])
            ->where(['Cdprequests.deleted IS NULL'])
            ->order(['Cdprequests.created' => 'DESC']);
        return $output;
    }

    public function Cdprequests_aprobacion_asesor_planeacion()
    {
        $output = $this->Cdprequests->find('all')
            ->contain(['Applicants', 'Created_by', 'States', 'Movement_types', 'Groups', 'Items'])
            ->where(array('Cdprequests.state' => 5))
            ->where(['Groups.validity_id' => $this->vigencia_id])
            ->where(['Cdprequests.deleted IS NULL'])
            ->order(['Cdprequests.created' => 'DESC']);
        return $output;
    }

    public function Cdprequests_aprobacion_asesor_compras()
    {
        $output = $this->Cdprequests->find('all')
            ->contain(['Applicants', 'Created_by', 'States', 'Movement_types', 'Groups', 'Items'])
            ->where(array('Cdprequests.state' => 6))
            ->where(['Groups.validity_id' => $this->vigencia_id])
            ->where(['Cdprequests.deleted IS NULL'])
            ->order(['Cdprequests.created' => 'DESC']);
        return $output;
    }

    public function Cdprequests_aprobacion_secretario_general()
    {
        $output = $this->Cdprequests->find('all')
            ->contain(['Applicants', 'Created_by', 'States', 'Movement_types', 'Groups', 'Items'])
            ->where(array('Cdprequests.state' => 7))
            ->where(['Groups.validity_id' => $this->vigencia_id])
            ->where(['Cdprequests.deleted IS NULL'])
            ->order(['Cdprequests.created' => 'DESC']);
        return $output;
    }

    public function Cdprequests_aprobacion_coordinador_financiera()
    {
        $output = $this->Cdprequests->find('all')
            ->contain(['Applicants', 'Created_by', 'States', 'Movement_types', 'Groups', 'Items'])
            ->where(array('Cdprequests.state' => 8))
            ->where(['Groups.validity_id' => $this->vigencia_id])
            ->where(['Cdprequests.deleted IS NULL'])
            ->order(['Cdprequests.created' => 'DESC']);
        return $output;
    }

    public function Cdprequests_gestionada()
    {
        $output = $this->Cdprequests->find('all')
            ->contain(['Applicants', 'Created_by', 'States', 'Movement_types', 'Groups', 'Items'])
            ->where(array('Cdprequests.state' => 9))
            ->where(['Groups.validity_id' => $this->vigencia_id])
            ->where(['Cdprequests.deleted IS NULL'])
            ->order(['Cdprequests.created' => 'DESC']);
        return $output;
    }

    public function Cdprequests_aplazada()
    {
        $output = $this->Cdprequests->find('all')
            ->contain(['Applicants', 'Created_by', 'States', 'Movement_types', 'Groups', 'Items'])
            ->where(array('Cdprequests.state' => 10))
            ->where(['Groups.validity_id' => $this->vigencia_id])
            ->where(['Cdprequests.deleted IS NULL'])
            ->order(['Cdprequests.created' => 'DESC']);
        return $output;
    }

    public function Cdprequests_getionada_por_mi()
    {

        $output = $this->Cdprequests->find('all')
            ->select([
                'Cdprequests__id' => 'Cdprequests.id',
                'Cdprequests__migracion_id' => 'MAX(Cdprequests.migracion_id)',
                'Cdprequests__cdp' => 'MAX(Cdprequests.cdp)',
                'Cdprequests__soprtecdp' => 'MAX(Cdprequests.soprtecdp)',
                'Cdprequests__applicant_id' => 'MAX(Cdprequests.applicant_id)',
                'Cdprequests__created_by' => 'MAX(Cdprequests.created_by)',
                'Cdprequests__group_id' => 'MAX(Cdprequests.group_id)',
                'Cdprequests__state' => 'MAX(Cdprequests.state)',
                'Cdprequests__movement_type' => 'MAX(Cdprequests.movement_type)',
                'Cdprequests__value_letter' => 'MAX(Cdprequests.value_letter)',
                'Cdprequests__value_number' => 'MAX(Cdprequests.value_number)',
                'Cdprequests__justification' => 'MAX(Cdprequests.justification)',
                'Cdprequests__object' => 'MAX(Cdprequests.object)',
                'Cdprequests__created' => 'MAX(Cdprequests.created)',
                'Cdprequests__modified' => 'MAX(Cdprequests.modified)',
                'Cdprequests__deleted' => 'MAX(Cdprequests.deleted)',
                'Timeline__id' => 'MAX(Timeline.id)',
                'Timeline__created_by' => 'MAX(Timeline.created_by)',
                'Timeline__cdpsstates_id' => 'MAX(Timeline.cdpsstates_id)',
                'Timeline__cdprequest_id' => 'MAX(Timeline.cdprequest_id)',
                'Timeline__commentary' => 'MAX(Timeline.commentary)',
                'Timeline__document' => 'MAX(Timeline.document)',
                'Timeline__signature' => 'MAX(Timeline.signature)',
                'Timeline__created' => 'MAX(Timeline.created)',
                'Timeline__modified' => 'MAX(Timeline.modified)',
                'Timeline__deleted' => 'MAX(Timeline.deleted)',
                'Applicants__id' => 'MAX(Applicants.id)',
                'Applicants__types_identification_id' => 'MAX(Applicants.types_identification_id)',
                'Applicants__identification' => 'MAX(Applicants.identification)',
                'Applicants__name' => 'MAX(Applicants.name)',
                'Applicants__email' => 'MAX(Applicants.email)',
                'Applicants__type_id' => 'MAX(Applicants.type_id)',
                'Applicants__username' => 'MAX(Applicants.username)',
                'Applicants__password' => 'MAX(Applicants.password)',
                'Applicants__active' => 'MAX(Applicants.active)',
                'Applicants__charge_id' => 'MAX(Applicants.charge_id)',
                'Applicants__privatekey' => 'MAX(Applicants.privatekey)',
                'Applicants__publickey' => 'MAX(Applicants.publickey)',
                'Applicants__document' => 'MAX(Applicants.document)',
                'Applicants__created' => 'MAX(Applicants.created)',
                'Applicants__modified' => 'MAX(Applicants.modified)',
                'Applicants__deleted' => 'MAX(Applicants.deleted)',
                'Created_by__id' => 'MAX(Created_by.id)',
                'Created_by__types_identification_id' => 'MAX(Created_by.types_identification_id)',
                'Created_by__identification' => 'MAX(Created_by.identification)',
                'Created_by__name' => 'MAX(Created_by.name)',
                'Created_by__email' => 'MAX(Created_by.email)',
                'Created_by__type_id' => 'MAX(Created_by.type_id)',
                'Created_by__username' => 'MAX(Created_by.username)',
                'Created_by__password' => 'MAX(Created_by.password)',
                'Created_by__active' => 'MAX(Created_by.active)',
                'Created_by__charge_id' => 'MAX(Created_by.charge_id)',
                'Created_by__privatekey' => 'MAX(Created_by.privatekey)',
                'Created_by__publickey' => 'MAX(Created_by.publickey)',
                'Created_by__document' => 'MAX(Created_by.document)',
                'Created_by__created' => 'MAX(Created_by.created)',
                'Created_by__modified' => 'MAX(Created_by.modified)',
                'Created_by__deleted' => 'MAX(Created_by.deleted)',
                'States__id' => 'MAX(States.id)',
                'States__name' => 'MAX(States.name)',
                'States__description' => 'MAX(States.description)',
                'States__created' => 'MAX(States.created)',
                'States__modified' => 'MAX(States.modified)',
                'Movement_types__id' => 'MAX(Movement_types.id)',
                'Movement_types__name' => 'MAX(Movement_types.name)',
                'Movement_types__description' => 'MAX(Movement_types.description)',
                'Movement_types__created' => 'MAX(Movement_types.created)',
                'Movement_types__modified' => 'MAX(Movement_types.modified)',
                'Groups__id' => 'MAX(Groups.id)',
                'Groups__name' => 'MAX(Groups.name)',
                'Groups__parent_id' => 'MAX(Groups.parent_id)',
                'Groups__immediate_boss_id' => 'MAX(Groups.immediate_boss_id)',
                'Groups__budget' => 'MAX(Groups.budget)',
                'Groups__lft' => 'MAX(Groups.lft)',
                'Groups__rght' => 'MAX(Groups.rght)',
                'Groups__created' => 'MAX(Groups.created)',
                'Groups__modified' => 'MAX(Groups.modified)',
                'Groups__deleted' => 'MAX(Groups.deleted)'
            ])
            ->contain(['Applicants', 'Created_by', 'States', 'Movement_types',  'Items', 'Groups', 'Timeline'])
            ->where(array('Timeline.created_by' => $this->session->read('Auth.User.id')))
            ->where(['Cdprequests.group_id IN' => $this->groups_id])
            ->where(['Cdprequests.deleted IS NULL'])
            ->matching('Timeline')
            ->order(['Cdprequests.created' => 'DESC'])
            ->group('Cdprequests.id');
        return $output;
    }
}
