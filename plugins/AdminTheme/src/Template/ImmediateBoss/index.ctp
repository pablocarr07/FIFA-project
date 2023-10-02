<?php
	$this->append('css', $this->Html->css(['http://maxazan.github.io/jquery-treegrid/css/jquery.treegrid.css']));
	$this->append('script', $this->Html->script(['http://maxazan.github.io/jquery-treegrid/js/jquery.treegrid.js']));
?>

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
							<li class="active"><?= $this->Html->link(__('Jefe Inmediato'), ['action' => 'index']) ?>
							</li>
							<li><?= $this->Html->link(__('Dependencias'), ['controller'=>'dependencies','action' => 'index']) ?></li>
							<li><?= $this->Html->link(__('Grupos'), ['controller'=>'groups','action' => 'index']) ?> </li>

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
						<h3 class="box-title"><?= __('Gestión de Jefes Inmediatos')?> </h3>
					</div>

					<div class="btn-group">
             			 <?= $this->Html->link('<span class="glyphicon glyphicon-download-alt"></span><span class="sr-only"></span> ' . __('Descargar reporte de Jefes Inmediatos'), ['controller' => 'reports', 'action' => 'exportReportJefes'], ['escape' => false, 'class' => 'btn btn-lg btn-success',  'title' => __('Descargar reporte de Jefes Inmediatos')]); ?>
            		</div>





            <div class="btn-group">
            </div>



					<!-- /.box-header -->

					<div class="box-body">
						<div class="pull">

							<div class="table-responsive">
								<table class="table table-striped tree">
									<thead>
										<tr>
											<th><?= __('Dependencia') ?></th>
											<th><?= __('Grupo') ?></th>
											<th><?= __('SubGrupo') ?></th>
											<th class="text-right"><?= __('Jefe Inmediato') ?></th>
										</tr>
									</thead>
									<tbody>
										<?php
											foreach($immediateboss['dependencies'] as $d){
										?>
											<tr class="treegrid-<?= $d['id'] ?> treegrid-parent-<?= $d['parent'] ?>">
												<td><?= h($d['dependency'])?></td>
												<td><?= h($d['group'])?></td>
												<td><?= h($d['subgroup'])?></td>
												<td class="text-right">
													<?php echo $this->Form->select(
														'field',
														$d['personas'],
														['empty' => '(Selecciona)','value'=>$d['immediate_boss_id'],'id'=>$d['id']]
													);
													if(!empty($d['immediate_boss_name']) and !array_key_exists($d['immediate_boss_id'], $d['personas']) ){ ?>
														<div style="background-color: #f56954;color: #FFF;padding-right: 15px;margin-top: 7px; font-size: 10px" id="id_<?= $d['id']?>">
															<i class="fa fa-fw fa-ban"></i><b> <?= $d['immediate_boss_name'] ?> </b> No Pertenece a este grupo.
														</div>
														<?php
													}
													?>
												</td>
											</tr>
										<?php
											}
										?>
									</tbody>
								</table>
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

<?php $this->append('script', $this->Html->script(['Immediateboss/index'])); ?>
<?=$this->append('script','<script type="text/javascript">
base_url = "'.$this->Url->build('/ImmediateBoss/update/', true).'";
</script>')?>
