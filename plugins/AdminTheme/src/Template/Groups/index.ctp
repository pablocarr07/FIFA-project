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
            <li class="active"><?= $this->Html->link(__('Lista'), ['action' => 'index']) ?></li>
            <li>
              <?= $this->Html->link(__('Crear'), ['action' => 'add']) ?>
            </li>
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
          <h3 class="box-title"><?= __('Gestión de Grupos') ?> </h3>
        </div>

        <div class="box-header with-border">
          <div class="mailbox-controls">
            <div class="btn-group">
              <?= $this->Html->link('<span class="glyphicon glyphicon-download-alt"></span><span class="sr-only"></span> ' . __('Descargar reporte de grupos'), ['controller' => 'reports', 'action' => 'exportReportGroups', '?' => ['state-id' => '-1']], ['escape' => false, 'class' => 'btn btn-lg btn-success', 'id' => 'modal_add', 'title' => __('Descargar reporte de grupos')]); ?>
            </div>



            <div class="box-tools pull-right">
              <?php
              echo $this->Form->create('', ['class' => 'form-inline']);
              // You'll need to populate $authors in the template from your controller
              //echo $this->Form->input('user_id');
              // Match the search param in your table configuration
              //echo' <div class="has-feedback">';
              echo $this->Form->input('q', ['placeholder' => __('Buscar'), 'label' => false, 'class' => 'form-control']);
              echo $this->Form->button('<i class="glyphicon glyphicon-search"></i>', ['type' => 'submit', 'class' => 'btn btn-info btn-flat', 'data-toggle' => 'tooltip', 'title' => __('Buscar')], ['escape' => false]);
              echo $this->Html->link('<i class="glyphicon glyphicon-remove-circle"></i>', ['action' => 'index'], ['escape' => false, 'class' => 'btn btn-danger btn-flat', 'data-toggle' => 'tooltip', 'title' => __('Limpiar')]);
              //echo'</div>';
              echo $this->Form->end();
              ?>
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
                  <th><?= $this->Paginator->sort('id', ['label' => 'ID']) ?></th>
                  <th><?= $this->Paginator->sort('name', ['label' => 'Grupo']) ?></th>
                  <th><?= $this->Paginator->sort('parent_id', ['label' => 'Padre']) ?></th>
                  <th class="actions"><?= __('Acciones') ?></th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($groups as $group) : ?>
                  <tr>
                    <td><?= $this->Number->format($group->id) ?></td>
                    <td><?= h($group->name) ?></td>
                    <td>
                      <?= $group->has('parent_group') ? $this->Html->link($group->parent_group->name, ['controller' => 'Groups', 'action' => 'view', $group->parent_group->id]) : '' ?>
                    </td>
                    <td class="actions">
                      <?= $this->Html->link('<span class="glyphicon glyphicon-eye-open"></span><span class="sr-only">' . __('Ver') . '</span>', ['action' => 'view', $group->id], ['escape' => false, 'class' => 'btn btn-xs', 'data-toggle' => 'tooltip', 'title' => __('Ver')]) ?>
                      <?= $this->Html->link('<span class="glyphicon glyphicon-pencil"></span><span class="sr-only">' . __('Editar') . '</span>', ['action' => 'edit', $group->id], ['escape' => false, 'class' => 'btn btn-xs', 'data-toggle' => 'tooltip', 'title' => __('Editar')]) ?>
                      <?= $this->Form->postLink('<span class="glyphicon glyphicon-trash"></span><span class="sr-only">' . __('Eliminar') . '</span>', ['action' => 'delete', $group->id], ['confirm' => __('estas seguro que quieres borrarlo # {0}?', $group->id), 'escape' => false, 'class' => 'btn btn-xs', 'data-toggle' => 'tooltip', 'title' => __('Eliminar')]) ?>
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