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
            <li>
              <li><?= $this->Html->link(__('Listar'), ['action' => 'index']) ?>
              </li>
              <li><?= $this->Html->link(__('Crear'), ['action' => 'add']) ?></li>
              <li><?= $this->Html->link(__('Editar'), ['action' => 'edit', $group->id]) ?> </li>
              <li class="active"><?= $this->Html->link(__('Ver'), ['action' => 'view', $group->id]) ?> </li>
              <li><?= $this->Form->postLink(
                __('Eliminar'),
                ['action' => 'delete', $group->id],
                ['confirm' => __('estas seguro que quieres borrarlo # {0}?', $group->id)]
                )
                ?></li>
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
              <h3 class="box-title"><?= __('Ver Grupo')?> </h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="pull">
                <div class="form-group">
                  <label for="inputName" class="col-sm-3 control-label"><?=__('Dependency')?></label>
                  <div class="col-sm-9">
                    <label for="inputName" class="control-label"><?= $dependency ?></label>
                  </div>
                  <label for="inputName" class="col-sm-3 control-label"><?=__('Nombre')?></label>
                  <div class="col-sm-9">
                    <label for="inputName" class="control-label"><?= h($group->name) ?></label>
                  </div>

                  <?php if ($group->has('parent_group')) { ?>
                    <label for="inputName" class="col-sm-3 control-label"><?=__('Parent Group')?></label>
                    <div class="col-sm-9">
                      <label for="inputName" class="control-label">
                        <?= $group->has('parent_group') ? $this->Html->link($group->parent_group->name, ['controller' => 'Groups', 'action' => 'view', $group->parent_group->id]) : '' ?>
                      </label>
                    </div>
                  <?php } ?>

                </div>

                <?php if (!empty($group->child_groups)): ?>
                  <div class="clearfix"></div>
                  <br/>
                  <br/>

                  <h4 class="subheader"><?= __('Grupos Relacionados') ?></h4>
                  <div class="table-responsive">
                    <table class="table">
                      <tr>
                        <th><?= __('Id') ?></th>
                        <th><?= __('Name') ?></th>
                        <th class="actions"><?= __('Actions') ?></th>
                      </tr>
                      <?php foreach ($group->child_groups as $dependencyGroups): ?>
                        <tr>
                          <td><?= h($dependencyGroups->id) ?></td>
                          <td><?= h($dependencyGroups->name) ?></td>
                          <td class="actions">
                            <?= $this->Html->link('<span class="glyphicon glyphicon-eye-open"></span><span class="sr-only">' . __('Ver') . '</span>', ['controller' => 'Groups', 'action' => 'view', $dependencyGroups->id], ['escape' => false, 'class' => 'btn btn-primary btn-xs', 'title' => __('View'),'data-toggle' => 'tooltip', 'title' => __('Ver')]) ?>
                            <?= $this->Html->link('<span class="glyphicon glyphicon-pencil"></span><span class="sr-only">' . __('Editar') . '</span>', ['controller' => 'Groups', 'action' => 'edit', $dependencyGroups->id], ['escape' => false, 'class' => 'btn btn-warning btn-xs', 'title' => __('Edit'),'data-toggle' => 'tooltip', 'title' => __('Editar')]) ?>
                            <?= $this->Form->postLink('<span class="glyphicon glyphicon-trash"></span><span class="sr-only">' . __('Eliminar') . '</span>', ['controller' => 'Groups', 'action' => 'delete', $dependencyGroups->id], ['confirm' => __('Are you sure you want to delete # {0}?', $dependencyGroups->id), 'escape' => false, 'class' => 'btn btn-xs btn-danger', 'title' => __('Delete'),'data-toggle' => 'tooltip', 'title' => __('Eliminar')]) ?>
                          </td>
                        </tr>
                      <?php endforeach; ?>
                    </table>
                  </div>
                <?php endif; ?>

                <?php if (!empty($group->users)): ?>
                  <div class="clearfix"></div>
                  <br/>
                  <br/>

                  <h4 class="subheader"><?= __('Usuarios Relacionados') ?></h4>
                  <div class="table-responsive">
                    <table class="table">
                      <tr>
                        <th><?= __('Nombre Razon Social') ?></th>
                        <th><?= __('Email') ?></th></th>
                      </tr>
                      <?php foreach ($group->users as $users): ?>
                        <tr>
                          <td><?= h($users->name) ?></td>
                          <td><?= h($users->email) ?></td>
                        </tr>
                      <?php endforeach; ?>
                    </table>
                  </div>
                <?php endif; ?>

              </div>
            </div>
            <!-- /.box-footer -->
          </div>
        </div>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>