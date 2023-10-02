<?php
$this->append('css', $this->Html->css(['http://maxazan.github.io/jquery-treegrid/css/jquery.treegrid.css']));
$this->append('script', $this->Html->script(['http://maxazan.github.io/jquery-treegrid/js/jquery.treegrid.js']));
$this->append('script','<script type="text/javascript">
$(document).ready(function() {
  $(".tree").treegrid({initialState:"collapsed"});
});
</script>');
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
              <li class="active"><?= $this->Html->link(__('Presupuesto'), ['action' => 'index']) ?></li>
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
            <h3 class="box-title"><?= __('Gestión de Presupuesto')?> </h3>
          </div>
          <!-- /.box-header -->

          <div class="box-body">
            <div class="pull">

              <div class="table-responsive">
                <table class="table table-striped tree">
                  <thead>
                    <tr>
                      <th><?= __('Dependencias') ?></th>
                      <th><?= __('Grupos') ?></th>
                      <th><?= __('SubGrupos') ?></th>
                      <th class="text-right"><?= __('Presupuesto') ?></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach($budgets['dependencies'] as $d){?>
                      <tr class="treegrid-<?= $d['id'] ?> treegrid-parent-<?= $d['parent'] ?>">
                        <td><?= h($d['dependency'])?></td>
                        <td><?= h($d['group'])?></td>
                        <td><?= h($d['subgroup'])?></td>
                        <td class="text-right"><?= $this->Number->format($d['budget']) ?></td>
                      </tr>
                    <?php }
                    ?>
                    <tfoot>
                      <tr >
                        <th>Total Presupuesto</th>
                        <td></td>
                        <td></td>
                        <th class="text-right">
                          <?= $this->Number->format($budgets['budget']); ?>
                        </th>

                      </tr>
                    </tfoot>
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
