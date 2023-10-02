<?php
namespace App\Controller;

use App\Controller\AppController;

class CdprequeststimelineController extends AppController
{
    public function index($id = NULL)
    {
       $timeline = $this->Fifa->CdpTimeline($id,FALSE);
       $this->set(compact('timeline'));
       $this->set('_serialize', ['timeline']);
    }
}
