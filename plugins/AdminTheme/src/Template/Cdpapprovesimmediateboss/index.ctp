<section class="content">
  <div class="row">
    <div class="col-md-3">
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title"><?= __('Acciones') ?></h3>

          <div class="box-tools">
            <button data-widget="collapse" class="btn btn-box-tool" type="button"><i class="fa fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="box-body no-padding" style="display: block;">
          <ul class="nav nav-pills nav-stacked">
            <li><?= $this->Html->link(__('Dashboard'), ['controller' => 'Cdprequestsdashboard', 'action' => 'index']) ?></li>
          </ul>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /. box -->
    </div>


    <!-- /.col -->
    <div class="col-md-9">
      <div class="box box-default">
        <div class="box-header with-border">
          <div class="mailbox-controls">
            <!--
                <div class="btn-group">
				  <?= $this->Html->link('<i class="fa fa-download"></i>', ['action' => 'index'], ['escape' => false, 'class' => 'btn btn-default', 'data-toggle' => 'tooltip', 'title' => __('Exportar EXCEl')]); ?>
                </div>
              <div class="box-tools pull-right">
                <?php
                echo $this->Form->create('', ['class' => 'form-inline']);
                echo $this->Form->input('q', ['placeholder' => __('Buscar'), 'label' => false, 'class' => 'form-control']);
                echo $this->Form->button('<i class="glyphicon glyphicon-search"></i>', ['type' => 'submit', 'class' => 'btn btn-info btn-flat', 'data-toggle' => 'tooltip', 'title' => __('Buscar')], ['escape' => false]);
                echo $this->Html->link('<i class="glyphicon glyphicon-remove-circle"></i>', ['action' => 'index'], ['escape' => false, 'class' => 'btn btn-danger btn-flat', 'data-toggle' => 'tooltip', 'title' => __('Limpiar')]);
                //echo'</div>';
                echo $this->Form->end();
                ?> !->
              </div>
              <!-- /.box-tools -->
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body no-padding">

          <div class="table-responsive mailbox-messages">
            <table class="table table-hover table-striped">
              <thead>
                <tr>
                  <th><?= $this->Paginator->sort('id') ?></th>
                  <th><?= $this->Paginator->sort('cdp') ?></th>
                  <th><?= $this->Paginator->sort('Solicitante') ?></th>
                  <th><?= $this->Paginator->sort('Estado') ?></th>
                  <th><?= $this->Paginator->sort('Tipo de Movimineto') ?></th>
                  <th><?= $this->Paginator->sort('Creado') ?></th>
                  <th class="actions"><?= __('Actions') ?></th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($cdprequests as $cdprequest) : ?>
                  <td><?= $this->Number->format($cdprequest->migracion_id) ? $this->Number->format($cdprequest->migracion_id) : $this->Number->format($cdprequest->id) ?></td>
                  <td><?= $this->Number->format($cdprequest->cdp) ?></td>
                  <td><?= h($cdprequest->Applicants->name) ?></td>
                  <td><?= h($cdprequest->State->name) ?></td>
                  <td><?= h($cdprequest->Movement_types->name) ?></td>
                  <td><?= h($cdprequest->created->timeAgoInWords(['format' => 'dd MMMM YYYY', 'end' => '+1 year'])) ?></td>
                  <td class="actions">
                    <?= $this->Html->link('<span class="glyphicon glyphicon-list"></span><span class="sr-only">' . __('Timeline') . '</span>', ['controller' => 'Cdprequeststimeline', 'action' => 'index', $cdprequest->id], ['escape' => false, 'class' => 'btn btn-xs timelinecdprequests', 'data-toggle' => 'tooltip', 'title' => __('Timeline')]) ?>
                    <?= $this->Html->link('<span class="glyphicon glyphicon-eye-open"></span><span class="sr-only">' . __('Ver') . '</span>', ['action' => 'view', $cdprequest->id], ['escape' => false, 'class' => 'btn btn-xs', 'data-toggle' => 'tooltip', 'title' => __('Ver')]) ?>

                  </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
            <!-- /.table -->
          </div>
          <!-- /.mail-box-messages -->
        </div>
        <!-- /.box-body -->
        <div class="box-footer no-padding">
          <div class="mailbox-controls">
            <div class="pull-left" style="margin: 20px 0;">
              <?= $this->Paginator->counter('{{start}} de {{end}}') ?>
            </div>
            <div class="pull-right">

              <div class="box-tools">
                <ul class="pagination">
                  <?= $this->Paginator->prev('< ' . __('Anterior')) ?>
                  <?= $this->Paginator->numbers(['before' => '', 'after' => '']) ?>
                  <?= $this->Paginator->next(__('Siguiente') . ' >') ?>
                </ul>

              </div>
              <!-- /.btn-group -->
            </div>
            <!-- /.pull-right -->
          </div>
        </div>
      </div>
      <!-- /. box -->
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->
</section>
<?php $this->append('script', $this->Html->script(['timelinecdprequests'])); ?>