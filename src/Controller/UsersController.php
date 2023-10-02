<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use Cake\I18n\Time;
use Cake\Log\Log;

/**
* Users Controller
*
* @property \App\Model\Table\UsersTable $Users
* 
*/
class UsersController extends AppController {

  /**
  * Index method
  *
  * @return \Cake\Network\Response|null
  */
  public function index() {

    $cookie_vigencia_fifa = Router::getRequest()->session()->read('cookie_vigencia_fifa');

    $this->paginate = [
      'contain' => []
    ];

    // $query = $this->Users
    // ->find('search', ['search' => $this->request->query])
    // ->contain(['TypesIdentification', 'Groups', 'Types', 'Charges'])
    // ->where([
    //   'Groups.validity_id' => $cookie_vigencia_fifa->id
    // ])
    // ;

    $query = $this->Users
    ->find('search', ['search' => $this->request->query])
    ->select([
      'id',
      'identification',
      'name',
      'email',
      'active',
      'groups.id',
      'groups.name',
      'types_identification.id',
      'types_identification.name',
      'types.id',
      'types.name',
      'user_directorio'
    ])
    ->join(
      [
        'types_identification' => [
          'table' => 'types_identification',
          'type' => 'INNER',
          'conditions' => [
            'types_identification.id = types_identification_id'
          ],
        ],
        'types' => [
          'table' => 'types',
          'type' => 'INNER',
          'conditions' => [
            'types.id = type_id'
          ],
        ],
        'groups_users' => [
          'table' => 'groups_users',
          'type' => 'LEFT',
          'conditions' => [
            'groups_users.user_id = Users.id',
            'groups_users.validity_id' => $cookie_vigencia_fifa->id,
            'groups_users.deleted is null'
          ],
        ],
        'groups' => [
          'table' => 'groups',
          'type' => 'LEFT',
          'conditions' => [
            'groups.id = groups_users.group_id',
            'groups.validity_id' => $cookie_vigencia_fifa->id
          ],
        ]
      ]
    )
    ;

    $users = $this->paginate($query);

    $this->set(compact('users'));
    $this->set('_serialize', ['users']);
  }

    /**
    * View method
    *
    * @param string|null $id User id.
    * @return \Cake\Network\Response|null
    * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
    */
    public function view($id = null) {
      $user = $this->Users->get($id, [
        'contain' => ['TypesIdentification', 'Groups', 'Types', 'Charges', 'Roles']
      ]);

      $this->set('user', $user);
      $this->set('_serialize', ['user']);
    }

