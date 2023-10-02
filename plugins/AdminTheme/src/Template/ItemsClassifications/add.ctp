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
              <li class="active"><?= $this->Html->link(__('Crear'), ['action' => 'add']) ?></li>
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
            <h3 class="box-title"><?= __('Crear Cuentas o Proyectos')?> </h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <div class="pull">


              <?= $this->Form->create($itemsClassification); ?>
              <?php
              echo $this->Form->input('parent_id', ['options' => $parentItemsClassifications, 'empty' => '(Elegir Padre)', 'label'=>'Padre', 'onchange' => 'javascript:cambio(this);']);
              echo $this->Form->input('name', ['label'=>'Nombre'] );
              echo $this->Form->input('item_type_id', ['options' => $itemsTypes, 'class' => 'lstItemType', 'empty'=>'(Elegir Clase de Gasto)', 'label'=>'Clase de Gasto', 'required']);
              ?>

              <!-- /.box-body -->
              <div class="box-footer">
                <div class="pull-right">
                  <?= $this->Form->button(__('Submit'), ['class' => 'btn-success']) ?>
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

  <?= $this->Html->script('jQuery/jQuery-2.1.4.min'); ?>

  <script type="text/javascript">

  $('.lstItemType').click(function(){
  });

  function cambio(element) {

    if (element.value != '') {

      $($('.lstItemType option:eq(1)')).attr('selected', 'selected')
      $('.lstItemType').val(1);
      $($('.lstItemType')).trigger('click');

      let textoListaItemType = $('.lstItemType option:eq(1)')[0].label
      $('#select2-item-type-id-container').attr('title', textoListaItemType);
      $('#select2-item-type-id-container').html(textoListaItemType);

      $($('.lstItemType')[0].parentElement).css("visibility", "hidden");

    } else {

      $($('.lstItemType')[0].parentElement).css("visibility", "visible");

      $($('.lstItemType option:eq(0)')).attr('selected', 'selected')
      $('.lstItemType').val(0);
      $($('.lstItemType')).trigger('click');

      let textoListaItemType = $('.lstItemType option:eq(0)')[0].label
      $('#select2-item-type-id-container').attr('title', textoListaItemType);
      $('#select2-item-type-id-container').html(textoListaItemType);

    }
  }

  </script>
