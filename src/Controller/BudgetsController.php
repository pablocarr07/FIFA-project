<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Budgets Controller
 *
 * @property \App\Model\Table\BudgetsTable $Budgets
 */
class BudgetsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
	    $budgets = $this->Fifa->budgets();
      $this->set(compact('budgets'));
    }

}
