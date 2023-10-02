<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Network\Session;
use CsvView\View\CsvView;
use Cake\Routing\Router;
use Cake\Utility\Text;
use Cake\I18n\Time;
use Cake\Log\Log;

class ReportsController extends AppController
{

  public $usergroup_id = 0;
  public $vigencia_id = 0;
  public $vigencia_name = "";
  public $groups_id = [];

  /**
   * Index method
   *
   * @return \Cake\Network\Response|null
   */
  public function index()
  {

    $preloader = $this->preloader();

    $cdprequests = $this->paginate($preloader['query']);
    $state_id = $preloader['state_id'];

    $this->set(compact(['cdprequests', 'state_id']));
    $this->set('_serialize', ['cdprequests', 'state_id']);
  }

  /**
   * View method
   *
   * @param string|null $id Cdprequest id.
   * @return \Cake\Network\Response|null
   * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
   */
  public function cdp()
  {

    $cookie_vigencia_fifa = Router::getRequest()->session()->read('cookie_vigencia_fifa');

    $preloader = $this->preloader();
    $query = $preloader['query']->where(['Cdprequests.id' => $preloader['id']]);

    if ($query->count() == 0) {
      $this->Flash->error(__('No se encontro la Solicitud de CDP ' . $preloader['id']));
      return $this->redirect(['controller' => 'Cdprequestsdashboard', 'action' => 'index']);
    }

    $cdprequest = $query->first();

    $resources = TableRegistry::get('Resources')
      ->find('list', ['limit' => 200])
      ->where(
        [
          'validity_id' => $cookie_vigencia_fifa->id
        ]
      );

    $itemsdata = $this->Fifa->obtenerDatosCdpRequestsItems($cdprequest->id);
    $applicants = TableRegistry::get('Applicants')->find('list', ['limit' => 1000]);
    $movementTypes = TableRegistry::get('Movement_types')->find('list', ['limit' => 200]);
    $itemstypes = TableRegistry::get('ItemsTypes')->find('list', ['limit' => 200]);
    $items = TableRegistry::get('Items')->find('list', ['limit' => 200]);
    $states = TableRegistry::get('States')->find('list', ['limit' => 200]);

    $this->set(compact(
      'cdprequest',
      'applicants',
      'movementTypes',
      'items',
      'itemstypes',
      'resources',
      'itemsdata',
      'states'
    ));
    $this->set('_serialize', ['cdprequest']);
  }

  private function preloader()
  {

    $cdprequests = $this->Fifa->Cdprequests();
    $state_id = '-1';
    $query = [];

    if ($state_id == '-1') { // Reporte total de CDPs
      $query = $cdprequests->Cdprequests_total();
    }

    return ['query' => $query, 'state_id' => $state_id, 'id' => $this->request->query('id')];
  }

  private function obtenerDatosRelacionadosVigencia()
  {
    $this->session = new Session();
    $cookie_vigencia_fifa = Router::getRequest()->session()->read('cookie_vigencia_fifa');

    $this->vigencia_id = $cookie_vigencia_fifa->id;
    $this->vigencia_name = $cookie_vigencia_fifa->name;

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
  }

