<?php

namespace Fifa;

use Cake\Mailer\Email;

Class FifaEmail {

    public function __construct() {
        
    }

    /* class email */

    public function send($subject, $email, $template, $viewvars = FALSE) {

        $config = new Email('gmail');
        if ($viewvars) {
            $config->viewVars($viewvars);
        }
        if(!empty($viewvars['attachments'])){
            $config->attachments($viewvars['attachments']);
        }
        
        $config->template($template)
                ->emailFormat('html')
                ->from(['fifa@serviciodeempleo.gov.co' => 'Notificaciones FIFA'])
                ->to($email)
                ->subject($subject)
                ->send();
    }

}
