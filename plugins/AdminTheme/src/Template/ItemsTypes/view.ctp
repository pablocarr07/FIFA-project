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
                  <li><?= $this->Html->link(__('Editar'), ['action' => 'edit', $itemsType->id]) ?> </li>
                  <li class="active"><?= $this->Html->link(__('Ver'), ['action' => 'view', $itemsType->id]) ?> </li>
                  <li><?= $this->Form->postLink(
                     __('Eliminar'),
                     ['action' => 'delete', $itemsType->id],
                     ['confirm' => __('estas seguro que quieres borrarlo # {0}?', $itemsType->id)]
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
               <h3 class="box-title"><?= __('Ver')?> </h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
               <div class="pull">
                  <div class="form-group">
                    <label for="inputName" class="col-sm-3 control-label"><?=__('id')?></label>
                     <div class="col-sm-9">
                        <label for="inputName" class="control-label"><?= h($itemsType->id) ?></label>
                     </div>
                     <label for="inputName" class="col-sm-3 control-label"><?=__('Nombre')?></label>
                     <div class="col-sm-9">
                        <label for="inputName" class="control-label"><?= h($itemsType->name) ?></label>
                     </div>
                     <label for="inputName" class="col-sm-3 control-label"><?=__('Creado')?></label>
                     <div class="col-sm-9">
                        <label for="inputName" class="control-label"><?= h($itemsType->created) ?></label>
                     </div>
                     <label for="inputName" class="col-sm-3 control-label"><?=__('Modificado')?></label>
                     <div class="col-sm-9">
                        <label for="inputName" class="control-label"><?= h($itemsType->modified) ?></label>
                     </div>
                  </div>
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
