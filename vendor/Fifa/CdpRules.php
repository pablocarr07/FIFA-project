<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Fifa;
use Cake\Network\Session;

/**
 * Description of CdpRules
 *
 * @author oscar.ruiz
 */
class CdpRules {

     public function __construct() {
        $this->session = new Session();
        $this->signature = new Signature();
    }

    public function customValidationCertificate($signature) {
        if(empty($this->session->read('Auth.User.document')) or empty($this->session->read('Auth.User.publickey')) or empty(file_get_contents($signature['tmp_name']))){
            return 'No se ha asignado certificado, si ya se le asigno certificado cierre en inicie sesión para continuar con el procesó. Si no se le ha asignado certificado contacte al administrador del sistema para asignar certificado.';
        }
        $output = $this->signature->validate($this->session->read('Auth.User.document'), file_get_contents($signature['tmp_name']), $this->session->read('Auth.User.publickey'));
        if($output){
            return TRUE;
        }else{
            return 'Certificado Invalido.';
        }
    }

}
