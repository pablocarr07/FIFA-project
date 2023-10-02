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
                        <li><?= $this->Html->link(__('Listar'), ['action' => 'index', '?' => ['state-id' => @$state_id]]) ?></li>
                        <li><?= $this->Html->link(__('Dashboard'), ['controller' => 'Cdprequestsdashboard', 'action' => 'index']) ?></li>
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
                    <h3 class="box-title"><?= __('Ver Solicitud de CDP ') . ($cdprequest->migracion_id ? $cdprequest->migracion_id : $cdprequest->id) ?></h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="pull">

                        <?= $this->Form->create($cdprequest); ?>
                        <?php
                        echo $this->Form->input('applicant_id', array('options' => $applicants, 'label' => 'Solicitante', 'empty' => '(Elegir Solicitante)', 'readonly' => 'readonly'));
                        echo $this->Form->input('movement_type', array('label' => 'Tipo de Movimiento', 'options' => $movementTypes, 'empty' => '(Elegir Tipo de Movimiento)', 'readonly' => 'readonly'));
                        echo $this->Form->input('object', array('type' => 'textarea', 'label' => 'Objeto', 'readonly' => 'readonly'));
                        echo $this->Form->input('justification', array('type' => 'textarea', 'label' => 'Justificación', 'readonly' => 'readonly'));
                        ?>
                        <div class="box-body">
                            <table class="table table-bordered table-items">
                                <thead>
                                    <tr>
                                        <th style="width: 20%">Clase de Gasto</th>
                                        <th style="width: 20%">Cuenta/Proyecto</th>
                                        <th style="width: 20%">Rubros</th>
                                        <th style="width: 20%">Recursos</th>
                                        <th style="width: 20%">Actividad / Proyecto</th>
                                        <th style="width: 20%">Valor</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="5"><sup><b>Son.</b> </sup> <span class="totalItemsLetters"> </span></td>
                                        <td class="valueFormat totalItems"></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <?php
                        echo $this->Form->input('state', array('label' => 'Estado', 'readonly' => 'readonly'));
                        ?>
                        </fieldset>
                        <?= $this->Form->end() ?>
                    </div>
                </div>




            </div>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>



<style>
    .table thead th {
        text-align: center;
    }

    .valueFormat,
    .value {
        text-align: right;
    }

    .select2-dropdown {
        z-index: 15000;
    }
</style>




<?php
$this->append('script', $this->Html->script(['NumeroALetras', 'jquery-number/jquery.number.min']));

$this->append('script', '<script type="text/javascript">
    var itemsTotal = 0;
    var itemsdata = ' . $itemsdata . ';

    $(document).ready(function() {
    $(".select2").css({"width":"100%"});
    $("select").select2("enable", true);
    $("#values-id").number( true, 2 );
    $.each(itemsdata, function( i, add_item){
      addItemsTable(add_item);
    });

  });

function addItemsTable(add_item){
    tasks="";
    if(add_item.itemstypes.id==2){
        $.each(add_item.tasks,function(i,v){
             tasks+=""+v.name+"<br>";
        })
    }
    itemsTotal=parseFloat(itemsTotal)+parseFloat(add_item.value);
    $(".table-items tbody").append("<tr><td>"+add_item.itemstypes.name+"</td><td>"+add_item.classifications.name+"</td><td>" + add_item.items.item + " " + add_item.items.name+"</td><td>"+add_item.resources.name+"</td><td>"+tasks+"</td><td class=\'valueFormat\'>"+add_item.value+"</td></tr>");    
    
    valores(itemsTotal);
}

function valores(itemsTotal){
    $(".totalItemsLetters").html(NumeroALetras(itemsTotal));    
    $(".totalItems").html(itemsTotal);
    $(".valueFormat").number( true, 2 );
}

</script>');
?>