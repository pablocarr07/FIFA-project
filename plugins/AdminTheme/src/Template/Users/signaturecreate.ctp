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
				<li><?= $this->Html->link(__('Editar'), ['action' => 'edit', $user->id]) ?> </li>
				<li><?= $this->Html->link(__('Ver'), ['action' => 'view', $user->id]) ?> </li>
				<li class="active"><?= $this->Html->link(__('Crear Certificado'), ['action' => 'signaturecreate', $user->id]) ?> </li>
			   <li><?= $this->Form->postLink(
                __('Eliminar'),
                ['action' => 'delete', $user->id],
                ['confirm' => __('estas seguro que quieres borrarlo # {0}?', $user->id)]
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
              <h3 class="box-title"><?= __('Crear Certificado')?> </h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
             <div class="pull">
              <?= $this->Form->create($user); ?>
			  <div class="form-group">
                    <label for="inputName" class="col-sm-3 control-label"><?=__('Tipo de Identificación')?></label>
                    <div class="col-sm-9">
						<label for="inputName" class="control-label"><?= $user->types_identification->name?></label>
                    </div>
                </div>
			  
			   <div class="form-group">
                    <label for="inputName" class="col-sm-3 control-label"><?=__('Identificación')?></label>
                    <div class="col-sm-9">
						<label for="inputName" class="control-label"><?= $user->identification?></label>
                    </div>
                </div>
				<div class="form-group">
                    <label for="inputName" class="col-sm-3 control-label"><?=__('Nombre')?></label>
                    <div class="col-sm-9">
						<label for="inputName" class="control-label"><?= $user->name?></label>
                    </div>
                </div>
				<div class="form-group">
                    <label for="inputName" class="col-sm-3 control-label"><?=__('Email')?></label>
                    <div class="col-sm-9">
						<label for="inputName" class="control-label"><?= $user->email?></label>
                    </div>
                </div>
				<div class="form-group">
                    <label for="inputName" class="col-sm-3 control-label"><?=__('Grupo')?></label>
                    <div class="col-sm-9">
						<label for="inputName" class="control-label"><?= $user->has('group') ? $this->Html->link($user->group->name, ['controller' => 'Groups', 'action' => 'view', $user->group->id]) : '' ?></label>
                    </div>
                </div>
				<div class="form-group">
                    <label for="inputName" class="col-sm-3 control-label"><?=__('Tipo')?></label>
                    <div class="col-sm-9">
						<label for="inputName" class="control-label">
						<?= $user->has('type') ? $user->type->name : '' ?>
						</label>
                    </div>
                </div>
				
				
				<div class="form-group">
                    <label for="inputName" class="col-sm-3 control-label"><?=__('Cargo')?></label>
                    <div class="col-sm-9">
						<label for="inputName" class="control-label">
						<?= $user->has('charge') ? $this->Html->link($user->charge->name, ['controller' => 'Charges', 'action' => 'view', $user->charge->id]) : '' ?>
						</label>
                    </div>
                </div>
              
            
            <!-- /.box-body -->
            <div class="box-footer">
              <div class="pull-right">
                <?= $this->Form->button(__('Crear Certificado'), ['class' => 'btn-success']) ?>
              </div>
             
            </div>
			<?= $this->Form->end() ?>
            <!-- /.box-footer -->
			</div>
			</div>
			
			
			
			
			 </div>
			</div>		
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
