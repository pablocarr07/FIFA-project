<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\Log\Log;
use Cake\ORM\TableRegistry;
use Cake\Network\Email\Email;

class HomeController extends AppController
 {
    public function initialize() {
        parent::initialize();
        $this->loadModel('Users');
    }
    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index() {
        //$this->Fifa->get_menu_tree();
    }

    public function login() 
    {
        $this->viewBuilder()->layout('login');
        if ($this->request->is('post')) 
        {
            $groups_id = TableRegistry::get('confdirecactivo')
            ->find()
            ->select(['ip', 'puerto'])
            ->first();
            $ip = $groups_id->ip;
            $puerto = $groups_id->puerto;
            $username = $this->request->data['username'];
            $userpass = $this->request->data['password']; 
            $ldaphost = $ip;
            $ldapport = $puerto;
            $ldaprdn = "$username@serviciodeempleo.gov.co";
            $ldappass = "$userpass";
            $baseDN="DC=serviciodeempleo,DC=gov,DC=co";
            $aut_p = 0;
            $usuario_visible = "";
            $usuario_cuenta = "";
            $grupo_array = array();
            $ldapconn = @ldap_connect($ldaphost, $ldapport);
            ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
            ldap_set_option($ldapconn, LDAP_OPT_REFERRALS, 0);
            if ($ldapconn) {
		
                $ldapbind = @ldap_bind($ldapconn, $ldaprdn, $ldappass);
                             
                if ($ldapbind) {
                    
                    $filter = '(sAMAccountName='.$username.')';
                    $attributes = array("displayname","samaccountname","memberof");
                    $result = ldap_search($ldapconn,$baseDN,$filter,$attributes);
                    $info = ldap_get_entries($ldapconn, $result);
                    
                    if ($info["count"] > 0){
                        for ($i=0; $i<$info["count"]; $i++){				
                          /*  foreach ($info[$i]["memberof"] as $key){
                                $datos = explode(",",$key);
                                foreach ($datos as $key2){
                                    if(startsWith($key2,"CN=")){
                                        $key2 = str_replace("CN=","",$key2);
                                        array_push($grupo_array,$key2);
                                    }
                                }
                            }*/
                            //Se autoriza
                            $aut_p = 1;
                            $usuario_visible = $info[$i]["displayname"][0];
                            $usuario_cuenta = $info[$i]["samaccountname"][0];
                        }
                    }			
                } else {
                    $this->Flash->error(__('Nombre de usuario o contraseña no válidos, vuelve a intentarlo.'));
                    /*$msg = "Usuario o contraseña inválidos";
                    echo $msg;*/
                }
                @ldap_close($ldapconn);
            }        
            if($aut_p == 1)
            {
                $usuariofifa =  TableRegistry::get('Conversion')
                ->find()
                ->select(['usuariofifa'])
                ->where(['usuariodirectorio' => $this->request->data['username']])
                ->first();
                $usuarioes = $usuariofifa["usuariofifa"];
                $correofifa =  TableRegistry::get('users')
                ->find()
                ->select(['email'])
                ->where(['identification' => $usuarioes])
                ->first();
                $correoes = $correofifa["email"];
                /*$codigo = rand(100, 999);
                Email::configTransport('mail', [
                  'host' => 'smtp.gmail.com', 
                  'port' => 587,
                  'tls' => true, 
                  'username' => 'repreoil@oilfilters.com.co', 
                  'password' => 'Mm12345678',
                  'className' => 'Smtp', 
                  'context' => [
                    'ssl' => [
                      'verify_peer' => false,
                      'verify_peer_name' => false,
                      'allow_self_signed' => true
                    ]
                  ]
              ]); 
              $correo = new Email(); 
              $correo
                ->transport('mail') 
                ->template('codigoveri')
                ->emailFormat('html') 
                ->to($correoes) 
                ->from('repreoil@oilfilters.com.co')
                ->subject('Su Codigo de Doble factor es '.$codigo)
                ->set('codigo', $codigo);
              if($correo->send())
              {
                echo "Correo enviado";
              }else{
                
              }   */ 
                Email::configTransport('mail1', [
                    'host' => 'smtp.gmail.com', 
                    'port' => 587,
                    'tls' => true, 
                    'username' => 'soporte.tecnologia@serviciodeempleo.gov.co', 
                    'password' => 'yazmgrusghjjmxae',
                    'className' => 'Smtp', 
                    'context' => [
                      'ssl' => [
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true
                      ]
                    ]
                ]); 
                $correo = new Email(); 
                $correo
                  ->transport('mail1') 
                  ->template('ingreso')
                  ->emailFormat('html') 
                  ->to($correoes) 
                  ->from('soporte.tecnologia@serviciodeempleo.gov.co')
                  ->subject('Ingreso a FIFA');
                if($correo->send())
                {
                //  echo "Correo enviado";
                }else{
                 
		}    
                $this->request->data['username'] = $usuarioes;
                $this->request->data['password'] = "JS20071978ra";
                $user = $this->Auth->identify();
                if ($user) {
                   //Obtener última vigencia y guardarla en cookies
                    $cookie_vigencia_fifa = $tareasXDependencia = TableRegistry::get('Validities')
                    ->find()
                    ->select(['id', 'name'])
                    ->order([
                        'name' => 'DESC'
                    ])
                    ->first();
                    $this->request->session()->write('cookie_vigencia_fifa', $cookie_vigencia_fifa);
                    $this->Auth->setUser($user);
                    return $this->redirect($this->Auth->redirectUrl());
                }
            }
        }
    }
    public function logout() {
        return $this->redirect($this->Auth->logout());
    }

     public function profile() {

      $groups_id = TableRegistry::get('modclave')
      ->find()
      ->select(['pagina'])
      ->first();
      return $this->redirect($groups_id->pagina);


     /*   $user = $this->Users->get($this->Auth->User('id'), ['contain' => ['TypesIdentification', 'Groups', 'Types', 'Charges', 'Roles']]);
        if (!empty($this->request->data)) {

            $user = $this->Users->patchEntity($user, [
                'passwordActual' => $this->request->data['passwordActual'],
                'password' => $this->request->data['password'],
                'passwordRepeat' => $this->request->data['passwordRepeat']
                    ], ['validate' => 'CahngePassword']
            );
           $datoenvio = $user["username"];
            $usuariodirec =  TableRegistry::get('Conversion')
            ->find()
            ->select(['usuariodirectorio'])
            ->where(['usuariofifa' => $datoenvio])
            ->first();
            $usuariodirectorio = $usuariodirec["usuariodirectorio"];
          $oldPassword =  $this->request->data['passwordActual'];
          $newPassword = $this->request->data['password'];
          $newPasswordCnf = $this->request->data['passwordRepeat'];
          $username = $usuariodirectorio;
          $usuario = "$username@serviciodeempleo.gov.co";
          $server = "172.16.2.100";
          $ldapport = 389;
          $dn ="DC=serviciodeempleo,DC=gov,DC=co";
          $userid = $usuario;
          $user5 = "uid=". $usuario. ",". $dn;
          error_reporting(0);
          ldap_connect($server, $ldapport);
          $con = ldap_connect($server, $ldapport);
          ldap_set_option($con, LDAP_OPT_PROTOCOL_VERSION, 3);
          ldap_set_option($con, LDAP_OPT_REFERRALS, 0);
          $sr = ldap_search($con,$dn,"(|(uid=$usuario)(mail=$usuario))");
          $user_entry = ldap_first_entry($con, $sr);
          $user_dn = ldap_get_dn($con, $user_entry);
          $records = ldap_get_entries($con, $sr);
          $esta = 0;
          if (ldap_bind($con, $usuario, $oldPassword) === false) {
            $this->Flash->success("Error E101 - Nombre de usuario o contraseña actual es incorrecto");
            $esta = 1;
          }
          else
          {
           // $this->Flash->success("Error E101 - Nombre de usuario o contraseña actual es correcto");
          }          
          if ($newPassword != $newPasswordCnf ) {
            $this->Flash->success("Error E102 - ¡Sus nuevas contraseñas no coinciden! ");
            $esta = 1;
          }
          if (strlen($newPassword) < 8 ) {
            $this->Flash->success("Error E103 - ¡Su nueva contraseña es demasiado corta! ");
            $esta = 1;
          }
          if (! preg_match("/[0-9]/",$newPassword)) {
            $this->Flash->success("Error E104 - Su nueva contraseña debe contener al menos un dígito. ");
            $esta = 1;
          }
          if (! preg_match("/[a-zA-Z]/",$newPassword)) 
          {
            $this->Flash->success("Error E105 - Su nueva contraseña debe contener al menos una letra. ");
            $esta = 1;
          }
          if (! preg_match("/[A-Z]/",$newPassword)) 
          {
            $this->Flash->success("Error E106 - Su nueva contraseña debe contener al menos una letra mayúscula. ");
            $esta = 1;
          }
          if (! preg_match("/[a-z]/",$newPassword)) 
          {
            $this->Flash->success("Error E107 - Su nueva contraseña debe contener al menos una letra minúscula. ");
            $esta = 1;
        }
        if (!$records) {
        //  $this->Flash->success("Error E200 - No se puede conectar al servidor, no puede cambiar su contraseña en este momento, lo sentimos");
        }
        if($esta == 0)
        {
          $entry =array();
          $entry["userPassword"] = "{SHA}" . base64_encode( pack( "H*", sha1( $newPasswordCnf ) ) );
          if (ldap_modify($con,$user_dn,$entry) === false)
          {
            $error = ldap_error($con);
            $errno = ldap_errno($con);
            $this->Flash->success("E201 - Su contraseña no se puede cambiar, póngase en contacto con el administrador.  ".$errno);
          } 
          else 
          {
            $this->Flash->success(" Su contraseña ha sido cambiada. ");
          }
        }
      }
      $this->set('user', $user);*/
    }

	public function exportExcel() {
		header('Content-type: application/ms-excel');
		header('Content-Disposition: attachment; filename='.$this->request->data['filename']);

		echo utf8_decode($this->request->data['data']);
		exit;
	}

}
