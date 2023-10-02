<section class="content">
  <div class="row">

    <!-- /.col -->
    <div class="col-md-12">

      <div class="box box-default">

        <div class="box-header with-border">
          <h3 class="box-title">Así va su Gasto </h3>
        </div>
        <!-- /.box-header -->

        <?= $this->Form->create('',['id'=>'formasivasugasto']); ?>

          <div class="box-body">

            <div class="pull-right">
              <?= $this->Form->button(__('Filtros'), ['class' => 'btn-info','id'=>'filtro']) ?>
            </div>

            <?php

              if(!empty($dependencies)):
                echo $this->Form->input('dependency_1',['label'=>'Dependencia','multiple'=>'multiple','options'=>$dependencies,'empty' => '(choose dependency 1)','required'=>'required']);
                echo $this->Form->input('dependency',['label'=>'Dependencia','options'=>$dependencies,'empty' => '(choose dependency 2)','required'=>'required']);
              endif;

              if(!empty($group)):
                echo $this->Form->input('group',['label'=>'Grupo','options'=> $group ]);
                echo $this->Form->input('subgroup',['label'=>'Subgrupo','options'=> $subgroup]);
              endif;

              echo $this->Form->input('concepts',['label'=>'Concepto','multiple'=>'multiple','options'=> $documento_soporte ,'required'=>'required']);
              echo $this->Form->input('typeReport',['label'=>'Tipo Reporte','options'=>['general'=>'General','detallado'=>'Detallado']]);

            ?>

            <div class="progress progress-sm" id="progress-bar" style="display:none">
              <div class="progress-bar progress-bar-danger progress-bar-striped active" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                <span class="sr-only">100% Complete (warning)</span>
              </div>
            </div>

          </div>
          <!-- /.box-body -->

          <div class="box-footer">

            <div class="pull-right">
              <?= $this->Form->button(__('Submit'), ['class' => 'btn-success']) ?>
            </div>

          </div>
          <!-- /.box-footer -->

        <?= $this->Form->end() ?>

      </div>

      <div class="box-header with-border" id="descargar">
        <div class="mailbox-controls">

          <div class="btn-group">
            <?= $this->Html->link('<i class="fa fa-download"></i>',['action' => 'index'],['escape'=>false,'class'=>'btn export_excel btn-default','data-toggle' => 'tooltip', 'title' => __('Exportar Excel')]);?>
          </div>

        </div>
      </div>

      <div class="table-responsive">

        <table  class="table table-striped" id="reportgeneral">
          <thead>
            <tr>
              <th><span data-toggle="tooltip" title =""><?= __('__')?></span></th>
              <th><span data-toggle="tooltip" title =""><?= __('Total Rp')?> </span></th>
              <th><span data-toggle="tooltip" title =""><?= __('Total Pagado')?> </span></th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>

        <table  class="table table-striped" id="reportdetallado">
          <thead>
            <tr>
              <th><span data-toggle="tooltip" title =""><?= __('Concepto')?> </span></th>
              <th><span data-toggle="tooltip" title =""><?= __('Número Documento')?> </span></th>
              <th><span data-toggle="tooltip" title =""><?= __('Terceros')?> </span></th>
              <th><span data-toggle="tooltip" title =""><?= __('Fecha')?> </span></th>
              <th><span data-toggle="tooltip" title =""><?= __('Rubro')?> </span></th>
              <th><span data-toggle="tooltip" title =""><?= __('V. Rp')?> </span></th>
              <th><span data-toggle="tooltip" title =""><?= __('V. Pagado')?> </span></th>
              <th><span data-toggle="tooltip" title =""><?= __('Conceptos')?> </span></th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>

    </div>
      <!-- /.col -->

  </div>
  <!-- /.row -->
</section>

<?php
  $this->append(
    'script',
    '<script type="text/javascript">
      var base_url = "'.$this->Url->build("/asi-va-su-gasto/").'";
      var export_excel={"data":"","filename":"asi_va_su_gasto.xls","base_url":base_url};
    </script>'
  );

  $this->append('script', $this->Html->script(['asi-va-su-gasto/index','jquery-number/jquery.number.min','export_excel']));

?>