  public function exportVerticalReportCdps0()
  {

    $this->obtenerDatosRelacionadosVigencia();

    //Obtener listado de timelines
    $config = TableRegistry::config('cdp_timeline', [
      'table' => 'Cdptimeline',
      'alias' => 'cdp_timeline'
    ]);

    $listadoTimelines = TableRegistry::get('cdp_timeline', $config)
      ->find()
      ->select([
        'cdp_timeline.cdprequest_id',
        'cdp_solicitud.cdp',
        'cdp_solicitud.object',
        'cdp_solicitud.justification',
        'grupo_solicitante.name',
        'solicitante.name',
        'cdp_solicitud.created',
        'cdp_estado.name',
        'recurso.name',
        'tipo_proyecto.name',
        'proyecto.name',
        'rubro.item',
        'rubro.name',
        'cdp_detalle.value',
        'gestor.name',
        'cdp_timeline.created',
        'gestion_estado.name',
        'cdp_timeline.commentary'
      ])
      ->join([
        'table' => 'cdpsstates',
        'alias' => 'gestion_estado',
        'type' => 'INNER',
        'conditions' => 'cdp_timeline.cdpsstates_id = gestion_estado.id',
      ])
      ->join([
        'table' => 'cdprequests',
        'alias' => 'cdp_solicitud',
        'type' => 'INNER',
        'conditions' => 'cdp_timeline.cdprequest_id = cdp_solicitud.id',
      ])
      ->join([
        'table' => 'cdpsstates',
        'alias' => 'cdp_estado',
        'type' => 'INNER',
        'conditions' => 'cdp_solicitud.state = cdp_estado.id',
      ])
      ->join([
        'table' => 'cdprequests_items',
        'alias' => 'cdp_detalle',
        'type' => 'INNER',
        'conditions' => 'cdp_solicitud.id = cdp_detalle.cdprequest_id',
      ])
      ->join([
        'table' => 'resources',
        'alias' => 'recurso',
        'type' => 'INNER',
        'conditions' => 'cdp_detalle.resource_id = recurso.id',
      ])
      ->join([
        'table' => 'items',
        'alias' => 'rubro',
        'type' => 'INNER',
        'conditions' => 'cdp_detalle.item_id = rubro.id',
      ])
      ->join([
        'table' => 'items_classifications',
        'alias' => 'proyecto',
        'type' => 'INNER',
        'conditions' => 'rubro.item_classification_id = proyecto.id',
      ])
      ->join([
        'table' => 'items_types',
        'alias' => 'tipo_proyecto',
        'type' => 'INNER',
        'conditions' => 'proyecto.item_type_id = tipo_proyecto.id',
      ])
      ->join([
        'table' => 'users',
        'alias' => 'solicitante',
        'type' => 'INNER',
        'conditions' => 'cdp_solicitud.created_by = solicitante.id',
      ])
      ->join([
        'table' => 'groups',
        'alias' => 'grupo_solicitante',
        'type' => 'INNER',
        'conditions' => 'cdp_solicitud.group_id = grupo_solicitante.id',
      ])
      ->join([
        'table' => 'users',
        'alias' => 'gestor',
        'type' => 'INNER',
        'conditions' => 'cdp_timeline.created_by = gestor.id',
      ])
      ->where(['grupo_solicitante.validity_id' => $this->vigencia_id])
      ->order([
        'cdp_timeline.cdprequest_id' => 'ASC',
        'cdp_timeline.created' => 'ASC'
      ])
      ->groupBy('cdp_timeline.cdprequest_id');

    $timelines = array();

    // foreach ($listadoTimelines as $timeline) {

    //   die;

    //   $codigoSolicitudFIFA = json_decode($timeline)->cdprequest_id;
    //   $numeroCDP = json_decode($timeline)->cdp_solicitud->cdp;
    //   $vigencia = $this->vigencia_name;
    //   $objeto = json_decode($timeline)->cdp_solicitud->object;
    //   $justificacion = json_decode($timeline)->cdp_solicitud->justification;
    //   $recurso = json_decode($timeline)->recurso->name;
    //   $estadoCDP = json_decode($timeline)->cdp_estado->name;
    //   $tipoProyecto = json_decode($timeline)->tipo_proyecto->name;
    //   $proyecto = json_decode($timeline)->proyecto->name;
    //   $numeroRubro = json_decode($timeline)->rubro->item;
    //   $rubro = json_decode($timeline)->rubro->name;
    //   $monto = json_decode($timeline)->cdp_detalle->value;
    //   $valorMonto = Text::tokenize($monto, '.', "'", "'");
    //   $monto = count($valorMonto) > 0 ? $valorMonto[0] : '0';
    //   $grupoSolicitante = json_decode($timeline)->grupo_solicitante->name;
    //   $solicitante = json_decode($timeline)->solicitante->name;
    //   $fechaSolicitud = json_decode($timeline)->cdp_solicitud->created;
    //   $fechaSolicitud = new Time($fechaSolicitud);
    //   $fechaSolicitud = $fechaSolicitud->i18nFormat('yyyy-MM-dd hh:mm:ss a');
    //   $comentarioGestion = json_decode($timeline)->commentary;
    //   $usuarioGestion = json_decode($timeline)->gestor->name;
    //   $estadoGestion = json_decode($timeline)->gestion_estado->name;
    //   $fechaGestion = json_decode($timeline)->created;
    //   $fechaGestion = new Time($fechaGestion);
    //   $fechaGestion = $fechaGestion->i18nFormat('yyyy-MM-dd hh:mm:ss a');

    //   $dataFormateada = [
    //     'codigoSolicitudFIFA' => $codigoSolicitudFIFA,
    //     'numeroCDP' => $numeroCDP,
    //     'vigencia' => $vigencia,
    //     'objeto' => $objeto,
    //     'justificacion' => $justificacion,
    //     'estadoCDP' => $estadoCDP,
    //     'grupoSolicitante' => $grupoSolicitante,
    //     'solicitante' => $solicitante,
    //     'fechaSolicitud' => $fechaSolicitud,
    //     'recurso' => $recurso,
    //     'tipoProyecto' => $tipoProyecto,
    //     'proyecto' => $proyecto,
    //     'numeroRubro' => $numeroRubro,
    //     'rubro' => $rubro,
    //     'monto' => $monto,
    //     'comentarioGestion' => $comentarioGestion,
    //     'usuarioGestion' => $usuarioGestion,
    //     'estadoGestion' => $estadoGestion,
    //     'fechaGestion' => $fechaGestion
    //   ];

    //   array_push($timelines, $dataFormateada);
    // }

    $_header = [
      // 'Código solicitud FIFA',
      // 'Número CDP',
      // 'Vigencia',
      // 'Objeto',
      // 'Justificación',
      // 'Estado CDP',
      // 'Grupo solicitante',
      // 'Solicitante',
      // 'Fecha solicitud',
      // 'Recurso',
      // 'Tipo proyecto',
      // 'Proyecto',
      // 'Número rubro',
      // 'Rubro',
      // 'Monto',
      // 'Observaciones de la gestión realizada',
      // 'Usuario que realiza la gestión',
      // 'Estado del CDP en la gestión',
      // 'Fecha realización de la gestión'
    ];

    // $listadoTimelines = array(
    //   []
    // );
    //new \stdClass;

    // $listadoTimelines = [
    //   [
    //     'codigoSolicitudFIFA' => '
    //     1'
    //   ]
    // ];

    $_serialize = 'listadoTimelines';
    $_delimiter = ','; //chr(9); //tab
    $_enclosure = '"';
    $_newline = '\n';
    $_dataEncoding = 'UTF-8';
    $_csvEncoding = 'UTF-8';
    $_bom = true;
    $_setSeparator = true;

    $this->viewBuilder()->className('CsvView.Csv');
    $this->set(compact(
      '_header',
      'listadoTimelines',
      '_serialize',
      '_delimiter',
      '_enclosure',
      '_newline',
      '_bom',
      '_setSeparator',
      '_dataEncoding',
      '_csvEncoding'
    ));

    $this->response->download('reporteCDPsVertical.csv');

    return;
  }

