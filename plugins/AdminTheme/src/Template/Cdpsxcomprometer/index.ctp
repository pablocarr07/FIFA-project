<section class="content">
<!--     
	 <div class="row">
        <div class="col-md-3">
          <div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title"><?= __('Actions') ?></h3>
              <div class="box-tools">
                <button data-widget="collapse" class="btn btn-box-tool" type="button"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="box-body no-padding" style="display: block;">
              <ul class="nav nav-pills nav-stacked">
			   <li><?= $this->Html->link(__('Cómo va su Presupuesto'),['controller'=>'asivasugasto','action' => 'index'] ) ?></li>			  
                <li>
				<li class="active"><?= $this->Html->link(__('CDP por comprometer'),['action' => 'index'] ) ?></li>
				</li>
				<li>
				<li><?= $this->Html->link(__('Asi va su gasto'), ['controller'=>'asivasugasto','action' => 'index']) ?></li>
				</li>
              </ul>
            </div>
          </div>     
        </div>
		-->
		
        <!-- /.col -->
        <div class="col-md-12">
          
          <div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title">CDPs por comprometer </h3>
			  <div class="mailbox-controls">
                <div class="btn-group">
				  <?= $this->Html->link('<i class="fa fa-download"></i>',['action' => 'index'],['escape'=>false,'class'=>'btn export_excel btn-default','data-toggle' => 'tooltip', 'title' => __('Exportar Excel')]);?>
                </div>
            </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
         <div class="table-responsive mailbox-messages">   
		<table class="table table-striped">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('numero_documento',['label'=>'Número de CDP']) ?></th>
                <th><?= $this->Paginator->sort('rubro',['label'=>'Rubro']) ?></th>
                <th><?= $this->Paginator->sort('fecha_de_registro',['label'=>'Fecha']) ?></th>
                <th><?= $this->Paginator->sort('valor_actual',['label'=>'Valor']) ?></th>
                <th><?= $this->Paginator->sort('saldo_comprometer',['label'=>'Valor Compremeter']) ?></th>
                <th><?= $this->Paginator->sort('objeto',['label'=>'Concepto']) ?></th>
                <th><?= $this->Paginator->sort('estado',['label'=>'Estado']) ?></th>
               <!-- <th class="actions"><?= __('¿Quire Liberar?') ?></th> -->
            </tr>
        </thead>
        <tbody>
        <?php foreach ($cdpsxcomprometer as $cdpxcomprometer):  ?>
		<?php if($cdpxcomprometer->saldo_por_comprometer > 0) {?>
            <tr>
                <td><?= h($cdpxcomprometer->numero_documento) ?></td>
                <td><?= h($cdpxcomprometer->rubro) ?></td>
                <td><?= h($cdpxcomprometer->fecha_de_registro) ?></td>
                <td class="valueFormat"><?= $cdpxcomprometer->valor_actual ?></td>
                <td class="valueFormat"><?= $cdpxcomprometer->saldo_por_comprometer ?></td>
                <td><?= h($cdpxcomprometer->objeto) ?></td>
                <td><?= h($cdpxcomprometer->estado) ?></td>
               <!-- <td class="actions">
                    <?= $this->Html->link('<span class="glyphicon glyphicon-ok"></span><span class="sr-only">' . __('View') . '</span>', ['action' => 'view', ''], ['escape' => false, 'class' => 'btn btn-xs btn-default', 'title' => __('View')]) ?>
                </td>-->
            </tr>
		<?php } ?>
        <?php  endforeach; ?>
        </tbody>
        </table>
		 </div>
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
        </div>
		<!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
	<?php
	$this->append('script','<script type="text/javascript">	
		var export_excel={"data":$(".table-responsive").html(),"filename":"cdp_por_comprometer.xls"}
	</script>');
	$this->append('script', $this->Html->script(['cdpsxcomprometer/index','jquery-number/jquery.number.min','export_excel']));	
	?>