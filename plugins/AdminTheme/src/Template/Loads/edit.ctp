<div class="actions columns col-lg-2 col-md-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="nav nav-stacked nav-pills">
        <li class="active disabled"><?= $this->Html->link(__('Edit Load'), ['action' => 'edit', $load->id]) ?> </li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $load->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $load->id), 'class' => 'btn-danger']
            )
        ?></li>
        <li><?= $this->Html->link(__('New Load'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Loads'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Cdps'), ['controller' => 'Cdps', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Cdp'), ['controller' => 'Cdps', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Cdps Tmp'), ['controller' => 'CdpsTmp', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Cdps Tmp'), ['controller' => 'CdpsTmp', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Compromisos'), ['controller' => 'Compromisos', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Compromiso'), ['controller' => 'Compromisos', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Compromisos Tmp'), ['controller' => 'CompromisosTmp', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Compromisos Tmp'), ['controller' => 'CompromisosTmp', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="loads form col-lg-10 col-md-9 columns">
    <?= $this->Form->create($load); ?>
    <fieldset>
        <legend><?= __('Edit Load') ?></legend>
        <?php
            echo $this->Form->input('cdp');
            echo $this->Form->input('compromiso');
            echo $this->Form->input('support');
            echo $this->Form->input('deleted');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit'), ['class' => 'btn-success']) ?>
    <?= $this->Form->end() ?>
</div>