  public function exportVerticalReportCdps()
  {

    $this->obtenerDatosRelacionadosVigencia();

    //Obtener listado de timelines
    $config = TableRegistry::config('cdp_timeline', [
      'table' => 'Cdptimeline',
      'alias' => 'cdp_timeline'
    ]);

    $listadoTimelines = TableRegistry::get('cdp_timeline', $config)
      ->find()
      ->select([
        'cdp_timeline.cdprequest_id',
        'cdp_solicitud.id',
        'cdp_solicitud.migracion_id',
        'cdp_solicitud.cdp',
        'cdp_solicitud.object',
        'cdp_solicitud.justification',
        'grupo_solicitante.name',
        'solicitante.name',
        'cdp_solicitud.created',
        'cdp_estado.name',
        'recurso.name',
        'tipo_proyecto.name',
        'proyecto.name',
        'rubro.item',
        'rubro.name',
        'cdp_detalle.value',
        'gestor.name',
        'cdp_timeline.created',
        'gestion_estado.name',
        'cdp_timeline.commentary'
      ])
      ->join([
        'table' => 'cdpsstates',
        'alias' => 'gestion_estado',
        'type' => 'LEFT',
        'conditions' => 'cdp_timeline.cdpsstates_id = gestion_estado.id',
      ])
      ->join([
        'table' => 'cdprequests',
        'alias' => 'cdp_solicitud',
        'type' => 'LEFT',
        'conditions' => 'cdp_timeline.cdprequest_id = cdp_solicitud.id',
      ])
      ->join([
        'table' => 'cdpsstates',
        'alias' => 'cdp_estado',
        'type' => 'LEFT',
        'conditions' => 'cdp_solicitud.state = cdp_estado.id',
      ])
      ->join([
        'table' => 'cdprequests_items',
        'alias' => 'cdp_detalle',
        'type' => 'LEFT',
        'conditions' => 'cdp_solicitud.id = cdp_detalle.cdprequest_id',
      ])
      ->join([
        'table' => 'resources',
        'alias' => 'recurso',
        'type' => 'LEFT',
        'conditions' => 'cdp_detalle.resource_id = recurso.id',
      ])
      ->join([
        'table' => 'items',
        'alias' => 'rubro',
        'type' => 'LEFT',
        'conditions' => 'cdp_detalle.item_id = rubro.id',
      ])
      ->join([
        'table' => 'items_classifications',
        'alias' => 'proyecto',
        'type' => 'LEFT',
        'conditions' => 'rubro.item_classification_id = proyecto.id',
      ])
      ->join([
        'table' => 'items_types',
        'alias' => 'tipo_proyecto',
        'type' => 'LEFT',
        'conditions' => 'proyecto.item_type_id = tipo_proyecto.id',
      ])
      ->join([
        'table' => 'users',
        'alias' => 'solicitante',
        'type' => 'LEFT',
        'conditions' => 'cdp_solicitud.created_by = solicitante.id',
      ])
      ->join([
        'table' => 'groups',
        'alias' => 'grupo_solicitante',
        'type' => 'LEFT',
        'conditions' => 'cdp_solicitud.group_id = grupo_solicitante.id',
      ])
      ->join([
        'table' => 'users',
        'alias' => 'gestor',
        'type' => 'LEFT',
        'conditions' => 'cdp_timeline.created_by = gestor.id',
      ])
      ->where(['grupo_solicitante.validity_id' => $this->vigencia_id])
      ->where(['cdp_solicitud.deleted IS NULL'])
      ->order([
        'cdp_timeline.cdprequest_id' => 'ASC',
        'cdp_timeline.created' => 'ASC'
      ])
      // ->groupBy('cdp_solicitud.id')
    ;

    $timelines = array();
    foreach ($listadoTimelines as $timeline) {

      $codigoSolicitudFIFA = json_decode($timeline)->cdp_solicitud->migracion_id ? json_decode($timeline)->cdp_solicitud->migracion_id : json_decode($timeline)->cdp_solicitud->id;
      $numeroCDP = json_decode($timeline)->cdp_solicitud->cdp;
      $vigencia = $this->vigencia_name;
      $objeto = json_decode($timeline)->cdp_solicitud->object;
      $justificacion = json_decode($timeline)->cdp_solicitud->justification;
      $recurso = json_decode($timeline)->recurso->name;
      $estadoCDP = json_decode($timeline)->cdp_estado->name;
      $tipoProyecto = json_decode($timeline)->tipo_proyecto->name;
      $proyecto = json_decode($timeline)->proyecto->name;
      $numeroRubro = json_decode($timeline)->rubro->item;
      $rubro = json_decode($timeline)->rubro->name;
      $monto = json_decode($timeline)->cdp_detalle->value;
      $valorMonto = Text::tokenize($monto, '.', "'", "'");
      $monto = count($valorMonto) > 0 ? $valorMonto[0] : '0';
      $grupoSolicitante = json_decode($timeline)->grupo_solicitante->name;
      $solicitante = json_decode($timeline)->solicitante->name;
      $fechaSolicitud = json_decode($timeline)->cdp_solicitud->created;
      $fechaSolicitud = new Time($fechaSolicitud);
      $fechaSolicitud = $fechaSolicitud->i18nFormat('yyyy-MM-dd hh:mm:ss a');
      $comentarioGestion = json_decode($timeline)->commentary;
      $usuarioGestion = json_decode($timeline)->gestor->name;
      $estadoGestion = json_decode($timeline)->gestion_estado->name;
      $fechaGestion = json_decode($timeline)->created;
      $fechaGestion = new Time($fechaGestion);
      $fechaGestion = $fechaGestion->i18nFormat('yyyy-MM-dd hh:mm:ss a');

      $dataFormateada = [
        'codigoSolicitudFIFA' => $codigoSolicitudFIFA,
        'numeroCDP' => $numeroCDP,
        'vigencia' => $vigencia,
        'objeto' => $objeto,
        'justificacion' => $justificacion,
        'estadoCDP' => $estadoCDP,
        'grupoSolicitante' => $grupoSolicitante,
        'solicitante' => $solicitante,
        'fechaSolicitud' => $fechaSolicitud,
        'recurso' => $recurso,
        'tipoProyecto' => $tipoProyecto,
        'proyecto' => $proyecto,
        'numeroRubro' => $numeroRubro,
        'rubro' => $rubro,
        'monto' => $monto,
        'comentarioGestion' => $comentarioGestion,
        'usuarioGestion' => $usuarioGestion,
        'estadoGestion' => $estadoGestion,
        'fechaGestion' => $fechaGestion
      ];

      array_push($timelines, $dataFormateada);
    }

    $_header = [
      'Código solicitud FIFA',
      'Número CDP',
      'Vigencia',
      'Objeto',
      'Justificación',
      'Estado CDP',
      'Grupo solicitante',
      'Solicitante',
      'Fecha solicitud',
      'Recurso',
      'Tipo proyecto',
      'Proyecto',
      'Número rubro',
      'Rubro',
      'Monto',
      'Observaciones de la gestión realizada',
      'Usuario que realiza la gestión',
      'Estado del CDP en la gestión',
      'Fecha realización de la gestión'
    ];

    $_serialize = 'timelines';
    $_delimiter = ','; //chr(9); //tab
    $_enclosure = '"';
    $_newline = '\n';
    $_dataEncoding = 'UTF-8';
    $_csvEncoding = 'UTF-8';
    // $_bom = true;
    // $_setSeparator = true;

    $this->viewBuilder()->className('CsvView.Csv');
    $this->set(compact(
      '_header',
      'timelines',
      '_serialize',
      '_delimiter',
      '_enclosure',
      '_newline',
      '_bom',
      '_setSeparator',
      '_dataEncoding',
      '_csvEncoding'
    ));

    $this->response->download('reporteCDPsVertical.csv');

    return;
  }

