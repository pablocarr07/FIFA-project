<?php
namespace AuditLog\Model\Table;

use Cake\Network\Request;

trait CurrentUserTrait 
{
    public function currentUser()
    {
        $request = Request::createFromGlobals();
        $session = $request->session();
        return [
            'id' => $session->read('Auth.User.id'),
            'ip' => $request->env('REMOTE_ADDR'),
            'url' => $request->here(),
            'description' => $session->read('Auth.User.username'),
        ];
    }
}