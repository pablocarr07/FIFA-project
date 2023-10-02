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
              <div class="mailbox-controls">
                <div class="btn-group">
			<!--<?= $this->Html->link('<i class="fa fa-download"></i>',['action' => 'index'],['escape'=>false,'class'=>'btn btn-default','data-toggle' => 'tooltip', 'title' => __('Exportar EXCEl')]);?>-->
                </div>
                                
              

              <div class="box-tools pull-right">
                <?php /*
    echo $this->Form->create('',['class'=>'form-inline']);
    // You'll need to populate $authors in the template from your controller
    //echo $this->Form->input('user_id');
    // Match the search param in your table configuration
	//echo' <div class="has-feedback">';
    echo $this->Form->input('q',['placeholder'=>__('Buscar'), 'label' => false,'class'=>'form-control']);
    echo $this->Form->button('<i class="glyphicon glyphicon-search"></i>', ['type' => 'submit','class'=>'btn btn-info btn-flat','data-toggle' => 'tooltip', 'title' => __('Buscar')],['escape'=>false]);
    echo $this->Html->link('<i class="glyphicon glyphicon-remove-circle"></i>',['action' => 'index'],['escape'=>false,'class'=>'btn btn-danger btn-flat','data-toggle' => 'tooltip', 'title' => __('Limpiar')]);

	echo $this->Form->end(); */
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
                <th><?= $this->Paginator->sort('id',['label'=>'Id']) ?></th>
                <th><?= $this->Paginator->sort('cdp',['label'=>'CDP']) ?></th>
                <th><?= $this->Paginator->sort('compromiso',['label'=>'Compromisos']) ?></th>
                <!--<th><?= $this->Paginator->sort('support') ?></th>-->
                <th><?= $this->Paginator->sort('created',['label'=>'Creado']) ?></th>
            </tr>
        </thead>
        <tbody>
      <?php foreach ($loads as $load): ?>
            <tr>
            <td><?= h($load->id) ?></td>
                <td><?= h($load->cdp) ?></td>
                <td><?= h($load->compromiso) ?></td>
                <!--<td><?= h($load->support) ?></td>-->
                <td><?= h($load->created) ?></td>
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