  public function exportHorizontalReportCdps()
  {

    $this->obtenerDatosRelacionadosVigencia();

    //Configuracion alias de cdps
    $configCDP = TableRegistry::config('cdp_solicitud', [
      'table' => 'cdprequests',
      'alias' => 'cdp_solicitud'
    ]);

    //Configuracion alias de rubros
    $configRubro = TableRegistry::config('cdp_detalle', [
      'table' => 'cdprequests_items',
      'alias' => 'cdp_detalle'
    ]);

    //Configuracion alias de timelines
    $configTimeline = TableRegistry::config('cdp_timeline', [
      'table' => 'Cdptimeline',
      'alias' => 'cdp_timeline'
    ]);

    //Obtener listado de timelines
    $listadoCDPs = TableRegistry::get('cdp_solicitud', $configCDP)
      ->find()
      ->select([
        'cdp_solicitud.id',
        'cdp_solicitud.cdp',
        'cdp_solicitud.object',
        'cdp_solicitud.justification',
        'cdp_estado.name',
        'grupo_solicitante.name',
        'solicitante.name',
        'cdp_solicitud.created',
        'cdp_estado.name'
      ])
      ->join([
        'table' => 'cdpsstates',
        'alias' => 'cdp_estado',
        'type' => 'INNER',
        'conditions' => 'cdp_solicitud.state = cdp_estado.id',
      ])
      ->join([
        'table' => 'users',
        'alias' => 'solicitante',
        'type' => 'INNER',
        'conditions' => 'cdp_solicitud.created_by = solicitante.id',
      ])
      ->join([
        'table' => 'groups',
        'alias' => 'grupo_solicitante',
        'type' => 'INNER',
        'conditions' => 'cdp_solicitud.group_id = grupo_solicitante.id',
      ])
      ->where(['grupo_solicitante.validity_id' => $this->vigencia_id])
      ->order([
        'cdp_solicitud.id' => 'ASC'
      ]);

    $cdps = array();
    foreach ($listadoCDPs as $cdp) {

      $CDPid = json_decode($cdp)->id;
      $numeroCDP = json_decode($cdp)->cdp;
      $vigencia = $this->vigencia_name;
      $objeto = json_decode($cdp)->object;
      $justificacion = json_decode($cdp)->justification;
      $estadoCDP = json_decode($cdp)->cdp_estado->name;

      $grupoSolicitante = json_decode($cdp)->grupo_solicitante->name;
      $solicitante = json_decode($cdp)->solicitante->name;
      $fechaSolicitud = json_decode($cdp)->created;
      $fechaSolicitud = new Time($fechaSolicitud);
      $fechaSolicitud = $fechaSolicitud->i18nFormat('yyyy-MM-dd hh:mm:ss a');

      // Obtener listado de rubros de determinado CDP
      $listadoRubros = TableRegistry::get('cdp_detalle', $configRubro)
        ->find()
        ->select([
          'recurso.name',
          'tipo_proyecto.name',
          'proyecto.name',
          'rubro.item',
          'rubro.name',
          'cdp_detalle.value'
        ])
        ->join([
          'table' => 'resources',
          'alias' => 'recurso',
          'type' => 'INNER',
          'conditions' => 'cdp_detalle.resource_id = recurso.id',
        ])
        ->join([
          'table' => 'items',
          'alias' => 'rubro',
          'type' => 'INNER',
          'conditions' => 'cdp_detalle.item_id = rubro.id',
        ])
        ->join([
          'table' => 'items_classifications',
          'alias' => 'proyecto',
          'type' => 'INNER',
          'conditions' => 'rubro.item_classification_id = proyecto.id',
        ])
        ->join([
          'table' => 'items_types',
          'alias' => 'tipo_proyecto',
          'type' => 'INNER',
          'conditions' => 'proyecto.item_type_id = tipo_proyecto.id',
        ])
        ->where(['cdp_detalle.cdprequest_id' => $CDPid]);

      $rubros = array();
      foreach ($listadoRubros as $rubroItem) {
        $recurso = json_decode($rubroItem)->recurso->name;
        $tipoProyecto = json_decode($rubroItem)->tipo_proyecto->name;
        $proyecto = json_decode($rubroItem)->proyecto->name;
        $numeroRubro = json_decode($rubroItem)->rubro->item;
        $rubro = json_decode($rubroItem)->rubro->name;
        $monto = json_decode($rubroItem)->value;
        $valorMonto = Text::tokenize($monto, '.', "'", "'");
        $monto = count($valorMonto) > 0 ? $valorMonto[0] : '0';

        $datosRubro = [
          'recurso' => $recurso,
          'tipoProyecto' => $tipoProyecto,
          'proyecto' => $proyecto,
          'numeroRubro' => $numeroRubro,
          'rubro' => $rubro,
          'monto' => $monto
        ];

        array_push($rubros, $datosRubro);
      }
      // die;

      // $comentarioGestion = json_decode($timeline)->commentary;
      // $usuarioGestion = json_decode($timeline)->gestor->name;
      // $estadoGestion = json_decode($timeline)->cdp_estado->name;
      // $fechaGestion = json_decode($timeline)->created;
      // $fechaGestion = new Time($fechaGestion);
      // $fechaGestion = $fechaGestion->i18nFormat('yyyy-MM-dd hh:mm:ss a');

      $datosCDP = [
        'codigoSolicitudFIFA' => $CDPid,
        'numeroCDP' => $numeroCDP,
        'vigencia' => $vigencia,
        'objeto' => $objeto,
        'justificacion' => $justificacion,
        'estadoCDP' => $estadoCDP,
        'grupoSolicitante' => $grupoSolicitante,
        'solicitante' => $solicitante,
        'fechaSolicitud' => $fechaSolicitud,
        'rubros' => json_encode($rubros),
        'hola' => '
          que más \r\n
          aaa
        '
        // 'comentarioGestion' => '', // $comentarioGestion,
        // 'usuarioGestion' => '', // $usuarioGestion,
        // 'estadoGestion' => '', // $estadoGestion,
        // 'fechaGestion' => '' // $fechaGestion
      ];

      array_push($cdps, $datosCDP);
    }

    $_header = [
      'Código solicitud FIFA',
      'Número CDP',
      'Vigencia',
      'Objeto',
      'Justificación',
      'Estado CDP',
      'Grupo solicitante',
      'Solicitante',
      'Fecha solicitud',
      'Rubros',
      'Hola'

      // Gestión
      // 'Observaciones de la gestión realizada',
      // 'Usuario que realiza la gestión',
      // 'Estado del CDP en la gestión',
      // 'Fecha realización de la gestión'
    ];

    $_serialize = 'cdps';
    $_delimiter = ','; //chr(9); //tab
    $_enclosure = '"';
    $_newline = '\n';
    $_dataEncoding = 'UTF-8';
    $_csvEncoding = 'UTF-8';
    // $_bom = true;
    // $_setSeparator = true;

    $this->viewBuilder()->className('CsvView.Csv');
    $this->set(compact(
      '_header',
      'cdps',
      '_serialize',
      '_delimiter',
      '_enclosure',
      '_newline',
      '_bom',
      '_setSeparator',
      '_dataEncoding',
      '_csvEncoding'
    ));

    $this->response->download('reporteCDPsHorizontal.csv');

    return;
  }

