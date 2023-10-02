<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Fifa;

use Cake\Network\Session;

/**
 * Description of Signature
 *
 * @author oscar.ruiz
 */
class CdprequestsDashboard {

    public function __construct() {

    }

    public function dashboard($todo) {

        $session = new Session();

        foreach ($session->read('Auth.User.roles') as $roles) {
            $roles_user[] = $roles['id'];
        }

        $cdprequests = new Cdprequests($todo);
        $output = [];

        $borrador = $cdprequests->Cdprequests_borrador();
        $output[] = [
            'data' => $borrador,
            'url' => 'cdprequests/index?state_id=0',
            'color' => 'blue',
            'icon' => 'ion-ios-filing-outline',
            'name' => $borrador->first()['State']['name']
        ];

        $rechazada = $cdprequests->Cdprequests_rechazada();
        $output[] = [
            'data' => $rechazada,
            'url' => 'cdprequests/index?state_id=1',
            'color' => 'red',
            'icon' => 'ion-ios-filing-outline',
            'name' => $rechazada->first()['State']['name']
        ];

        $modificacion = $cdprequests->Cdprequests_modificacion();
        $output[] = [
            'data' => $modificacion,
            'url' => 'cdprequests/index?state_id=2',
            'color' => 'aqua',
            'icon' => 'ion-ios-filing-outline',
            'name' => $modificacion->first()['State']['name']
        ];

        $aprobacion_solicitante = $cdprequests->Cdprequests_aprobacion_solicitante();
        $output[] = [
            'data' => $aprobacion_solicitante,
            'url' => 'cdpapproves/index',
            'color' => 'yellow-active',
            'icon' => 'ion-ios-filing-outline',
            'name' => $aprobacion_solicitante->first()['State']['name']
        ];

        $aprobacion_jefe = $cdprequests->Cdprequests_aprobacion_jefe();
        $output[] = [
            'data' => $aprobacion_jefe,
            'url' => 'Cdpapprovesimmediateboss/index',
            'color' => 'light-blue',
            'icon' => 'ion-ios-filing-outline',
            'name' => $aprobacion_jefe->first()['State']['name']
        ];

        if (in_array(7, $roles_user)) {
            $aprobacion_asesor_planeacion = $cdprequests->Cdprequests_aprobacion_asesor_planeacion();
            $output[] = [
                'data' => $aprobacion_asesor_planeacion,
                'url' => 'Cdpapprovesplanningconsultant/index',
                'color' => 'teal',
                'icon' => 'ion-ios-filing-outline',
                'name' => $aprobacion_asesor_planeacion->first()['State']['name']
            ];
        }
        if (in_array(6, $roles_user)) {
            $aprobacion_asesor_compras = $cdprequests->Cdprequests_aprobacion_asesor_compras();
            $output[] = [
                'data' => $aprobacion_asesor_compras,
                'url' => 'cdpapprovesannualprocurementplan/index',
                'color' => 'aqua',
                'icon' => 'ion-ios-filing-outline',
                'name' => $aprobacion_asesor_compras->first()['State']['name']
            ];
        }
        if (in_array(3, $roles_user)) {
            $aprobacion_secretario_general = $cdprequests->Cdprequests_aprobacion_secretario_general();
            $output[] = [
                'data' => $aprobacion_secretario_general,
                'url' => 'cdpapprovesgeneralsecretary/index',
                'color' => 'blue',
                'icon' => 'ion-ios-filing-outline',
                'name' => $aprobacion_secretario_general->first()['State']['name']
            ];
        }
        if (in_array(4, $roles_user)) {
            $aprobacion_coordinador_financiera = $cdprequests->Cdprequests_aprobacion_coordinador_financiera();
            $output[] = [
                'data' => $aprobacion_coordinador_financiera,
                'url' => 'cdpapprovesfinancialcoordinator/index?state_id=8',
                'color' => 'purple',
                'icon' => 'ion-ios-filing-outline',
                'name' => $aprobacion_coordinador_financiera->first()['State']['name']
            ];
        }
        /*
        if (in_array(4, $roles_user)) {
            $gestionada = $cdprequests->Cdprequests_gestionada();
            $output[] = [
                'data' => $gestionada,
                'url' => 'cdpapprovesfinancialcoordinator/index?state_id=9',
                'color' => 'yellow',
                'icon' => 'ion-ios-filing-outline',
                'name' => $gestionada->first()['State']['name']
            ];
        }
         * */

        if (in_array(4, $roles_user)) {
            $aplazada = $cdprequests->Cdprequests_aplazada();
            $output[] = [
                'data' => $aplazada,
                'url' => 'cdpapprovesfinancialcoordinator/index?state_id=10',
                'color' => 'blue',
                'icon' => 'ion-ios-filing-outline',
                'name' => $aplazada->first()['State']['name']
            ];
        }

        $getionada_por_mi = $cdprequests->Cdprequests_getionada_por_mi();
        $output[] = [
            'data' => $getionada_por_mi,
            'url' => 'cdprequests/index?state_id=gestionadas_por_mi',
            'color' => 'green',
            'icon' => 'ion-ios-filing-outline',
            'name' => 'Gestionadas por mi'
        ];

        return $output;
    }

}
