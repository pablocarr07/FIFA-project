<section class="content">

  <div class="row">

    <div class="col-md-3">

      <div class="box box-default">

        <div class="box-header with-border">
          <h3 class="box-title"><?= __('Acciones') ?></h3>
          <div class="box-tools">
            <button data-widget="collapse" class="btn btn-box-tool" type="button">
              <i class="fa fa-minus"></i>
            </button>
          </div>
        </div>
        <!-- /.box-header -->

        <div class="box-body no-padding" style="display: block;">

          <ul class="nav nav-pills nav-stacked">
            <li>
              <?= $this->Html->link(__('Listar'), ['action' => 'index']) ?>
            </li>
            <li>
              <?= $this->Html->link(__('Crear'), ['action' => 'add']) ?>
            </li>
            <li class="active">
              <?= $this->Html->link(__('Editar'), ['action' => 'edit', $user->id]) ?>
            </li>
            <li>
              <?= $this->Html->link(__('Ver'), ['action' => 'view', $user->id]) ?>
            </li>
           <!-- /. <li>
              ?= $this->Html->link(__('Cambiar Contraseña'), ['action' => 'change-password', $user->id]) ?>
            </li>-->
            <li>
              <?= $this->Form
                ->postLink(
                __('Eliminar'),
                  ['action' => 'delete', $user->id],
                  ['confirm' => __('estas seguro que quieres borrarlo # {0}?', $user->id)]
                )
              ?>
            </li>
          </ul>

        </div>
        <!-- /.box-body -->

      </div>
      <!-- /. box -->

    </div>
    <!-- /. col -->

    <div class="col-md-9">

      <?= $this->Form->create($user); ?>

      <div class="box box-default">

        <div class="box-header with-border">
          <h3 class="box-title"><?= __('Editar Tercero')?> </h3>
        </div>
        <!-- /.box-header -->

        <div class="box-body">

          <div class="pull">

            <?php
              echo $this->Form->input('types_identification_id', ['options' => $typesIdentification,'label'=>'Tipo de Identificación']);
              echo $this->Form->input('identification',['label'=>'Identificación']);
              echo $this->Form->input('name',['label'=>'Nombre']);
              echo $this->Form->input('email',['label'=>'Email']);
              echo $this->Form->input('group_id', ['options' => $groups,'empty'=>'(Elegir Grupo)','label'=>'Grupo']);
              echo $this->Form->input('type_id', ['options' => $types,'empty'=>'(Elegir Tipo)','label'=>'Tipo']);
              echo $this->Form->input('charge_id', ['options' => $charges,'empty'=>'(Elegir Cargo)','label'=>'Cargo']);
              echo $this->Form->input('roles._ids', ['options' => $roles,'label'=>'Roles']);
              echo $this->Form->input('user_directorio',['label'=>'Usuario Directorio Activo']);
            ?>

            <div class="form-group iCheck-input">
              <?= $this->Form->input('active', ['empty' => true, 'class' => 'form-control']); ?>
            </div>

          </div>
          <!-- /.pull -->

        </div>
        <!-- /.box-body -->

        <div class="box-footer">
          <div class="pull-right">
            <?= $this->Form->button(__('Submit'), ['class' => 'btn-success']) ?>
          </div>
        </div>
        <!-- /.box-footer -->

      </div>
      <!-- /.box -->

      <?= $this->Form->end() ?>

    </div>
    <!-- /.col -->

  </div>
  <!-- /.row -->

</section>