  public function exportReportDependencies()
  {

    $this->obtenerDatosRelacionadosVigencia();

    //Obtener listado de dependencias
    $listadoDependencias = TableRegistry::get('groups')
      ->find()
      ->select([
        'name',
        'created'
      ])
      ->where(['validity_id' => $this->vigencia_id])
      ->where(['parent_id IS NULL']);

    $dependencias = array();
    foreach ($listadoDependencias as $dependencia) {

      $nombre = json_decode($dependencia)->name;
      $fechaCreacion = json_decode($dependencia)->created;
      $fechaCreacion = new Time($fechaCreacion);
      $fechaCreacion = $fechaCreacion->i18nFormat('yyyy-MM-dd hh:mm:ss a');

      $dataFormateada = [
        'dependencia' => $nombre,
        'fechaCreacion' => $fechaCreacion
      ];

      array_push($dependencias, $dataFormateada);
    }

    $_header = [
      'Dependencia',
      'Fecha creación'
    ];

    $_serialize = 'dependencias';
    $_delimiter = ','; //chr(9); //tab
    $_enclosure = '"';
    $_newline = '\n';
    $_dataEncoding = 'UTF-8';
    $_csvEncoding = 'UTF-8';
    // $_bom = true;
    // $_setSeparator = true;

    $this->viewBuilder()->className('CsvView.Csv');
    $this->set(compact(
      '_header',
      'dependencias',
      '_serialize',
      '_delimiter',
      '_enclosure',
      '_newline',
      '_bom',
      '_setSeparator',
      '_dataEncoding',
      '_csvEncoding'
    ));

    $this->response->download('reporteDependencias.csv');

    return;
  }