    /**
    * Add method
    *
    * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
    */
    public function add() 
    {

      $cookie_vigencia_fifa = Router::getRequest()->session()->read('cookie_vigencia_fifa');
      $user = $this->Users->newEntity();

      if ($this->request->is('post')) 
      {
       /* $consultausu = TableRegistry::get('consutausu')
        ->find()
        ->select(['usuario', 'password'])
        ->first();
        $usuarioconsulta = $consultausu->usuario;
        $datoclave = $consultausu->password;*/
        $evaluaidentificacion = $this->request->data['identification'];
        $user->username = $this->request->data['identification'];
        $user->password = $datoclave;
        $conversionData = [
          'usuariodirectorio' => $this->request->data['user_directorio'],
          'usuariofifa' => $this->request->data['identification'],
        ];
        $conversion = TableRegistry::get('Conversion');
        $conversio = $conversion->newEntity();
        $conversio = $conversion->patchEntity($conversio, $conversionData);
        $groups_id = TableRegistry::get('confdirecactivo')
        ->find()
        ->select(['ip', 'puerto', 'usuario', 'password'])
        ->first();
        $ip = $groups_id->ip;
        $puerto = $groups_id->puerto;
        $usuarioconsulta = $groups_id->usuario;
        $datoclave = $groups_id->password;



        $ldaphost = $ip;
        $ldapport = $puerto;
        $ldapconn = @ldap_connect($ldaphost, $ldapport);
        ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($ldapconn, LDAP_OPT_REFERRALS, 0);
        
        if ($ldapconn) 
        {
          
          $ldapbind = @ldap_bind($ldapconn, $usuarioconsulta, $datoclave);
          if ($ldapbind) 
          {
              $username = $this->request->data['user_directorio'];
              $filter = '(sAMAccountName='.$username.')';
              $attributes = array("displayname","samaccountname","memberof");
              $baseDN="DC=serviciodeempleo,DC=gov,DC=co";
              $result = ldap_search($ldapconn,$baseDN,$filter,$attributes);
              $info = ldap_get_entries($ldapconn, $result);
              if ($info["count"] > 0)
              {
                      $conversion->save($conversio);
                      $user = $this->Users->patchEntity($user,$this->request->data);

                     /* $user->password = "JS20071978ra.";
                      $this->request->data['password'] = "JS20071978ra.";*/
                      if ($this->Users->save($user)) 
                      {

                        $groups_id1 = TableRegistry::get('users')
                        ->find()
                        ->select(['id'])
                        ->where(['identification' => $evaluaidentificacion])
                        ->first();
                        $idjs1 = $groups_id1->id;
                        $userjs1 = $this->Users->get($idjs1, ['contain' => ['TypesIdentification', 'Groups', 'Types', 'Charges']]);
                        $userjs1 = $this->Users->patchEntity($userjs1, [
                          'password' => "JS20071978ra",
                          'passwordRepeat' => "JS20071978ra"
                        ], ['validate' => 'password']
                        );
                        $this->Users->save($userjs1);
                        $this->Flash->success(__('El usuario ha sido guardado.'));
                        if(trim($this->request->data['group_id']) != '')
                        {
                          $requestData = [
                            'user_id' => $user->id,
                            'group_id' => $this->request->data['group_id'],
                            'validity_id' => $cookie_vigencia_fifa->id
                          ];
                          $groups_users = TableRegistry::get('GroupsUsers');
                          $group_user = $groups_users->newEntity();
                          $group_user = $groups_users->patchEntity($group_user, $requestData);
                          $groups_users->save($group_user);
                        }
                        //crear firma.
                        //$this->signatureCreate($user->id);
                        return $this->redirect(['action' => 'index']);
                      } 
                      else 
                      {
                        $this->Flash->error(__('No se pudo guardar el usuario. Por favor, inténtelo de nuevo.'));
                      }
              }
              else
              {
                $this->Flash->error(__('El Usuario No se Puede Guardar por que no Existe En el Directorio Activo.'));
              }
          }
          else
          {
            $this->Flash->error(__('Error no se conecto.'));
          }
        }
         // $this->Flash->success(__($usuarioBuscar));
         /* $path = "logs/error.log";
          error_log($usuarioBuscar, 3, $path);*/
        }
        $groups = $this->Users->Groups
        ->find('list', ['limit' => 200])
        ->where([
          'validity_id' => $cookie_vigencia_fifa->id
        ])
        ;
        $typesIdentification = $this->Users->TypesIdentification->find('list', ['limit' => 200]);
        $types = $this->Users->Types->find('list', ['limit' => 200]);
        $charges = $this->Users->Charges->find('list', ['limit' => 200]);
        $roles = $this->Users->Roles->find('list', ['limit' => 200]);
        $this->set(compact('user', 'typesIdentification', 'groups', 'types', 'charges', 'roles'));
        $this->set('_serialize', ['user']);
    }

