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
				<li><?= $this->Html->link(__('Editar'), ['action' => 'edit', $dependency->id]) ?> </li>
				<li class="active"><?= $this->Html->link(__('Ver'), ['action' => 'view', $dependency->id]) ?> </li>
				<li><?= $this->Form->postLink(
                __('Eliminar'),
                ['action' => 'delete', $dependency->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $dependency->id)]
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
              <h3 class="box-title"><?= __('Ver Dependecnia')?> </h3>
            </div>
            <!-- /.box-header -->
			
            <div class="box-body">
			
             <div class="pull">
				<div class="form-group">
                    <label for="inputName" class="col-sm-3 control-label"><?=__('Nombre')?></label>
                    <div class="col-sm-9">
						<label for="inputName" class="control-label"><?= __($dependency->name) ?></label>
                    </div>
                </div>
			<h4 class="subheader"><?= __('Grupos Relacionados') ?></h4>
			<?php if (!empty($dependency->child_groups)): ?>
				<div class="table-responsive">
					<table class="table">
						<tr>
							<th><?= __('Id') ?></th>
							<th><?= __('Name') ?></th>
							<th class="actions"><?= __('Actions') ?></th>
						</tr>
						<?php foreach ($dependency->child_groups as $dependencyGroups): ?>
						<tr>
							<td><?= h($dependencyGroups->id) ?></td>
							<td><?= h($dependencyGroups->name) ?></td>
							<td class="actions">
								<?= $this->Html->link('<span class="glyphicon glyphicon-eye-open"></span><span class="sr-only">' . __('Ver') . '</span>', ['controller' => 'Groups', 'action' => 'view', $dependencyGroups->id], ['escape' => false, 'class' => 'btn btn-xs', 'title' => __('View'),'data-toggle' => 'tooltip', 'title' => __('Ver')]) ?>
								<?= $this->Html->link('<span class="glyphicon glyphicon-pencil"></span><span class="sr-only">' . __('Editar') . '</span>', ['controller' => 'Groups', 'action' => 'edit', $dependencyGroups->id], ['escape' => false, 'class' => 'btn btn-xs', 'title' => __('Edit'),'data-toggle' => 'tooltip', 'title' => __('Editar')]) ?>
								<?= $this->Form->postLink('<span class="glyphicon glyphicon-trash"></span><span class="sr-only">' . __('Eliminar') . '</span>', ['controller' => 'Groups', 'action' => 'delete', $dependencyGroups->id], ['confirm' => __('estas seguro que quieres borrarlo # {0}?', $dependencyGroups->id), 'escape' => false, 'class' => 'btn btn-xs', 'title' => __('Delete'),'data-toggle' => 'tooltip', 'title' => __('Eliminar')]) ?>
							</td>
						</tr>
						<?php endforeach; ?>
					</table>
				</div>
				<?php endif; ?>
				<h4 class="subheader"><?= __('Usuarios Relacionados') ?></h4>
				<?php if (!empty($dependency->users)): ?>
    <div class="table-responsive">
        <table class="table">
            <tr>
                <th><?= __('Identification') ?></th>
                <th><?= __('Nombre Razon Social') ?></th>
                <th><?= __('Email') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($dependency->users as $users): ?>
            <tr>
                <td><?= h($users->identification) ?></td>
                <td><?= h($users->name) ?></td>
                <td><?= h($users->email) ?></td>
                <td class="actions">
                    <?= $this->Html->link('<span class="glyphicon glyphicon-eye-open"></span><span class="sr-only">' . __('Ver') . '</span>', ['controller' => 'Users', 'action' => 'view', $users->id], ['escape' => false, 'class' => 'btn btn-primary btn-xs', 'title' => __('View'),'data-toggle' => 'tooltip', 'title' => __('Ver')]) ?>
                    <?= $this->Html->link('<span class="glyphicon glyphicon-pencil"></span><span class="sr-only">' . __('Editar') . '</span>', ['controller' => 'Users', 'action' => 'edit', $users->id], ['escape' => false, 'class' => 'btn btn-warning btn-xs', 'title' => __('Edit'),'data-toggle' => 'tooltip', 'title' => __('Editar')]) ?>
                    <?= $this->Form->postLink('<span class="glyphicon glyphicon-trash"></span><span class="sr-only">' . __('Eliminar') . '</span>', ['controller' => 'Users', 'action' => 'delete', $users->id], ['confirm' => __('Are you sure you want to delete # {0}?', $users->id), 'escape' => false, 'class' => 'btn btn-xs btn-danger', 'title' => __('Delete'),'data-toggle' => 'tooltip', 'title' => __('Eliminar')]) ?>
                </td>
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