  public function exportReportGroups()
  {

    $this->obtenerDatosRelacionadosVigencia();

    //Obtener listado de timelines
    $config = TableRegistry::config('subgroup', [
      'table' => 'groups',
      'alias' => 'subgroup'
    ]);

    //Obtener listado de dependencias
    $listadoGrupos = TableRegistry::get('subgroup', $config)
      ->find()
      ->select([
        'dependency.name',
        'subgroup.name',
        'subgroup.created'
      ])
      ->join([
        'table' => 'groups',
        'alias' => 'dependency',
        'type' => 'INNER',
        'conditions' => 'subgroup.parent_id = dependency.id',
      ])
      ->where(['subgroup.validity_id' => $this->vigencia_id])
      ->where(['dependency.validity_id' => $this->vigencia_id])
      ->where(['subgroup.parent_id IS NOT NULL']);

    $grupos = array();
    foreach ($listadoGrupos as $grupo) {

      $subgrupo = json_decode($grupo)->name;
      $fechaCreacion = json_decode($grupo)->created;
      $dependencia = json_decode($grupo)->dependency->name;
      $fechaCreacion = new Time($fechaCreacion);
      $fechaCreacion = $fechaCreacion->i18nFormat('yyyy-MM-dd hh:mm:ss a');

      $dataFormateada = [
        'dependencia' => $dependencia,
        'grupo' => $subgrupo,
        'fechaCreacion' => $fechaCreacion
      ];

      array_push($grupos, $dataFormateada);
    }

    $_header = [
      'Dependencia',
      'Grupo',
      'Fecha creación'
    ];

    $_serialize = 'grupos';
    $_delimiter = ','; //chr(9); //tab
    $_enclosure = '"';
    $_newline = '\n';
    $_dataEncoding = 'UTF-8';
    $_csvEncoding = 'UTF-8';
    // $_bom = true;
    // $_setSeparator = true;

    $this->viewBuilder()->className('CsvView.Csv');
    $this->set(compact(
      '_header',
      'grupos',
      '_serialize',
      '_delimiter',
      '_enclosure',
      '_newline',
      '_bom',
      '_setSeparator',
      '_dataEncoding',
      '_csvEncoding'
    ));

    $this->response->download('reporteGrupos.csv');

    return;
  }

