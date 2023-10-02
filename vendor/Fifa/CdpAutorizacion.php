<?php

namespace Fifa;

use Cake\Log\Log;
use Cake\ORM\TableRegistry;
use Cake\Network\Session;

Class CdpAutorizacion {

    public function __construct() {
        $this->cdptimeline = TableRegistry::get('cdptimeline');
        $this->users = TableRegistry::get('users');
        $this->Groups = TableRegistry::get('Groups');
        $this->session = new Session();
        //$this->Fifa = new LogicFifa();

        $this->flujo = array(
            //estado actual => proximo estado
            //0 => 3,
            3 => 4,
            4 => 5,
            5 => 6,
            6 => 7,
            7 => 8,
            8 => 9,
            10 => 9,
            2 => 3
        );
    }

    /* class notificacion */

    public function proximaAutorizacion($entity, $todo) {
		
        if ($entity->state == 5) {
            $items = $todo->CdprequestsItems($entity->id, FALSE);
            
			//si no hay items pasa solo en crear
			if(!$items)	{
				foreach($entity->itemsdata as $data){
					 $items[]=(array)json_decode($data, true);
                }
            }
            
            if (!$this->CdpPlaneacionCompras(2, 'itemstypes', $items)) {
                $entity->state = 6;
            }
        }

		//Aprobar Solicitante.
        if ($entity->state == 3) {
            if ($entity->created_by == $entity->applicant_id) {
                $entity->state = $this->flujo[$entity->state];
                $this->proximaAutorizacion($entity, $todo);
            }
        } elseif ($entity->state == 4) {
            $proxima_firma = $this->getImmediateBossInfo($entity->group_id);
            if ($proxima_firma->id == $this->session->read('Auth.User.id')) {
                $entity->state = $this->flujo[$entity->state];				
                $this->proximaAutorizacion($entity, $todo);				
            }
        } else if ($entity->state == 5) {//Aprobar Asesor de Planeación                        
            $users = $this->proximaAutorizacionUserRoleid(7);
					
            if (in_array($this->session->read('Auth.User.id'), $users)) {
                $entity->state = $this->flujo[$entity->state];
                $this->proximaAutorizacion($entity, $todo);
            }
        } else if ($entity->state == 6) {//aprobar asesor de de compras
            $users = $this->proximaAutorizacionUserRoleid(6);

            if (in_array($this->session->read('Auth.User.id'), $users)) {
                $entity->state = $this->flujo[$entity->state];
                $this->proximaAutorizacion($entity, $todo);
            }
        } else if ($entity->state == 7) {//Aprobar Secretario General
            $users = $this->proximaAutorizacionUserRoleid(3);

            if (in_array($this->session->read('Auth.User.id'), $users)) {
                $entity->state = $this->flujo[$entity->state];
                $this->proximaAutorizacion($entity, $todo);
            }
        }
        return $entity;
    }

    public function proximaAutorizacionUserRoleemail($role_id) {
        $data = $this->proximaAutorizacionUserRole($role_id);		
        $emails = [];
        foreach ($data as $i) {
            $emails[] = $i['email'];
        }
        return $emails;
    }

    private function proximaAutorizacionUserRoleid($role_id) {
        $data = $this->proximaAutorizacionUserRole($role_id);
        $ids = [];
        foreach ($data as $i) {
            $ids[] = $i['id'];
        }
        return $ids;
    }

    private function proximaAutorizacionUserRole($role_id) {
        $usersQuery = $this->users->find('all')
                ->where([
                    'roles_users.role_id' => $role_id,
                    'roles_users.deleted IS NULL',
                    'users.active = 1'
                ])
                ->select([
                    'roles_users.role_id', 'users.id', 'users.email'
                ])
                ->join([
            'table' => 'roles_users',
            'type' => 'INNER',
            'conditions' => '(roles_users.user_id = users.id)'
        ]);

        $users = [];
        foreach ($usersQuery as $i) {
            $users[] = ['id' => $i->id, 'email' => $i->email];			
        }
        return $users;
    }

    public function usercdpautorizanemail($cdprequest_id) {
        $output = [];
        $users = $this->usercdpautorizan($cdprequest_id);
        foreach ($users as $d) {
            $output[$d['email']] = $d['email'];
        }
        return $output;
    }

    private function usercdpautorizan($cdprequest_id) { 
        $userssql = $this->cdptimeline->find('all')
                ->where(['cdprequest_id' => $cdprequest_id])
                ->group('created_by')
                ->join([
                    'table' => 'users',
                    'type' => 'INNER',
                    'conditions' => '(users.id = cdptimeline.created_by)',
                ])
                ->select([
            'users.id', 'users.email'
        ]);
        $users = [];
        foreach ($userssql as $u) {
            $users[] = ['email' => $u->users['email'], 'id' => $u->users['id']];
        }
        return $users;
    }

    public function getImmediateBossInfo($group_id) {
        $id = $this->getImmediateBoss($group_id);
        if ($id) {
            $output = $this->users->get($id);
        }
        return $output;
    }

    public function getImmediateBoss($group_id) {
        $group = $this->Groups->find('all')
        ->where(['Groups.id' => $group_id])
        ->contain(['ImmediateBoss'])->first()
        ;
        if ($group) {
            if ($group->immediate_boss_id) {
                return $group->immediate_boss_id;
            } else {
                return $this->getImmediateBoss($group->parent_id);
            }
        }
    }

    private function CdpPlaneacionCompras($value, $key, $array) {
        $items_types = array_column($array, $key);
        $types = array_column($items_types, 'id');
        //2 = inversion.
        if (in_array($value, $types)) {
            return true;
        } else {
            return false;
        }
    }

}
