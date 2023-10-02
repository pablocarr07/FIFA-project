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
          <!-- /.box-tools -->

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
            <li>
              <?= $this->Html->link(__('Editar'), ['action' => 'edit', $user->id]) ?>
            </li>
            <li class="active">
              <?= $this->Html->link(__('Ver'), ['action' => 'view', $user->id]) ?>
            </li>
            <!-- /.<li>
              ?= $this->Html->link(__('Cambiar Contraseña'), ['action' => 'change-password', $user->id]) ?>
            </li> -->
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
    <!-- /.col-md-3 -->

    <!-- /.col -->
    <div class="col-md-9">

      <div class="box box-default">

        <div class="box-header with-border">
          <h3 class="box-title"><?= __('Detalle tercero')?> </h3>
        </div>
        <!-- /.box-header -->

        <div class="box-body">

          <div class="pull">

            <div class="form-group">
              <label for="inputName" class="col-sm-3 control-label">
                <?=__('Tipo de Identificación')?>
              </label>
              <div class="col-sm-9">
                <label for="inputName" class="control-label">
                  <?= $user->types_identification->name?>
                </label>
              </div>
            </div>

            <div class="form-group">
              <label for="inputName" class="col-sm-3 control-label">
                <?=__('Identificación')?>
              </label>
              <div class="col-sm-9">
                <label for="inputName" class="control-label">
                  <?= $user->identification?>
                </label>
              </div>
            </div>

            <div class="form-group">
              <label for="inputName" class="col-sm-3 control-label">
                <?=__('Nombre')?>
              </label>
              <div class="col-sm-9">
                <label for="inputName" class="control-label">
                  <?= $user->name?>
                </label>
              </div>
            </div>

            <div class="form-group">
              <label for="inputName" class="col-sm-3 control-label">
                <?=__('Email')?>
              </label>
              <div class="col-sm-9">
                <label for="inputName" class="control-label">
                  <?= $user->email?>
                </label>
              </div>
            </div>


            <div class="form-group">
              <label for="inputName" class="col-sm-3 control-label">
                <?=__('Tipo')?>
              </label>
              <div class="col-sm-9">
                <label for="inputName" class="control-label">
                  <?= $user->has('type') ? $user->type->name : '' ?>
                </label>
              </div>
            </div>

            <div class="form-group">
              <label for="inputName" class="col-sm-3 control-label">
                <?=__('Cargo')?>
              </label>
              <div class="col-sm-9">
                <label for="inputName" class="control-label">
                  <?= $user->has('charge') ? $user->charge->name : '' ?>
                </label>
              </div>
            </div>

            <div class="form-group">
              <label for="inputName" class="col-sm-3 control-label">
                <?=__('Grupo')?>
              </label>
              <div class="col-sm-9">
                <label for="inputName" class="control-label">
                  <?= $user->has('groups') ? $this->Html->link($user->groups[0]->name, ['controller' => 'Groups', 'action' => 'view', $user->groups[0]->id]) : '' ?>
                </label>
              </div>
            </div>

            <div class="clearfix"></div>
            <br>
            <br>
            <h4 class="subheader"><?= __('Roles Relacionados') ?></h4>
            <?php if (!empty($user->roles)): ?>

              <div class="table-responsive">

                <table class="table">
                  <tr>
                    <th><?= __('Nombre') ?></th>
                    <th><?= __('Descripción') ?></th>
                  </tr>
                  <?php foreach ($user->roles as $roles): ?>
                    <tr>
                      <td><?= h($roles->name) ?></td>
                      <td><?= h($roles->description) ?></td>
                    </tr>
                  <?php endforeach; ?>
                </table>
              </div>

            <?php endif; ?>
            <!-- /.if -->

          </div>
          <!-- /.pull -->

        </div>
        <!-- /.box-body -->

      </div>
      <!-- /.box -->

    </div>
    <!-- /.col -->

  </div>
  <!-- /.row -->

</section>