  public function exportReportUsers()
  {

    $this->obtenerDatosRelacionadosVigencia();

    $config = TableRegistry::config('group_user', [
      'table' => 'groups_users',
      'alias' => 'group_user'
    ]);

    $listadoUsuariosXGrupo = TableRegistry::get('group_user', $config)
      ->find()
      ->select([
        'dependency.name',
        'subgroup.name',
        'third.name',
        'third.identification',
        'third.email',
        'third.active',
        'third.created'
      ])
      ->join([
        'table' => 'groups',
        'alias' => 'subgroup',
        'type' => 'INNER',
        'conditions' => 'group_user.group_id = subgroup.id',
      ])
      ->join([
        'table' => 'groups',
        'alias' => 'dependency',
        'type' => 'LEFT',
        'conditions' => 'subgroup.parent_id = dependency.id',
      ])
      ->join([
        'table' => 'users',
        'alias' => 'third',
        'type' => 'INNER',
        'conditions' => 'group_user.user_id = third.id',
      ])
      ->where(['group_user.validity_id' => $this->vigencia_id])
      ->order([
        'dependency.name',
        'subgroup.name',
        'third.identification',
        'third.name'
      ]);

    $listadoUsuarios = $listadoUsuariosXGrupo;

    $usuarios = array();
    foreach ($listadoUsuarios as $usuario) {

      $dependencia = json_decode($usuario)->dependency->name == '' ? json_decode($usuario)->subgroup->name : json_decode($usuario)->dependency->name;
      $subgrupo = json_decode($usuario)->dependency->name == '' ? '' : json_decode($usuario)->subgroup->name;
      $nombre = json_decode($usuario)->third->name;
      $identificacion = json_decode($usuario)->third->identification;
      $email = json_decode($usuario)->third->email;
      $estado = json_decode($usuario)->third->active == 1 ? 'Activo' : 'Inactivo';

      $fechaCreacion = json_decode($usuario)->third->created;
      $fechaCreacion = new Time($fechaCreacion);
      $fechaCreacion = $fechaCreacion->i18nFormat('yyyy-MM-dd hh:mm:ss a');

      $dataFormateada = [
        'dependencia' => $dependencia,
        'grupo' => $subgrupo,
        'identificacion' => $identificacion,
        'nombre' => $nombre,
        'email' => $email,
        'estado' => $estado,
        'fechaCreacion' => $fechaCreacion
      ];

      array_push($usuarios, $dataFormateada);
    }

    $_header = [
      'Dependencia',
      'Grupo',
      'Número documento',
      'Nombre',
      'Correo electrónico',
      'Estado',
      'Fecha creación'
    ];

    $_serialize = 'usuarios';
    $_delimiter = ','; //chr(9); //tab
    $_enclosure = '"';
    $_newline = '\n';
    $_dataEncoding = 'UTF-8';
    $_csvEncoding = 'UTF-8';
    // $_bom = true;
    // $_setSeparator = true;

    $this->viewBuilder()->className('CsvView.Csv');
    $this->set(compact(
      '_header',
      'usuarios',
      '_serialize',
      '_delimiter',
      '_enclosure',
      '_newline',
      '_bom',
      '_setSeparator',
      '_dataEncoding',
      '_csvEncoding'
    ));

    $this->response->download('reporteUsuarios.csv');

    return;
  }
  public function exportReportRubros()
  {
    $this->obtenerDatosRelacionadosVigencia();
    $config = TableRegistry::config('items', [
      'table' => 'items',
      'alias' => 'items'
    ]);
    $listadoUsuariosXGrupo = TableRegistry::get('items', $config)
      ->find()
      ->select([
        'items.id',
        'items_classifications.name',
        'items.name',
        'items.item',
        'items.created',
        'items.modified'
      ])
      ->join([
        'table' => 'items_classifications',
        'alias' => 'items_classifications',
        'type' => 'INNER',
        'conditions' => 'items.item_classification_id = items_classifications.id',
      ])
      ->order([
        'items.id'
      ]);
    $listadoUsuarios = $listadoUsuariosXGrupo;
    $usuarios = array();
    foreach ($listadoUsuarios as $usuario) {
      $id = json_decode($usuario)->id;
      $cuenta = json_decode($usuario)->items_classifications->name;;
      $nombre = json_decode($usuario)->name;
      $rubro = json_decode($usuario)->item;
      $fechaCreacion = json_decode($usuario)->created;
      $fechaCreacion = new Time($fechaCreacion);
      $fechaCreacion = $fechaCreacion->i18nFormat('yyyy-MM-dd hh:mm:ss a');
      $fechaModificacion = json_decode($usuario)->modified;
      $fechaModificacion = new Time($fechaModificacion);
      $fechaModificacion = $fechaModificacion->i18nFormat('yyyy-MM-dd hh:mm:ss a');
      $dataFormateada = [
        'id' => $id,
        'cuenta' => $cuenta,
        'nombre' => $nombre,
        'rubro' => $rubro,
        'fechaCreacion' => $fechaCreacion,
        'fechaModificacion' =>  $fechaModificacion
      ];
      array_push($usuarios, $dataFormateada);
    }
    $_header = [
      'Id',
      'Cuentas o Proyectos',
      'Nombre',
      'Rubro',
      'Creado',
      'Modificado'
    ];
    $_serialize = 'usuarios';
    $_delimiter = ','; //chr(9); //tab
    $_enclosure = '"';
    $_newline = '\n';
    $_dataEncoding = 'UTF-8';
    $_csvEncoding = 'UTF-8';
    // $_bom = true;
    // $_setSeparator = true;
    $this->viewBuilder()->className('CsvView.Csv');
    $this->set(compact(
      '_header',
      'usuarios',
      '_serialize',
      '_delimiter',
      '_enclosure',
      '_newline',
      '_bom',
      '_setSeparator',
      '_dataEncoding',
      '_csvEncoding'
    ));
    $this->response->download('reporteRubros.csv');
    return;
  }