    /**
    * Edit method
    *
    * @param string|null $id User id.
    * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
    * @throws \Cake\Network\Exception\NotFoundException When record not found.
    */
    public function edit($id = null) 
    {
      $cookie_vigencia_fifa = Router::getRequest()->session()->read('cookie_vigencia_fifa');
      $user = $this->Users->get($id, [
        'contain' => [
          'Roles'
        ]
      ]);
      // Buscar el grupo relacionado con el usuario
      $user_group = TableRegistry::get('GroupsUsers')->find()
      ->where(['user_id' => $id])
      ->where(['validity_id' => $cookie_vigencia_fifa->id ])
      ->where(['deleted is null'])
      ->first()
      ;
      if ($this->request->is(['patch', 'post', 'put'])) 
      {
       /* $consultausu = TableRegistry::get('consutausu')
        ->find()
        ->select(['usuario', 'password'])
        ->first();
        $usuarioconsulta = $consultausu->usuario;
        $datoclave = $consultausu->password;*/
        $groups_id = TableRegistry::get('confdirecactivo')
        ->find()
        ->select(['ip', 'puerto', 'usuario', 'password'])
        ->first();
        $ip = $groups_id->ip;
        $puerto = $groups_id->puerto;
        $usuarioconsulta = $groups_id->usuario;
        $datoclave = $groups_id->password;

        $ldaphost = $ip;
        $ldapport = $puerto;
        $ldapconn = @ldap_connect($ldaphost, $ldapport);
        ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($ldapconn, LDAP_OPT_REFERRALS, 0);
        if ($ldapconn) 
        {
          $ldapbind = @ldap_bind($ldapconn, $usuarioconsulta, $datoclave);
          if ($ldapbind) 
          {
              $username = $this->request->data['user_directorio'];
              $filter = '(sAMAccountName='.$username.')';
              $attributes = array("displayname","samaccountname","memberof");
              $baseDN="DC=serviciodeempleo,DC=gov,DC=co";
              $result = ldap_search($ldapconn,$baseDN,$filter,$attributes);
              $info = ldap_get_entries($ldapconn, $result);
              if ($info["count"] > 0)
              {
                $usuariofifa =  TableRegistry::get('users')
                ->find()
                ->select(['username'])
                ->where(['id' => $id])
                ->first();
                $usuarioes = $usuariofifa["username"];  
                $usuariofifa11 =  TableRegistry::get('Conversion')
                ->find()
                ->select(['usuariodirectorio'])
                ->where(['usuariofifa' => $usuarioes])
                ->first();
                $usuarioes11 =  $usuariofifa11["usuariodirectorio"];
                try
                {
                    $usuariofifa11 =  TableRegistry::get('Conversion')
                    ->find()
                    ->select(['usuariodirectorio'])
                    ->where(['usuariofifa' => $usuarioes])
                    ->first();
                    $usuarioes11 =  $usuariofifa11["usuariodirectorio"];
                    if(is_null($usuarioes11))
                    {
                      
                    }
                    else
                    {
                        $conversionusu_table = TableRegistry::get('Conversion');
                        $conversionusu = $conversionusu_table->get($usuarioes11);
                        $conversionusu_table->delete($conversionusu);
                    }
              }
              catch(Exception $e)
              {
              }    
                $conversionData = [
                  'usuariodirectorio' => $this->request->data['user_directorio'],
                  'usuariofifa' => $this->request->data['identification'],
                ];
                $conversion = TableRegistry::get('Conversion');
                $conversio = $conversion->newEntity();
                $conversio = $conversion->patchEntity($conversio, $conversionData);
                $conversion->save($conversio);
                $user->username = $this->request->data['identification'];
                $user = $this->Users->patchEntity($user, $this->request->data);
                if ($this->Users->save($user)) 
                {
                  $this->Flash->success(__( 'El usuario ha sido guardado.'));
                  $requestData = [
                    'user_id' => $user->id,
                    'group_id' => $this->request->data['group_id'],
                    'validity_id' => $cookie_vigencia_fifa->id
                  ];
                  $groups_users = TableRegistry::get('GroupsUsers');
                  if(trim($this->request->data['group_id']) != '')
                  {
                    if (!count($user_group)) 
                    {
                      $group_user = $groups_users->newEntity();
                      $group_user = $groups_users->patchEntity($group_user, $requestData);
                      $groups_users->save($group_user);
                    } else 
                    {
                      $user_group = $groups_users->patchEntity($user_group, $requestData);
                      $groups_users->save($user_group);
                    }
                  } 
                  else 
                  {
                    if (count($user_group)) 
                    {
                      $groups_users->delete($user_group);
                    }
                  }
                  return $this->redirect(['action' => 'index']);
                } 
                else 
                {
                  $this->Flash->error(__('No se pudo guardar el usuario. Por favor, inténtelo de nuevo.'));
                }
              }
              else
              {
                $this->Flash->error(__('El Usuario de Directorio Activo No Existe.'));
              }
            }
          }
      }
      $groups = $this->Users->Groups
      ->find('list', ['limit' => 200])
      ->where([
        'validity_id' => $cookie_vigencia_fifa->id
      ]);
      $user['group_id'] = $user_group->group_id;
      $typesIdentification = $this->Users->TypesIdentification->find('list', ['limit' => 200]);
      $types = $this->Users->Types->find('list', ['limit' => 200]);
      $charges = $this->Users->Charges->find('list', ['limit' => 200]);
      $roles = $this->Users->Roles->find('list', ['limit' => 200]);
      $this->set(compact('user', 'user_group', 'typesIdentification', 'groups', 'types', 'charges', 'roles'));
      $this->set('_serialize', ['user']);
    }

