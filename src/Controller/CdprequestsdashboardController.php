<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use Cake\Log\Log;

/**
 * Cdprequests Controller
 *
 * @property \App\Model\Table\CdprequestsTable $Cdprequests
 */
class CdprequestsdashboardController extends AppController {

    public function initialize() {
        parent::initialize();
        $this->loadModel('Cdprequests');

        $cookie_vigencia_fifa = Router::getRequest()->session()->read('cookie_vigencia_fifa');

        $user_group = TableRegistry::get('GroupsUsers')->find()
        ->where(['user_id' => $this->AuthUser->user('id')])
        ->where(['validity_id' => $cookie_vigencia_fifa->id ])
        ->where(['deleted is null'])
        ->first()
        ;

        $usergroup_id = 0;
        if($user_group){
          $usergroup_id = $user_group->group_id;
        }

        $this->grupos = array_keys($this->Fifa->getImmediateBossGroups($usergroup_id, $this->Auth->user('id')));
        //$roles_user = array_keys($this->Auth->user('roles'));
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index() {
      //borrador.....
      //$cdprequests = $this->CdprequestsDashboard();
      $cdprequests = $this->Fifa->CdprequestsDashboard();
      //print_r($cdprequests);die();
      $this->set(compact('cdprequests'));
      $this->set('_serialize', ['cdprequests']);
    }

    private function CdprequestsDashboard() {
        $output = [];

        $cdprequests = $this->Cdprequests();

        $output[] = [
            'data' => $cdprequests[0],
            'url' => 'cdprequests/index/0',
            'color' => 'blue',
            'icon' => 'ion-ios-filing-outline',
            'name' => $cdprequests[0]->first()['State']['name']
        ];

        $output[] = [
            'data' => $cdprequests[1],
            'url' => 'cdprequests/index/1',
            'color' => 'red',
            'icon' => 'ion-ios-filing-outline',
            'name' => $cdprequests[1]->first()['State']['name']
        ];

        $output[] = [
            'data' => $cdprequests[2],
            'url' => 'cdprequests/index/2',
            'color' => 'aqua',
            'icon' => 'ion-ios-filing-outline',
            'name' => $cdprequests[2]->first()['State']['name']
        ];

        $output[] = [
            'data' => $cdprequests[3],
            'url' => 'cdpapproves/index/3',
            'color' => 'yellow-active',
            'icon' => 'ion-ios-filing-outline',
            'name' => $cdprequests[3]->first()['State']['name']
        ];

        $output[] = [
            'data' => $cdprequests[4],
            'url' => 'Cdpapprovesimmediateboss',
            'color' => 'light-blue',
            'icon' => 'ion-ios-filing-outline',
            'name' => $cdprequests[4]->first()['State']['name']
        ];

        if (isset($cdprequests[5])) {
            $output[] = [
                'data' => $cdprequests[5],
                'url' => 'Cdpapprovesplanningconsultant',
                'color' => 'teal',
                'icon' => 'ion-ios-filing-outline',
                'name' => $cdprequests[5]->first()['State']['name']
            ];
        }
        if (isset($cdprequests[6])) {
            $output[] = [
                'data' => $cdprequests[6],
                'url' => 'Cdpapprovesannualprocurementplan',
                'color' => 'teal',
                'icon' => 'ion-ios-filing-outline',
                'name' => $cdprequests[6]->first()['State']['name']
            ];
        }
        if (isset($cdprequests[7])) {
            $output[] = [
                'data' => $cdprequests[7],
                'url' => 'Cdpapprovesgeneralsecretary',
                'color' => 'aqua',
                'icon' => 'ion-ios-filing-outline',
                'name' => $cdprequests[7]->first()['State']['name']
            ];
        }
        if (isset($cdprequests[8])) {
            $output[] = [
                'data' => $cdprequests[8],
                'url' => 'cdpapprovesfinancialcoordinator/index/8',
                'color' => 'blue',
                'icon' => 'ion-ios-filing-outline',
                'name' => $cdprequests[8]->first()['State']['name']
            ];
        }
        if (isset($cdprequests[9])) {
            $output[] = [
                'data' => $cdprequests[9],
                'url' => 'cdpapprovesfinancialcoordinator/index/9',
                'color' => 'purple',
                'icon' => 'ion-ios-filing-outline',
                'name' => $cdprequests[9]->first()['State']['name']
            ];
        }
        if (isset($cdprequests[10])) {
            $output[] = [
                'data' => $cdprequests[10],
                'url' => 'cdpapprovesfinancialcoordinator/index/10',
                'color' => 'yellow',
                'icon' => 'ion-ios-filing-outline',
                'name' => $cdprequests[10]->first()['State']['name']
            ];
        }
        $output[] = [
            'data' => $cdprequests['gestionadas_por_mi'],
            'url' => 'cdpapprovesmanagedbyme',
            'color' => 'green',
            'icon' => 'ion-ios-filing-outline',
            'name' => 'Gestionadas por mi'
        ];

        return $output;
    }

    private function Cdprequests() {
        $output = [];
        $roles_user = [];
        foreach ($this->Auth->user('roles') as $roles) {            
            $roles_user[] = $roles['id'];
        }


        $output[0] = $this->Cdprequests->find('all')
                ->contain(['Applicants', 'Created_by', 'States', 'Movement_types', 'Groups', 'Items'])
                ->where(['created_by' => $this->Auth->user('id'), 'Cdprequests.state' => 0])
                ->order(['Cdprequests.created' => 'DESC']);

        $output[1] = $this->Cdprequests->find('all')
                ->contain(['Applicants', 'Created_by', 'States', 'Movement_types', 'Groups', 'Items'])
                ->where(['created_by' => $this->Auth->user('id'), 'Cdprequests.state' => 1])
                ->order(['Cdprequests.created' => 'DESC']);

        $output[2] = $this->Cdprequests->find('all')
                ->contain(['Applicants', 'Created_by', 'States', 'Movement_types', 'Groups', 'Items'])
                ->where(['created_by' => $this->Auth->user('id'), 'Cdprequests.state' => 2])
                ->order(['Cdprequests.created' => 'DESC']);

        $output[3] = $this->Cdprequests->find('all')
                ->where(array('applicant_id' => $this->Auth->user('id'), 'Cdprequests.state' => 3))
                ->contain(['Applicants', 'Created_by', 'States', 'Movement_types', 'Groups', 'Items'])
                ->order(['Cdprequests.created' => 'DESC']);

        $output[4] = $this->Cdprequests->find('all')
                ->where(array('Cdprequests.group_id IN' => $this->grupos, 'Cdprequests.state' => 4))
                ->contain(['Applicants', 'Created_by', 'States', 'Movement_types', 'Groups', 'Items'])
                ->order(['Cdprequests.created' => 'DESC']);

        if (in_array(7, $roles_user)) {
            $output[5] = $this->Cdprequests->find('all')
                    ->where(array('Cdprequests.state' => 5))
                    ->contain(['Applicants', 'Created_by', 'States', 'Movement_types', 'Groups', 'Items'])
                    ->order(['Cdprequests.created' => 'DESC']);
        }

        if (in_array(6, $roles_user)) {
            $output[6] = $this->Cdprequests->find('all')
                    ->where(array('Cdprequests.state' => 6))
                    ->contain(['Applicants', 'Created_by', 'States', 'Movement_types', 'Groups', 'Items'])
                    ->order(['Cdprequests.created' => 'DESC']);
        }

        if (in_array(3, $roles_user)) {
            $output[7] = $this->Cdprequests->find('all')
                    ->where(array('Cdprequests.state' => 7))
                    ->contain(['Applicants', 'Created_by', 'States', 'Movement_types', 'Groups', 'Items'])
                    ->order(['Cdprequests.created' => 'DESC']);
        }

        if (in_array(4, $roles_user)) {
            $output[8] = $this->Cdprequests->find('all')
                    ->where(array('Cdprequests.state' => 8))
                    ->contain(['Applicants', 'Created_by', 'States', 'Movement_types', 'Groups', 'Items'])
                    ->order(['Cdprequests.created' => 'DESC']);
        }
        if (in_array(4, $roles_user)) {
            $output[9] = $this->Cdprequests->find('all')
                    ->where(array('Cdprequests.state' => 9))
                    ->contain(['Applicants', 'Created_by', 'States', 'Movement_types', 'Groups', 'Items'])
                    ->order(['Cdprequests.created' => 'DESC']);
        }
        if (in_array(4, $roles_user)) {
            $output[10] = $this->Cdprequests->find('all')
                    ->where(array('Cdprequests.state' => 10))
                    ->contain(['Applicants', 'Created_by', 'States', 'Movement_types', 'Groups', 'Items'])
                    ->order(['Cdprequests.created' => 'DESC']);
        }

        $output['gestionadas_por_mi'] = $this->Cdprequests->find('all')
                ->contain(['Applicants', 'Created_by', 'States', 'Movement_types', 'Groups', 'Items', 'Timeline'])
                ->where(array('Timeline.created_by' => $this->Auth->user('id')))
                ->matching('Timeline')
                ->order(['Cdprequests.created' => 'DESC'])
                ->group('Cdprequests.id');
        return $output;
    }

}