  public function exportReportProyectos()
  {
    $this->obtenerDatosRelacionadosVigencia();
    $config = TableRegistry::config('items_classifications', [
      'table' => 'items_classifications',
      'alias' => 'items_classifications'
    ]);
    $listadoUsuariosXGrupo = TableRegistry::get('items_classifications', $config)
      ->find()
      ->select([
        'items_classifications.id',
        'items_classifications.name',
        'items_types.name',
        'items_classifications.created',
        'items_classifications.modified'
      ])
      ->join([
        'table' => 'items_types',
        'alias' => 'items_types',
        'type' => 'INNER',
        'conditions' => 'items_classifications.item_type_id = items_types.id',
      ])
      ->order([
        'items_classifications.id'
      ]);
    $listadoUsuarios = $listadoUsuariosXGrupo;
    $usuarios = array();
    foreach ($listadoUsuarios as $usuario) {
      $id = json_decode($usuario)->id;
      $nombre = json_decode($usuario)->name;;
      $clase = json_decode($usuario)->items_types->name;;;
      $fechaCreacion = json_decode($usuario)->created;
      $fechaCreacion = new Time($fechaCreacion);
      $fechaCreacion = $fechaCreacion->i18nFormat('yyyy-MM-dd hh:mm:ss a');
      $fechaModificacion = json_decode($usuario)->modified;
      $fechaModificacion = new Time($fechaModificacion);
      $fechaModificacion = $fechaModificacion->i18nFormat('yyyy-MM-dd hh:mm:ss a');
      $dataFormateada = [
        'id' => $id,
        'nombre' => $nombre,
        'clase' => $clase,
        'fechaCreacion' => $fechaCreacion,
        'fechaModificacion' =>  $fechaModificacion
      ];
      array_push($usuarios, $dataFormateada);
    }
    $_header = [
      'Id',
      'Nombre',
      'Clase de Gasto',
      'Creado',
      'Modificado'
    ];
    $_serialize = 'usuarios';
    $_delimiter = ','; //chr(9); //tab
    $_enclosure = '"';
    $_newline = '\n';
    $_dataEncoding = 'UTF-8';
    $_csvEncoding = 'UTF-8';
    // $_bom = true;
    // $_setSeparator = true;
    $this->viewBuilder()->className('CsvView.Csv');
    $this->set(compact(
      '_header',
      'usuarios',
      '_serialize',
      '_delimiter',
      '_enclosure',
      '_newline',
      '_bom',
      '_setSeparator',
      '_dataEncoding',
      '_csvEncoding'
    ));
    $this->response->download('reporteProyectos.csv');
    return;
  }
  public function exportReportJefes()
  {
    $this->obtenerDatosRelacionadosVigencia();
    $yearmas =  TableRegistry::get('validities')
    ->find()
    ->select(['name'])
    ->where(['name' => '2021'])
    ->first();
    $yearmas1 = $yearmas["name"];
    $idyear =  TableRegistry::get('validities')
    ->find()
    ->select(['id'])
    ->where(['name' => $yearmas1])
    ->first();
    $idyear1 = $idyear["id"];
    $config = TableRegistry::config('groups', [
      'table' => 'groups',
      'alias' => 'groups'
    ]);
    $listadoUsuariosXGrupo = TableRegistry::get('groups', $config)
      ->find()
      ->select([
        'groups.name',
        'users.name'
      ])
      ->join([
        'table' => 'users',
        'alias' => 'users',
        'type' => 'INNER',
        'conditions' => 'groups.immediate_boss_id = users.id',
      ])
      ->where(['groups.validity_id' => $idyear1]);
      //->where(['groups.validity_id' => '9']);
    $listadoUsuarios = $listadoUsuariosXGrupo;
    $usuarios = array();
    foreach ($listadoUsuarios as $usuario) {
      $dependencia = json_decode($usuario)->name;
      $nombre = json_decode($usuario)->users->name;
      $dataFormateada = [
        'Dependencia' => $dependencia,
        'Jefe Inmediato' => $nombre
      ];
      array_push($usuarios, $dataFormateada);
    }
    $_header = [
      'Dependencia',
      'Jefe Inmediato'
    ];
    $_serialize = 'usuarios';
    $_delimiter = ','; //chr(9); //tab
    $_enclosure = '"';
    $_newline = '\n';
    $_dataEncoding = 'UTF-8';
    $_csvEncoding = 'UTF-8';
    // $_bom = true;
    // $_setSeparator = true;
    $this->viewBuilder()->className('CsvView.Csv');
    $this->set(compact(
      '_header',
      'usuarios',
      '_serialize',
      '_delimiter',
      '_enclosure',
      '_newline',
      '_bom',
      '_setSeparator',
      '_dataEncoding',
      '_csvEncoding'
    ));
    $this->response->download('reporteJefesInmediatos.csv');
    return;
  }
  public function exportReportTipoGasto()
  {
    $this->obtenerDatosRelacionadosVigencia();
    $config = TableRegistry::config('items_types', [
      'table' => 'items_types',
      'alias' => 'items_types'
    ]);
    $listadoUsuariosXGrupo = TableRegistry::get('items_types', $config)
      ->find()
      ->select([
        'items_types.id',
        'items_types.name',
      ])
      ->order([
        'items_types.name'
      ]);
    $listadoUsuarios = $listadoUsuariosXGrupo;
    $usuarios = array();
    foreach ($listadoUsuarios as $usuario) {
      $id = json_decode($usuario)->id;
      $nombre = json_decode($usuario)->name;;
      $dataFormateada = [
        'id' => $id,
        'nombre' => $nombre,
      ];
      array_push($usuarios, $dataFormateada);
    }
    $_header = [
      'Id',
      'Tipo de Gasto',
    ];
    $_serialize = 'usuarios';
    $_delimiter = ','; //chr(9); //tab
    $_enclosure = '"';
    $_newline = '\n';
    $_dataEncoding = 'UTF-8';
    $_csvEncoding = 'UTF-8';
    // $_bom = true;
    // $_setSeparator = true;
    $this->viewBuilder()->className('CsvView.Csv');
    $this->set(compact(
      '_header',
      'usuarios',
      '_serialize',
      '_delimiter',
      '_enclosure',
      '_newline',
      '_bom',
      '_setSeparator',
      '_dataEncoding',
      '_csvEncoding'
    ));
    $this->response->download('reporteTipoGasto.csv');
    return;
  }
}