    /**
    * Delete method
    *
    * @param string|null $id User id.
    * @return \Cake\Network\Response|null Redirects to index.
    * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
    */
    public function delete($id = null) {
      $this->request->allowMethod(['post', 'delete']);


      $usuariofifa =  TableRegistry::get('users')
      ->find()
      ->select(['username'])
      ->where(['id' => $id])
      ->first();
      $usuarioes = $usuariofifa["username"];  

      $user = $this->Users->get($id);
      if ($this->Users->delete($user)) 
      {
        try
        {
          $usuariofifa11 =  TableRegistry::get('Conversion')
          ->find()
          ->select(['usuariodirectorio'])
          ->where(['usuariofifa' => $usuarioes])
          ->first();
          $usuarioes11 =  $usuariofifa11["usuariodirectorio"];
          if(is_null($usuarioes11))
          {
            
          }
          else
          {
              $conversionusu_table = TableRegistry::get('Conversion');
              $conversionusu = $conversionusu_table->get($usuarioes11);
              $conversionusu_table->delete($conversionusu);
          }
        }
        catch(Exception $e)
        {
        }    
        $this->Flash->success(__('Se ha eliminado el usuario.'));
      } else {
        $this->Flash->error(__('No se pudo eliminar el usuario. Por favor, inténtelo de nuevo.'));
      }
      return $this->redirect(['action' => 'index']);
    }

    public function changePassword($id = null) {
      $user = $this->Users->get($id, ['contain' => ['TypesIdentification', 'Groups', 'Types', 'Charges']]);
      if (!empty($this->request->data)) {
        $user = $this->Users->patchEntity($user, [
          'password' => $this->request->data['password'],
          'passwordRepeat' => $this->request->data['passwordRepeat']
        ], ['validate' => 'password']
      );
      if ($this->Users->save($user)) {
        $this->Flash->success(__('La contraseña se ha cambiado correctamente.'));
        $this->redirect(['action' => 'index']);
      } else {
        $this->Flash->error(__('No se pudo guardar el usuario. Por favor, inténtelo de nuevo.'));
      }
    }
    $this->set('user', $user);
  }

  public function signatureCreate($id) {
    if ($this->request->is(['patch', 'post', 'put'])) {
      $this->Fifa->signatureCreate($id);
      $this->Flash->success(__('El certificado se ha generado y enviado.'));
      $this->redirect(['action' => 'index']);
    } else {
      $user = $this->Users->get($id, ['contain' => ['TypesIdentification', 'Groups', 'Types', 'Charges']]);
      $this->set('user', $user);
    }
  }
}
