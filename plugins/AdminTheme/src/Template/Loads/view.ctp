<div class="actions columns col-lg-2 col-md-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="nav nav-stacked nav-pills">
        <li><?= $this->Html->link(__('Edit Load'), ['action' => 'edit', $load->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Load'), ['action' => 'delete', $load->id], ['confirm' => __('Are you sure you want to delete # {0}?', $load->id), 'class' => 'btn-danger']) ?> </li>
        <li><?= $this->Html->link(__('List Loads'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Load'), ['action' => 'add']) ?> </li>
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
<div class="loads view col-lg-10 col-md-9 columns">
    <h2><?= h($load->id) ?></h2>
    <div class="row">
        <div class="col-lg-5 columns strings">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h6 class="subheader"><?= __('Id') ?></h6>
                    <p><?= h($load->id) ?></p>
                    <h6 class="subheader"><?= __('Cdp') ?></h6>
                    <p><?= h($load->cdp) ?></p>
                    <h6 class="subheader"><?= __('Compromiso') ?></h6>
                    <p><?= h($load->compromiso) ?></p>
                </div>
            </div>
        </div>
        <div class="col-lg-2 columns dates end">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h6 class="subheader"><?= __('Created') ?></h6>
                    <p><?= h($load->created) ?></p>
                    <h6 class="subheader"><?= __('Modified') ?></h6>
                    <p><?= h($load->modified) ?></p>
                    <h6 class="subheader"><?= __('Deleted') ?></h6>
                    <p><?= h($load->deleted) ?></p>
                </div>
            </div>
        </div>
        <div class="col-lg-2 columns booleans end">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h6 class="subheader"><?= __('Support') ?></h6>
                    <p><?= $load->support ? __('Yes') : __('No'); ?></p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="related row">
    <div class="column col-lg-12">
    <h4 class="subheader"><?= __('Related Cdps') ?></h4>
    <?php if (!empty($load->cdps)): ?>
    <div class="table-responsive">
        <table class="table">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Load Id') ?></th>
                <th><?= __('Numero Documento') ?></th>
                <th><?= __('Fecha De Registro') ?></th>
                <th><?= __('Fecha De Creacion') ?></th>
                <th><?= __('Tipo De Cdp') ?></th>
                <th><?= __('Estado') ?></th>
                <th><?= __('Dependencia') ?></th>
                <th><?= __('Dependencia Descripcion') ?></th>
                <th><?= __('Rubro') ?></th>
                <th><?= __('Descripcion') ?></th>
                <th><?= __('Fuente') ?></th>
                <th><?= __('Recurso') ?></th>
                <th><?= __('Sit') ?></th>
                <th><?= __('Valor Inicial') ?></th>
                <th><?= __('Valor Operaciones') ?></th>
                <th><?= __('Valor Actual') ?></th>
                <th><?= __('Saldo Comprometer') ?></th>
                <th><?= __('Objeto') ?></th>
                <th><?= __('Solicitud Cdp') ?></th>
                <th><?= __('Compromisos') ?></th>
                <th><?= __('Cuentas Por Pagar') ?></th>
                <th><?= __('Obligaciones') ?></th>
                <th><?= __('Ordenes De Pago') ?></th>
                <th><?= __('Reintegros') ?></th>
                <th><?= __('Created') ?></th>
                <th><?= __('Modified') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($load->cdps as $cdps): ?>
            <tr>
                <td><?= h($cdps->id) ?></td>
                <td><?= h($cdps->load_id) ?></td>
                <td><?= h($cdps->numero_documento) ?></td>
                <td><?= h($cdps->fecha_de_registro) ?></td>
                <td><?= h($cdps->fecha_de_creacion) ?></td>
                <td><?= h($cdps->tipo_de_cdp) ?></td>
                <td><?= h($cdps->estado) ?></td>
                <td><?= h($cdps->dependencia) ?></td>
                <td><?= h($cdps->dependencia_descripcion) ?></td>
                <td><?= h($cdps->rubro) ?></td>
                <td><?= h($cdps->descripcion) ?></td>
                <td><?= h($cdps->fuente) ?></td>
                <td><?= h($cdps->recurso) ?></td>
                <td><?= h($cdps->sit) ?></td>
                <td><?= h($cdps->valor_inicial) ?></td>
                <td><?= h($cdps->valor_operaciones) ?></td>
                <td><?= h($cdps->valor_actual) ?></td>
                <td><?= h($cdps->saldo_comprometer) ?></td>
                <td><?= h($cdps->objeto) ?></td>
                <td><?= h($cdps->solicitud_cdp) ?></td>
                <td><?= h($cdps->compromisos) ?></td>
                <td><?= h($cdps->cuentas_por_pagar) ?></td>
                <td><?= h($cdps->obligaciones) ?></td>
                <td><?= h($cdps->ordenes_de_pago) ?></td>
                <td><?= h($cdps->reintegros) ?></td>
                <td><?= h($cdps->created) ?></td>
                <td><?= h($cdps->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link('<span class="glyphicon glyphicon-zoom-in"></span><span class="sr-only">' . __('View') . '</span>', ['controller' => 'Cdps', 'action' => 'view', $cdps->id], ['escape' => false, 'class' => 'btn btn-xs btn-default', 'title' => __('View')]) ?>
                    <?= $this->Html->link('<span class="glyphicon glyphicon-pencil"></span><span class="sr-only">' . __('Edit') . '</span>', ['controller' => 'Cdps', 'action' => 'edit', $cdps->id], ['escape' => false, 'class' => 'btn btn-xs btn-default', 'title' => __('Edit')]) ?>
                    <?= $this->Form->postLink('<span class="glyphicon glyphicon-trash"></span><span class="sr-only">' . __('Delete') . '</span>', ['controller' => 'Cdps', 'action' => 'delete', $cdps->id], ['confirm' => __('Are you sure you want to delete # {0}?', $cdps->id), 'escape' => false, 'class' => 'btn btn-xs btn-danger', 'title' => __('Delete')]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <?php endif; ?>
    </div>
</div>
<div class="related row">
    <div class="column col-lg-12">
    <h4 class="subheader"><?= __('Related CdpsTmp') ?></h4>
    <?php if (!empty($load->cdps_tmp)): ?>
    <div class="table-responsive">
        <table class="table">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Load Id') ?></th>
                <th><?= __('Numero Documento') ?></th>
                <th><?= __('Fecha De Registro') ?></th>
                <th><?= __('Fecha De Creacion') ?></th>
                <th><?= __('Tipo De Cdp') ?></th>
                <th><?= __('Estado') ?></th>
                <th><?= __('Dependencia') ?></th>
                <th><?= __('Dependencia Descripcion') ?></th>
                <th><?= __('Rubro') ?></th>
                <th><?= __('Descripcion') ?></th>
                <th><?= __('Fuente') ?></th>
                <th><?= __('Recurso') ?></th>
                <th><?= __('Sit') ?></th>
                <th><?= __('Valor Inicial') ?></th>
                <th><?= __('Valor Operaciones') ?></th>
                <th><?= __('Valor Actual') ?></th>
                <th><?= __('Saldo Comprometer') ?></th>
                <th><?= __('Objeto') ?></th>
                <th><?= __('Solicitud Cdp') ?></th>
                <th><?= __('Compromisos') ?></th>
                <th><?= __('Cuentas Por Pagar') ?></th>
                <th><?= __('Obligaciones') ?></th>
                <th><?= __('Ordenes De Pago') ?></th>
                <th><?= __('Reintegros') ?></th>
                <th><?= __('Created') ?></th>
                <th><?= __('Modified') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($load->cdps_tmp as $cdpsTmp): ?>
            <tr>
                <td><?= h($cdpsTmp->id) ?></td>
                <td><?= h($cdpsTmp->load_id) ?></td>
                <td><?= h($cdpsTmp->numero_documento) ?></td>
                <td><?= h($cdpsTmp->fecha_de_registro) ?></td>
                <td><?= h($cdpsTmp->fecha_de_creacion) ?></td>
                <td><?= h($cdpsTmp->tipo_de_cdp) ?></td>
                <td><?= h($cdpsTmp->estado) ?></td>
                <td><?= h($cdpsTmp->dependencia) ?></td>
                <td><?= h($cdpsTmp->dependencia_descripcion) ?></td>
                <td><?= h($cdpsTmp->rubro) ?></td>
                <td><?= h($cdpsTmp->descripcion) ?></td>
                <td><?= h($cdpsTmp->fuente) ?></td>
                <td><?= h($cdpsTmp->recurso) ?></td>
                <td><?= h($cdpsTmp->sit) ?></td>
                <td><?= h($cdpsTmp->valor_inicial) ?></td>
                <td><?= h($cdpsTmp->valor_operaciones) ?></td>
                <td><?= h($cdpsTmp->valor_actual) ?></td>
                <td><?= h($cdpsTmp->saldo_comprometer) ?></td>
                <td><?= h($cdpsTmp->objeto) ?></td>
                <td><?= h($cdpsTmp->solicitud_cdp) ?></td>
                <td><?= h($cdpsTmp->compromisos) ?></td>
                <td><?= h($cdpsTmp->cuentas_por_pagar) ?></td>
                <td><?= h($cdpsTmp->obligaciones) ?></td>
                <td><?= h($cdpsTmp->ordenes_de_pago) ?></td>
                <td><?= h($cdpsTmp->reintegros) ?></td>
                <td><?= h($cdpsTmp->created) ?></td>
                <td><?= h($cdpsTmp->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link('<span class="glyphicon glyphicon-zoom-in"></span><span class="sr-only">' . __('View') . '</span>', ['controller' => 'CdpsTmp', 'action' => 'view', $cdpsTmp->id], ['escape' => false, 'class' => 'btn btn-xs btn-default', 'title' => __('View')]) ?>
                    <?= $this->Html->link('<span class="glyphicon glyphicon-pencil"></span><span class="sr-only">' . __('Edit') . '</span>', ['controller' => 'CdpsTmp', 'action' => 'edit', $cdpsTmp->id], ['escape' => false, 'class' => 'btn btn-xs btn-default', 'title' => __('Edit')]) ?>
                    <?= $this->Form->postLink('<span class="glyphicon glyphicon-trash"></span><span class="sr-only">' . __('Delete') . '</span>', ['controller' => 'CdpsTmp', 'action' => 'delete', $cdpsTmp->id], ['confirm' => __('Are you sure you want to delete # {0}?', $cdpsTmp->id), 'escape' => false, 'class' => 'btn btn-xs btn-danger', 'title' => __('Delete')]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <?php endif; ?>
    </div>
</div>
<div class="related row">
    <div class="column col-lg-12">
    <h4 class="subheader"><?= __('Related Compromisos') ?></h4>
    <?php if (!empty($load->compromisos)): ?>
    <div class="table-responsive">
        <table class="table">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Load Id') ?></th>
                <th><?= __('Fecha De Registro') ?></th>
                <th><?= __('Fecha De Creacion') ?></th>
                <th><?= __('Estado') ?></th>
                <th><?= __('Dependencia') ?></th>
                <th><?= __('Dependencia Descripcion') ?></th>
                <th><?= __('Rubro') ?></th>
                <th><?= __('Descripcion') ?></th>
                <th><?= __('Fuente') ?></th>
                <th><?= __('Recurso') ?></th>
                <th><?= __('Situacion') ?></th>
                <th><?= __('Valor Inicial') ?></th>
                <th><?= __('Valor Operaciones') ?></th>
                <th><?= __('Valor Actual') ?></th>
                <th><?= __('Saldo Por Utilizar') ?></th>
                <th><?= __('Tipo Identificacion') ?></th>
                <th><?= __('Identificacion') ?></th>
                <th><?= __('Nombre Razon Social') ?></th>
                <th><?= __('Medio De Pago') ?></th>
                <th><?= __('Tipo Cuenta') ?></th>
                <th><?= __('Numero Cuenta') ?></th>
                <th><?= __('Estado Cuenta') ?></th>
                <th><?= __('Entidad Nit') ?></th>
                <th><?= __('Entidad Descripcion') ?></th>
                <th><?= __('Solicitud Cdp') ?></th>
                <th><?= __('Cdp') ?></th>
                <th><?= __('Compromisos') ?></th>
                <th><?= __('Cuentas Por Pagar') ?></th>
                <th><?= __('Obligaciones') ?></th>
                <th><?= __('Ordenes De Pago') ?></th>
                <th><?= __('Reintegros') ?></th>
                <th><?= __('Fecha Documento Soporte') ?></th>
                <th><?= __('Tipo Documento Soporte') ?></th>
                <th><?= __('Numero Documento Soporte') ?></th>
                <th><?= __('Observaciones') ?></th>
                <th><?= __('Created') ?></th>
                <th><?= __('Modified') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($load->compromisos as $compromisos): ?>
            <tr>
                <td><?= h($compromisos->id) ?></td>
                <td><?= h($compromisos->load_id) ?></td>
                <td><?= h($compromisos->fecha_de_registro) ?></td>
                <td><?= h($compromisos->fecha_de_creacion) ?></td>
                <td><?= h($compromisos->estado) ?></td>
                <td><?= h($compromisos->dependencia) ?></td>
                <td><?= h($compromisos->dependencia_descripcion) ?></td>
                <td><?= h($compromisos->rubro) ?></td>
                <td><?= h($compromisos->descripcion) ?></td>
                <td><?= h($compromisos->fuente) ?></td>
                <td><?= h($compromisos->recurso) ?></td>
                <td><?= h($compromisos->situacion) ?></td>
                <td><?= h($compromisos->valor_inicial) ?></td>
                <td><?= h($compromisos->valor_operaciones) ?></td>
                <td><?= h($compromisos->valor_actual) ?></td>
                <td><?= h($compromisos->saldo_por_utilizar) ?></td>
                <td><?= h($compromisos->tipo_identificacion) ?></td>
                <td><?= h($compromisos->identificacion) ?></td>
                <td><?= h($compromisos->nombre_razon_social) ?></td>
                <td><?= h($compromisos->medio_de_pago) ?></td>
                <td><?= h($compromisos->tipo_cuenta) ?></td>
                <td><?= h($compromisos->numero_cuenta) ?></td>
                <td><?= h($compromisos->estado_cuenta) ?></td>
                <td><?= h($compromisos->entidad_nit) ?></td>
                <td><?= h($compromisos->entidad_descripcion) ?></td>
                <td><?= h($compromisos->solicitud_cdp) ?></td>
                <td><?= h($compromisos->cdp) ?></td>
                <td><?= h($compromisos->compromisos) ?></td>
                <td><?= h($compromisos->cuentas_por_pagar) ?></td>
                <td><?= h($compromisos->obligaciones) ?></td>
                <td><?= h($compromisos->ordenes_de_pago) ?></td>
                <td><?= h($compromisos->reintegros) ?></td>
                <td><?= h($compromisos->fecha_documento_soporte) ?></td>
                <td><?= h($compromisos->tipo_documento_soporte) ?></td>
                <td><?= h($compromisos->numero_documento_soporte) ?></td>
                <td><?= h($compromisos->observaciones) ?></td>
                <td><?= h($compromisos->created) ?></td>
                <td><?= h($compromisos->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link('<span class="glyphicon glyphicon-zoom-in"></span><span class="sr-only">' . __('View') . '</span>', ['controller' => 'Compromisos', 'action' => 'view', $compromisos->id], ['escape' => false, 'class' => 'btn btn-xs btn-default', 'title' => __('View')]) ?>
                    <?= $this->Html->link('<span class="glyphicon glyphicon-pencil"></span><span class="sr-only">' . __('Edit') . '</span>', ['controller' => 'Compromisos', 'action' => 'edit', $compromisos->id], ['escape' => false, 'class' => 'btn btn-xs btn-default', 'title' => __('Edit')]) ?>
                    <?= $this->Form->postLink('<span class="glyphicon glyphicon-trash"></span><span class="sr-only">' . __('Delete') . '</span>', ['controller' => 'Compromisos', 'action' => 'delete', $compromisos->id], ['confirm' => __('Are you sure you want to delete # {0}?', $compromisos->id), 'escape' => false, 'class' => 'btn btn-xs btn-danger', 'title' => __('Delete')]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <?php endif; ?>
    </div>
</div>
<div class="related row">
    <div class="column col-lg-12">
    <h4 class="subheader"><?= __('Related CompromisosTmp') ?></h4>
    <?php if (!empty($load->compromisos_tmp)): ?>
    <div class="table-responsive">
        <table class="table">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Load Id') ?></th>
                <th><?= __('Fecha De Registro') ?></th>
                <th><?= __('Fecha De Creacion') ?></th>
                <th><?= __('Estado') ?></th>
                <th><?= __('Dependencia') ?></th>
                <th><?= __('Dependencia Descripcion') ?></th>
                <th><?= __('Rubro') ?></th>
                <th><?= __('Descripcion') ?></th>
                <th><?= __('Fuente') ?></th>
                <th><?= __('Recurso') ?></th>
                <th><?= __('Situacion') ?></th>
                <th><?= __('Valor Inicial') ?></th>
                <th><?= __('Valor Operaciones') ?></th>
                <th><?= __('Valor Actual') ?></th>
                <th><?= __('Saldo Por Utilizar') ?></th>
                <th><?= __('Tipo Identificacion') ?></th>
                <th><?= __('Identificacion') ?></th>
                <th><?= __('Nombre Razon Social') ?></th>
                <th><?= __('Medio De Pago') ?></th>
                <th><?= __('Tipo Cuenta') ?></th>
                <th><?= __('Numero Cuenta') ?></th>
                <th><?= __('Estado Cuenta') ?></th>
                <th><?= __('Entidad Nit') ?></th>
                <th><?= __('Entidad Descripcion') ?></th>
                <th><?= __('Solicitud Cdp') ?></th>
                <th><?= __('Cdp') ?></th>
                <th><?= __('Compromisos') ?></th>
                <th><?= __('Cuentas Por Pagar') ?></th>
                <th><?= __('Obligaciones') ?></th>
                <th><?= __('Ordenes De Pago') ?></th>
                <th><?= __('Reintegros') ?></th>
                <th><?= __('Fecha Documento Soporte') ?></th>
                <th><?= __('Tipo Documento Soporte') ?></th>
                <th><?= __('Numero Documento Soporte') ?></th>
                <th><?= __('Observaciones') ?></th>
                <th><?= __('Created') ?></th>
                <th><?= __('Modified') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($load->compromisos_tmp as $compromisosTmp): ?>
            <tr>
                <td><?= h($compromisosTmp->id) ?></td>
                <td><?= h($compromisosTmp->load_id) ?></td>
                <td><?= h($compromisosTmp->fecha_de_registro) ?></td>
                <td><?= h($compromisosTmp->fecha_de_creacion) ?></td>
                <td><?= h($compromisosTmp->estado) ?></td>
                <td><?= h($compromisosTmp->dependencia) ?></td>
                <td><?= h($compromisosTmp->dependencia_descripcion) ?></td>
                <td><?= h($compromisosTmp->rubro) ?></td>
                <td><?= h($compromisosTmp->descripcion) ?></td>
                <td><?= h($compromisosTmp->fuente) ?></td>
                <td><?= h($compromisosTmp->recurso) ?></td>
                <td><?= h($compromisosTmp->situacion) ?></td>
                <td><?= h($compromisosTmp->valor_inicial) ?></td>
                <td><?= h($compromisosTmp->valor_operaciones) ?></td>
                <td><?= h($compromisosTmp->valor_actual) ?></td>
                <td><?= h($compromisosTmp->saldo_por_utilizar) ?></td>
                <td><?= h($compromisosTmp->tipo_identificacion) ?></td>
                <td><?= h($compromisosTmp->identificacion) ?></td>
                <td><?= h($compromisosTmp->nombre_razon_social) ?></td>
                <td><?= h($compromisosTmp->medio_de_pago) ?></td>
                <td><?= h($compromisosTmp->tipo_cuenta) ?></td>
                <td><?= h($compromisosTmp->numero_cuenta) ?></td>
                <td><?= h($compromisosTmp->estado_cuenta) ?></td>
                <td><?= h($compromisosTmp->entidad_nit) ?></td>
                <td><?= h($compromisosTmp->entidad_descripcion) ?></td>
                <td><?= h($compromisosTmp->solicitud_cdp) ?></td>
                <td><?= h($compromisosTmp->cdp) ?></td>
                <td><?= h($compromisosTmp->compromisos) ?></td>
                <td><?= h($compromisosTmp->cuentas_por_pagar) ?></td>
                <td><?= h($compromisosTmp->obligaciones) ?></td>
                <td><?= h($compromisosTmp->ordenes_de_pago) ?></td>
                <td><?= h($compromisosTmp->reintegros) ?></td>
                <td><?= h($compromisosTmp->fecha_documento_soporte) ?></td>
                <td><?= h($compromisosTmp->tipo_documento_soporte) ?></td>
                <td><?= h($compromisosTmp->numero_documento_soporte) ?></td>
                <td><?= h($compromisosTmp->observaciones) ?></td>
                <td><?= h($compromisosTmp->created) ?></td>
                <td><?= h($compromisosTmp->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link('<span class="glyphicon glyphicon-zoom-in"></span><span class="sr-only">' . __('View') . '</span>', ['controller' => 'CompromisosTmp', 'action' => 'view', $compromisosTmp->id], ['escape' => false, 'class' => 'btn btn-xs btn-default', 'title' => __('View')]) ?>
                    <?= $this->Html->link('<span class="glyphicon glyphicon-pencil"></span><span class="sr-only">' . __('Edit') . '</span>', ['controller' => 'CompromisosTmp', 'action' => 'edit', $compromisosTmp->id], ['escape' => false, 'class' => 'btn btn-xs btn-default', 'title' => __('Edit')]) ?>
                    <?= $this->Form->postLink('<span class="glyphicon glyphicon-trash"></span><span class="sr-only">' . __('Delete') . '</span>', ['controller' => 'CompromisosTmp', 'action' => 'delete', $compromisosTmp->id], ['confirm' => __('Are you sure you want to delete # {0}?', $compromisosTmp->id), 'escape' => false, 'class' => 'btn btn-xs btn-danger', 'title' => __('Delete')]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <?php endif; ?>
    </div>
</div>
