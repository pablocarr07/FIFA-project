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
			   <li class="active"><?= $this->Html->link(__('Cómo va su Presupuesto'), ['action' => 'index']) ?></li>			  
                <li>
				<li><?= $this->Html->link(__('CDPs por comprometer'), ['controller'=>'cdpsxcomprometer','action' => 'index']) ?></li>
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
			<h3 class="box-title">Como va su presupuesto </h3>
              <div class="mailbox-controls">
                <div class="btn-group">
				  <?= $this->Html->link('<i class="fa fa-download"></i>',['action' => 'index'],['escape'=>false,'class'=>'btn export_excel btn-default','data-toggle' => 'tooltip', 'title' => __('Exportar Excel')]);?>
                </div>
            </div>
			</div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              
              <div class="table-responsive mailbox-messages">
                <table class="table table-hover table-striped">
               <thead>
            <tr>                
                <th><span data-toggle="tooltip" title =""><?= __('Presupuesto Asignado') ?> <span></th>
                <th><span data-toggle="tooltip" title =""><?= __('Presupuesto Comprometido') ?> <span></th>
                <th><span data-toggle="tooltip" title =""> <?= __('Presupuesto Pagado') ?><span></th>
            </tr>
        </thead>
        <tbody>
        <tr>
			<td class="valueFormat"><?=$presupuesto['budget']['valor']?></td>
			<td class="valueFormat"><?=$presupuesto['comprometido']['valor']?></td>
			<td class="valueFormat"><?=$presupuesto['pagado']['valor']?></td>
		</tr>
        </tbody>
		</table>
                <!-- /.table -->
         </div>
              
            </div>
			</div>
          <!-- /. box -->
        </div>
		
		<!--
		<div class="col-md-4">
          <div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title"><?= __('Budgets') ?></h3>
              
            </div>
            <div class="box-body no-padding" style="display: block;">
              <div id="donut-chart" style="height: 300px;"></div>
            </div>
          </div> 
        </div>		
		-->
		
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
	
<?php
$this->append('script','<script type="text/javascript">
	var donutData = [
      {label: "ppto asignado", value: '.$presupuesto['budget']['porcentaje'].', color: "#3c8dbc"},
      {label: "ppto comprometido", value:'.$presupuesto['comprometido']['porcentaje'].', color: "#00a65a"},
      {label: "ppto pagado", value: '.$presupuesto['pagado']['porcentaje'].', color: "#f56954"}
    ];	
	var export_excel={"data":$(".table-responsive").html(),"filename":"como_va_su_presupuesto.xls"}
	</script>') ?>
	

	<?php $this->append('css', $this->Html->script(['morris/morris']));
	 $this->append('script', $this->Html->script(
		[			
			'export_excel',
			'https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js',
			'morris/morris.min',
			'jquery-number/jquery.number.min',
			'comovasupresupuesto/index'
		])); ?>
		

	