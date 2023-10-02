<?php

namespace Fifa;

use Cake\Controller\Component;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;
use Cake\Routing\Router;
use Cake\Log\Log;

class LogicFifa
{

  //private $email = "";

  public function __construct()
  {

    $this->Loads = TableRegistry::get('Loads');
    $this->Groups = TableRegistry::get('Groups');
    $this->Users = TableRegistry::get('Users');
    $this->Menus = TableRegistry::get('Menus');
    $this->Validities = TableRegistry::get('Validities');
    $this->Compromisos = TableRegistry::get('Compromisos');
    $this->Cdprequestsitemstasks = TableRegistry::get('CdprequestsItemsTasks');


    $this->Cdps = TableRegistry::get('Cdps');
    // $this->cdpRequestsModel = TableRegistry::get('Cdprequests');
    $this->CdprequestsItems = TableRegistry::get('CdprequestsItems');

    $this->cdpnotifications = new CdpNotifications();
    $this->cdpautorizacion = new CdpAutorizacion();
    $this->timeline = new CdpTimeline();
    $this->signature = new Signature();
    $this->cdprules = new CdpRules();
    $this->cdprequestsDashboard = new CdprequestsDashboard();


    Configure::load('fifa', 'default');
    $this->tipo_documento_soporte = Configure::read('tipoDocumentoSoporte');
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
        'item.item',
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
      $itemItem = json_decode($cdpRequestItem)->item->item;
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
          'item' => $itemItem,
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

  public function usersGrouop($usergroup_id)
  {
    //gupos asociados al usuarios
    //$usergroup_id=9;
    $groupUsers = $this->Groups->getGroupUsers($usergroup_id);
    $users[0] = NULL;
    if ($groupUsers) {
      foreach ($groupUsers as $key => $user) {
        $users[$key] = $user['identification'];
      }
    }
    return $users;
  }

  public function cdpsxComprometer($usergroup_id)
  {
    //id de ultimo load de archivo
    $lastLoad = $this->Loads->getLastId();

    $users = $this->getUsersGroups($usergroup_id);

    $cdp_compromiso = [];
    if ($users['encontroUsers']) {

      $cdp_compromiso = $this->Compromisos->find('all')
        ->select(['cdp', 'rubro'])
        //->where(['Compromisos.estado != ' => 'Anulado','identificacion IN' => $users])
        ->where(['identificacion IN' => $users['identificacionsuser'], 'load_id' => $lastLoad])
        //->group('cdp')->toArray();
        ->toArray();
    }

    $cdps[0] = NULL;
    $rubros[0] = NULL;

    foreach ($cdp_compromiso as $key => $data) {
      $cdps[$key] = $data->cdp;
      $rubros[$key] = $data->rubro;
    }

    $cdps = array_unique($cdps);
    $rubros = array_unique($rubros);
    $query = $this->Cdps->find('all')->where(['numero_documento IN' => $cdps, 'rubro IN' => $rubros, 'load_id' => $lastLoad]);
    return $query;
  }

  public function asiVaSuGastoGeneral($usergroup_id, $concepts)
  {

    //id de ultimo load de archivo
    $lastLoad = $this->Loads->getLastId();

    $users = $this->getUsersGroups($usergroup_id);

    $output = [];
    $documentos_soporte = [];

    foreach ($concepts as $concept) {
      if (array_key_exists($concept, $this->tipo_documento_soporte)) {
        $documentos_soporte[$concept] = $this->tipo_documento_soporte[$concept];
      }
    }

    if ($users['identificacionsuser']) {

      foreach ($documentos_soporte as $key => $documento_soporte) {
        $query = $this->Compromisos->find('all');
        $query->select(['totalRp' => 'sum(valor_actual)', 'totalPagado' => '(sum(valor_actual)-sum(saldo_por_utilizar))'])
          ->where(['Compromisos.estado != ' => 'Anulado', 'identificacion IN' => $users['identificacionsuser'], 'load_id' => $lastLoad, 'tipo_documento_soporte IN' => $documento_soporte])
          ->toArray();

        foreach ($query as $data) {
          $output[$key]['totalRp'] = $data->totalRp;
          $output[$key]['totalPagado'] = $data->totalPagado;
        }
      }
    }

    //ordenar por key de array;
    $key = array_keys($output);
    asort($key);
    $out = [];
    foreach ($key as $data) {
      $out[$data] = $output[$data];
    }

    return $out;
  }

  public function asiVaSuGastoDetallado($usergroup_id, $concepts)
  {

    $documento = [];
    foreach ($concepts as $data) {
      $documento = array_merge($this->tipo_documento_soporte[$data], $documento);
    }

    $lastLoad = $this->Loads->getLastId();
    //$users = $this->usersGrouop($usergroup_id);
    $users = $this->getUsersGroups($usergroup_id);

    $output = [];
    if ($users['identificacionsuser']) {
      $query = $this->Compromisos->find('all');
      //$query->from(['Cdps cd,Compromisos cm'])
      $query->from(['compromisos cm'])
        ->select([
          'tercero' => 'u.name',
          'fecha' => 'cm.fecha_de_registro',
          'rubro_descripcion' => 'cm.descripcion',
          'valorRp' => 'sum(cm.valor_actual)',
          'valorPagado' => '(sum(cm.valor_actual)-sum(cm.saldo_por_utilizar))',
          'documentoSoporte' => 'cm.tipo_documento_soporte',
          'concepto' => 'cd.objeto',
          'numero_documento' => 'cm.numero_documento',
          'documento_soporte' => 'cm.tipo_documento_soporte'
        ])
        ->where([
          'cm.estado != ' => 'Anulado',
          'cm.identificacion IN' => $users['identificacionsuser'],
          'cm.load_id' => $lastLoad,
          'cm.tipo_documento_soporte IN' => $documento,
          'cd.numero_documento = cm.cdp AND cd.rubro = cm.rubro'
        ])
        ->join([
          'table' => 'users',
          'alias' => 'u',
          'type' => 'INNER',
          'conditions' => 'u.identification = cm.identificacion',
        ])
        ->join([
          'table' => 'cdps',
          'alias' => 'cd',
          'type' => 'INNER',
          'conditions' => '(cd.numero_documento = cm.cdp and cd.rubro = cm.rubro)',
        ])
        ->order(['tercero' => 'ASC'])
        ->group(['cm.id'])
        ->toArray();

      foreach ($query as $data) {
        $concepto = "";
        foreach ($this->tipo_documento_soporte as $key => $d) {

          if (in_array(trim($data->documento_soporte), $d)) {
            $concepto = $key;
          }
        }

        $output[$concepto][] = [
          'documento_soporte' => $concepto,
          'numero_documento' => $data->numero_documento,
          'tercero' => $data->tercero,
          'fecha' => $data->fecha,
          'rubro_descripcion' => $data->rubro_descripcion,
          'valorRp' => $data->valorRp,
          'valorPagado' => $data->valorPagado,
          'concepto' => $data->concepto,
        ];
      }
    }
    //ordenar por key de array;
    $key = array_keys($output);
    asort($key);
    $out = [];
    foreach ($key as $data) {
      $out = array_merge($out, $output[$data]);
    }

    return $out;
  }

  public function comovasuPresupuesto($usergroup_id)
  {
    //ppto comprometido -> totalRp
    //ppto pagado		-> totalPagado

    $documentos = [];
    $comprometido = 0;
    $pagado = 0;
    $budget = 0;
    $pbudget = 0;
    $pcomprometido = 0;
    $ppagado = 0;

    foreach ($this->tipo_documento_soporte as $key => $documento) {
      $documentos[] = $key;
    }

    $gastos = $this->asiVaSuGastoGeneral($usergroup_id, $documentos);

    foreach ($gastos as $gasto) {
      $comprometido += $gasto['totalRp'];
      $pagado += $gasto['totalPagado'];
    }

    $budgets = $this->budgets(TRUE);

    //presupuesto
    $budget_selector = [];
    $budget = [];
    foreach ($budgets['dependencies'] as $budget) {
      if ($budget['id'] == $usergroup_id) {
        $budget_selector = $budget;
        break (1);
      }
    }

    $budget = $budget_selector;

    $pcomprometido = 0;
    $ppagado = 0;
    $presupuesto = 0;

    if ($budget) {
      if ($budget['budget'] > 0) {
        $presupuesto = $budget['budget'];
        $pcomprometido = ($comprometido * 100) / $budget['budget'];
        $ppagado = ($pagado * 100) / $budget['budget'];
      }
    }

    $pcomprometido = round($pcomprometido, 2, PHP_ROUND_HALF_ODD);
    $ppagado = round($ppagado, 2, PHP_ROUND_HALF_ODD);

    $pbudget = 100 - ($pcomprometido + $ppagado);

    return [
      'budget' => ['valor' => $presupuesto, 'porcentaje' => number_format($pbudget, 2, '.', '')],
      'comprometido' => ['valor' => $comprometido, 'porcentaje' => number_format($pcomprometido, 2, '.', '')],
      'pagado' => ['valor' => $pagado, 'porcentaje' => number_format($ppagado, 2, '.', '')]
    ];
  }

  public function budgets($lineal = TRUE, $group = FALSE)
  {

    $cookie_vigencia_fifa = Router::getRequest()->session()->read('cookie_vigencia_fifa');

    if ($group) {
      $list = $this->Groups->find('all')->where(['id' => $group, 'validity_id' => $cookie_vigencia_fifa->id])->nest('id', 'parent_id')->toArray();
    } else {
      $list = $this->Groups->find('all')->where(['validity_id' => $cookie_vigencia_fifa->id])->nest('id', 'parent_id')->toArray();
    }

    $o = ['dependencies' => [], 'budget' => 0];

    //dependencia.
    foreach ($list as $key => $d) {
      $o['dependencies'][$d->id] = ['id' => $d->id, 'name' => $d->name, 'budget' => 0, 'parent' => $d->parent_id, 'group' => []];
      //grupo.
      foreach ($d->children as $key => $f) {
        $o['dependencies'][$d->id]['group'][$f->id] = ['id' => $f->id, 'name' => $f->name, 'parent' => $f->parent_id, 'budget' => 0, 'subgrupo' => []];
        if (count($f->children)) {
          foreach ($f->children as $g) {
            //budget->subgrupo
            $o['dependencies'][$d->id]['group'][$f->id]['subgroup'][$g->id] = ['id' => $g->id, 'name' => $g->name, 'parent' => $g->parent_id, 'budget' => $g->budget];
            //budget->grupo
            $o['dependencies'][$d->id]['group'][$f->id]['budget'] += $g->budget;
            //budget->dependencia
            $o['dependencies'][$d->id]['budget'] += $g->budget;
          }
        } else {
          //budget->grupo
          $o['dependencies'][$d->id]['group'][$f->id]['budget'] += $f->budget;
          //budget->dependencia
          $o['dependencies'][$d->id]['budget'] += $f->budget;
        }
      }
      $o['budget'] += $o['dependencies'][$d->id]['budget'];
    }

    if ($lineal) {
      $r = ['dependencies' => [], 'budget' => $o['budget']];
      foreach ($o['dependencies'] as $d) {
        $r['dependencies'][] = ['id' => $d['id'], 'dependency' => $d['name'], 'group' => '', 'subgroup' => '', 'budget' => $d['budget'], 'parent' => $d['parent']];
        foreach ($d['group'] as $e) {
          $r['dependencies'][] = ['id' => $e['id'], 'dependency' => '', 'group' => $e['name'], 'subgroup' => '', 'budget' => $e['budget'], 'parent' => $e['parent']];
          if (isset($e['subgroup'])) {
            foreach ($e['subgroup'] as $f) {
              $r['dependencies'][] = ['id' => $f['id'], 'dependency' => '', 'group' => '', 'subgroup' => $f['name'], 'budget' => $f['budget'], 'parent' => $f['parent']];
            }
          }
        }
      }
      return $r;
    } else {
      return $o;
    }
  }

  public function getUsersGroups($idGroup)
  {

    $output = [];
    $idsgroup = [];
    $namesgroup = [];
    $idsuser = [];
    $namesuser = [];
    $identificacionsuser = [];

    $grupos = $this->Groups->find('all')->where(["id" => $idGroup]);

    foreach ($grupos as $grupo) {
      $user_tree_array[] = ["id" => $grupo->id, "name" => $grupo->name];
      $output = $this->getGroups($grupo->id, $user_tree_array);
    }

    foreach ($output as $data) {
      $idsgroup[] = $data['id'];
      $namesgroup[] = $data['name'];
    }

    $users = [];
    if ($idsgroup) {
      // Esto se cambió porque el usuario ya no tiene el campo group_id
      // $users = $this->Users->find('all')->where(['group_id IN' => $idsgroup])->toArray();
      // Se reemplaza por: Obtener listado de usuarios de un grupo respectivo a una vigencia
      $users = $this->Users->find('all')
        ->join([
          'table' => 'groups_users',
          'type' => 'INNER',
          'conditions' => 'Users.id=groups_users.user_id',
        ])
        ->where(['groups_users.id IN' => $idsgroup])->toArray();
    }

    $encontroUsers = false;
    foreach ($users as $user) {
      $encontroUsers = true;
      $idsuser[] = $user['id'];
      $namesuser[] = $user['name'];
      $identificacionsuser[] = $user['identification'];
    }

    return ['encontroUsers' => $encontroUsers, 'idsgroup' => $idsgroup, 'namesgroup' => $namesgroup, "idsuser" => $idsuser, "namesuser" => $namesuser, 'identificacionsuser' => $identificacionsuser];
  }

  public function getGroups($parent = 0, $user_tree_array = [])
  {

    $grupos = $this->Groups->find('all')->where(["parent_id" => $parent])->toArray();

    if (count($grupos) > 0) {
      foreach ($grupos as $data) {
        $user_tree_array[] = array("id" => $data->id, "name" => $data->name);
        $user_tree_array = $this->getGroups($data->id, $user_tree_array);
      }
    }
    return $user_tree_array;
  }

  public function getValidities()
  {

    $vigencias = $this->Validities->find('all')
      ->order([
        'name' => 'DESC'
      ])
      ->toArray();

    // if (count($vigencias) > 0) {
    //     foreach ($vigencias as $data) {
    //         $vigencias_array[] = array("id" => $data->id, "name" => $data->name);
    //     }
    // }

    return $vigencias;
  }

  public function get_menu_tree($parent = 0, $roles)
  {
    $menu = "";
    $res = $this->Menus->find('all')
      ->where(["parent_id" => $parent, 'role_id IN' => $roles, 'visible' => '1'])
      ->join([
        'table' => 'roles_menus',
        'conditions' => 'Menus.id = roles_menus.menu_id',
      ])
      ->group('Menus.id')
      ->toArray();
    if (count($res) > 0) {
      foreach ($res as $data) {
        $menuHijo = $this->get_menu_tree($data->id, $roles);
        if ($menuHijo) {
          $menu .= '<li class="dropdown">';
          $menu .= '<a href="' . $data->link . '" class="dropdown-toggle" data-toggle="dropdown">' . $data->name . ' <span class="caret"></span></a>';
          $menu .= '<ul class="dropdown-menu" role="menu">' . $menuHijo . "</ul>"; //call  recursively
          $menu .= "</li>";
        } else {
          $menu .= "<li ><a href='" . Router::url('/' . $data->link, true) . "'>" . $data->name . "</a>";
          $menu .= "</li>";
        }
      }
    }
    return $menu;
  }

  public function ImmediateBoss()
  {

    $cookie_vigencia_fifa = Router::getRequest()->session()->read('cookie_vigencia_fifa');

    $list = $this->Groups->find('all')
      ->contain([
        'ImmediateBoss',
        'Users'
      ])
      ->where([
        'validity_id' => $cookie_vigencia_fifa->id
      ])
      ->nest('id', 'parent_id')->toArray();

    $o = ['dependencies' => []];

    //dependencia.
    foreach ($list as $key => $d) {

      $users = $this->ciclo_users($d);
      $o['dependencies'][$d->id] = ['id' => $d->id, 'name' => $d->name, 'parent' => $d->parent_id, 'immediate_boss_id' => @$d->ImmediateBoss->id, 'immediate_boss_name' => @$d->ImmediateBoss->name, 'group' => [], 'personas' => $users];

      //grupo.
      foreach ($d->children as $key => $f) {

        $users = $this->ciclo_users($f);
        $o['dependencies'][$d->id]['group'][$f->id] = ['id' => $f->id, 'name' => $f->name, 'parent' => $f->parent_id, 'immediate_boss_id' => @$f->ImmediateBoss->id, 'immediate_boss_name' => @$f->ImmediateBoss->name, 'subgrupo' => [], 'personas' => $users];

        if (count($f->children)) {
          //budget->subgrupo
          foreach ($f->children as $g) {
            $users = $this->ciclo_users($g);
            $o['dependencies'][$d->id]['group'][$f->id]['subgroup'][$g->id] = ['id' => $g->id, 'name' => $g->name, 'parent' => $g->parent_id, 'immediate_boss_id' => @$g->ImmediateBoss->id, 'immediate_boss_name' => @$g->ImmediateBoss->name, 'personas' => $users];
          }
        }
      }
    }

    $r = ['dependencies' => []];
    foreach ($o['dependencies'] as $d) {
      $r['dependencies'][] = ['id' => $d['id'], 'dependency' => $d['name'], 'group' => '', 'subgroup' => '', 'parent' => $d['parent'], 'immediate_boss_id' => $d['immediate_boss_id'], 'immediate_boss_name' => $d['immediate_boss_name'], 'personas' => $d['personas']];
      foreach ($d['group'] as $e) {
        $r['dependencies'][] = ['id' => $e['id'], 'dependency' => '', 'group' => $e['name'], 'subgroup' => '', 'parent' => $e['parent'], 'immediate_boss_id' => $e['immediate_boss_id'], 'immediate_boss_name' => $e['immediate_boss_name'], 'personas' => $e['personas']];
        if (isset($e['subgroup'])) {
          foreach ($e['subgroup'] as $f) {
            $r['dependencies'][] = ['id' => $f['id'], 'dependency' => '', 'group' => '', 'subgroup' => $f['name'], 'parent' => $f['parent'], 'immediate_boss_id' => $f['immediate_boss_id'], 'immediate_boss_name' => $f['immediate_boss_name'], 'personas' => $f['personas']];
          }
        }
      }
    }

    return $r;
  }

  private function ciclo_users($datos)
  {
    $output = [];
    if (!empty($datos->users)) {
      foreach ($datos->users as $d) {
        if (in_array($d->type_id, [1, 2]))
          $output[$d->id] = $d->name;
      }
    }
    return $output;
  }

  public function getImmediateBoss($group_id)
  {

    $cookie_vigencia_fifa = Router::getRequest()->session()->read('cookie_vigencia_fifa');

    $group = $this->Groups->find('all')->where(['Groups.id' => $group_id, 'Groups.validity_id' => $cookie_vigencia_fifa->id])->contain(['ImmediateBoss'])->first();
    if ($group) {
      if ($group->immediate_boss_id) {
        return $group->immediate_boss_id;
      } else {
        return $this->getImmediateBoss($group->parent_id);
      }
    }
  }

  public function getImmediateBossGroups($group_id, $user_id)
  {

    $cookie_vigencia_fifa = Router::getRequest()->session()->read('cookie_vigencia_fifa');

    $group = $this->Groups
      ->find('all')
      ->where(
        [
          'id' => $group_id,
          'validity_id' => $cookie_vigencia_fifa->id
        ]
      )
      ->first();

    $children = [];
    if ($group) {
      $children = $this->getGroups($group_id);
      if (empty($children)) {
        // $children[] = ['id' => @$group->id, 'name' => @$group->name]; //Presentaba error se cambió por las siguientes 2 líneas
        $children = [];
        array_unshift($children, ['id' => $group->id, 'name' => $group->name]);
      } else {
        array_unshift($children, ['id' => $group->id, 'name' => $group->name]);
      }
    }

    $children_array = [];
    $output = [FALSE];
    foreach ($children as $ch) {
      $ch['immediate_boss_id'] = $this->getImmediateBoss($ch['id']);
      $children_array[$ch['id']] = $ch;
    }

    foreach ($children_array as $ch) {
      if ($ch['immediate_boss_id'] == $user_id) {
        $output[$ch['id']] = $ch;
      }
    }

    return $output;
  }

  public function CdprequestsItems($cdprequest_id, $json = FALSE)
  {
    //{"itemstypes":{"id":"1","name":"funcionamiento"},
    // "classifications":{"id":"1","name":"Gastos de Personal "},
    // "items":{"id":"3","name":"A-1-0-1-1-3 Escalafon Diplomatico"},
    // "resources":{"id":"3","name":"Recurso 13"},
    // "value":"0"}

    $output = [];

    //Obtener listado de items
    $configCdpRequestsItems = TableRegistry::config('cdprequests_items', [
      'table' => 'cdprequests_items',
      'alias' => 'cdprequests_items'
    ]);

    $itemsCdp = TableRegistry::get(
      'cdprequests_items',
      $configCdpRequestsItems
    )
      ->find()
      ->select([
        'resources.id', 'resources.name',
        'items.id', 'items.name', 'items.item',
        'items_classifications.id', 'items_classifications.name',
        'items_types.id', 'items_types.name',
        'cdprequests_items.value',
        'cdprequests_items.id'
      ])
      ->join([
        'table' => 'resources',
        'alias' => 'resources',
        'type' => 'INNER',
        'conditions' => '(resources.id=cdprequests_items.resource_id)',
      ])
      ->join([
        'table' => 'items',
        'alias' => 'items',
        'type' => 'INNER',
        'conditions' => '(items.id=cdprequests_items.item_id)',
      ])
      ->join([
        'table' => 'items_classifications',
        'alias' => 'items_classifications',
        'type' => 'INNER',
        'conditions' => '(items_classifications.id=items.item_classification_id)',
      ])
      ->join([
        'table' => 'items_types',
        'alias' => 'items_types',
        'type' => 'INNER',
        'conditions' => '(items_types.id=items_classifications.item_type_id)',
      ])
      ->where(['cdprequests_items.cdprequest_id' => $cdprequest_id]);

    foreach ($itemsCdp as $i) {

      $tasks = TableRegistry::get(
        'cdprequests_items',
        $configCdpRequestsItems
      )
        ->find()
        ->select([
          'tasks.id', 'tasks.name'
        ])->join([
          'table' => 'cdprequests_items_tasks',
          'alias' => 'cdprequests_items_tasks',
          'type' => 'LEFT',
          'conditions' => '(cdprequests_items_tasks.cdprequest_item_id = cdprequests_items.id)',
        ])->join([
          'table' => 'tasks',
          'alias' => 'tasks',
          'type' => 'LEFT',
          'conditions' => '(tasks.id = cdprequests_items_tasks.task_id)',
        ])
        ->where(['cdprequests_items.id' => $i->cdprequests_items['id']]);

      $tasks_array = [];
      foreach ($tasks as $task) {
        $tasks_array[] = ['id' => $task->tasks['id'], 'name' => $task->tasks['name']];
      }
     
      $output[] = [
        'itemstypes' => [
          'id' => $i->items_types['id'],
          'name' => $i->items_types['name']
        ],
        'classifications' => [
          'id' => $i->items_classifications['id'],
          'name' => $i->items_classifications['name']
        ],
        'items' => [
          'id' => $i->items['id'],
          'name' => $i->items['item'] . ' ' . $i->items['name']
        ],
        'resources' => [
          'id' => $i->resources['id'],
          'name' => $i->resources['name']
        ],
        'tasks' => $tasks_array,
        'cdprequests_items' => $i->id,
        'value' => $i->value
      ];
    }

    if ($json) {
      foreach ($output as $key => $o) {
        $output[$key] = json_encode($o);
      }
    }

    return $output;
  }

  public function getUserIP()
  {
    $client = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote = $_SERVER['REMOTE_ADDR'];

    if (filter_var($client, FILTER_VALIDATE_IP)) {
      $ip = $client;
    } elseif (filter_var($forward, FILTER_VALIDATE_IP)) {
      $ip = $forward;
    } else {
      $ip = $remote;
    }

    return $ip;
  }

  public function cdpRequestNotifications($entity, $table)
  {
    $this->cdpnotifications->cdpRequestNotifications($table, $entity, $this);
  }

  public function proximaAutorizacion($event, $entity, $options)
  {
    $this->cdpautorizacion->proximaAutorizacion($entity, $this);
  }

  public function cdpRequestTimeline($entity, $table)
  {
    $this->timeline->cdp($entity, $table, $this);
  }

  public function cdpTimeline($id, $json)
  {
    return $this->timeline->CdprequestsTimeline($id, $json);
  }

  public function CdprequestsDashboard()
  {
    return $this->cdprequestsDashboard->dashboard($this);
  }

  public function Cdprequests()
  {
    $p = new Cdprequests($this);
    return $p;
  }

  public function planningTasks($entity)
  {
    if (isset($entity['tasks'])) {
      $this->Cdprequestsitemstasks->deleteAll(['cdprequest_item_id in ' => $entity['tasks']['cdprequest_item_id']]);

      $entities = $this->Cdprequestsitemstasks->newEntities($entity['tasks']['items']);
      $i = $this->Cdprequestsitemstasks->saveMany($entities);
    }
  }

  public function signatureCreate($id)
  {
    $user = $this->Users->get($id);

    $document = json_encode(
      array(
        'id' => \Cake\Utility\Text::uuid(),
        'user_id' => $user->id,
        'name' => $user->name,
        'timestamp' => \Cake\I18n\Time::now(),
        'ip' => $this->getUserIP(),
        'user_agent' => $_SERVER['HTTP_USER_AGENT']
      )
    );

    $signature = $this->signature->create($document);

    $user->privatekey = $signature['privatekey'];
    $user->publickey = $signature['publickey'];
    $user->document = $document;
    $this->Users->save($user);
    $email = new FifaEmail();

    //$path = __DIR__ . '../../../signature/' . $user->identification . '.dat';
    //$path = '/var/www/html/signature/' . $user->identification . '.dat';
    $path = '/var/www/html/fifa/signature/' . $user->identification . '.dat';
    // $path = '/Applications/MAMP/htdocs/fifa-master/signature/' . $user->identification . '.dat';


    $file = new \Cake\Filesystem\File($path, true, 0644);
    $file->write($signature['signature'], 'w', false);

    $dataemail = [
      'attachments' => ['Certificado de autorización para ' . $user->name . '.dat' => $path]
    ];
    $asunto = 'Certificado de autorización para ' . $user->name;
    $email->send($asunto, $user->email, 'signaturecreate', $dataemail);
    $file->delete();
  }

  public function show_erros($errors_in)
  {

    if ($errors_in) {
      $error_msg = [];
      foreach ($errors_in as $key => $errors) {
        if (is_array($errors)) {
          foreach ($errors as $error) {
            $error_msg[] = $error;
          }
        } else {
          $error_msg[] = $errors;
        }
      }

      if (!empty($error_msg)) {
        return implode("\n \r<br>", $error_msg);
      }
    }
  }

  public function customValidationCertificate($signature)
  {
    return $this->cdprules->customValidationCertificate($signature);
  }
}
