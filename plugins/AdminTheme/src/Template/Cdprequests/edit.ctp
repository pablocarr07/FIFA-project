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
                    <h3 class="box-title"><?= __('Editar Solicitud de CDP ') . ($cdprequest->migracion_id ? $cdprequest->migracion_id : $cdprequest->id) ?></h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="pull">

                        <?= $this->Form->create($cdprequest); ?>
                        <fieldset>
                            <?php
                            echo $this->Form->input('applicant_id', array('options' => $applicants, 'label' => 'Solicitante', 'empty' => '(Elegir Solicitante)'));
                            echo $this->Form->input('movement_type', array('label' => 'Tipo de Movimiento', 'options' => $movementTypes, 'empty' => '(Elegir Tipo de Movimiento)'));
                            echo $this->Html->link('<span class="glyphicon glyphicon-plus-sign"></span><span class="sr-only"></span> ' . __('Adicionar Rubro'), [$cdprequest->id], ['escape' => false, 'class' => 'btn btn-sm btn-warning', 'id' => 'modal_add', 'title' => __('Adicionar Rubro')]);
                            ?>
                            <div class="box-body">
                                <table class="table table-bordered table-items">
                                    <thead>
                                        <tr>
                                            <th style="width: 20%">Clase de Gasto</th>
                                            <th style="width: 20%">Rubro Agregado</th>
                                            <th style="width: 20%">Rubro Desagregado</th>
                                            <th style="width: 20%">Recursos</th>
                                            <th style="width: 20%">Tareas</th>
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
                            echo $this->Form->input('object', array('type' => 'textarea', 'label' => 'Objeto'));
                            echo $this->Form->input('justification', array('type' => 'textarea', 'label' => 'Justificación'));
                            // echo $this->Form->input('state', array('type' => 'checkbox','label' => 'borrador'));
                            ?>
                            <div class="form-group iCheck-input">
                                <?= $this->Form->input('state', array('type' => 'checkbox', 'label' => 'borrador')); ?>
                            </div>
                        </fieldset>
                        <?= $this->Form->button(__('Submit'), ['class' => 'btn-success']) ?>
                        <?= $this->Form->end() ?>
                    </div>
                </div>




            </div>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>








<div class="modal fade" tabindex="-1" role="dialog" id="myModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?= __('Adicionar Rubro') ?></h4>
            </div>
            <div class="modal-body">

                <form id="formItems">
                    <div class="form-group">
                        <?= $this->Form->input('itemstypes_id', array('options' => $itemstypes, 'label' => 'Clase de Gasto', 'required' => 'required', 'empty' => '(Elegir Clase de Gasto)')); ?>
                    </div>
                    <div class="form-group">
                        <?= $this->Form->input('classifications_id', array('options' => [], 'label' => 'Rubro Agregado', 'required' => 'required')); ?>
                    </div>
                    <div class="form-group">
                        <?= $this->Form->input('items_id', array('options' => [], 'label' => 'Rubro Desagregado', 'required' => 'required')); ?>
                    </div>
                    <div class="form-group">
                        <?= $this->Form->input('resources_id', array('options' => $resources, 'label' => 'Recurso', 'required' => 'required', 'empty' => '(Elegir Recurso)')); ?>
                    </div>
                    <div class="form-group">
                        <?= $this->Form->input('values_id', array('label' => 'Valor', 'type' => 'text', 'class' => 'value', 'required' => 'required')); ?>
                    </div>
                    <div id="output"></div>
                </form>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-primary addItems"><?= __('Adicionar') ?></a>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->



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
$this->append('script', $this->Html->script(['NumeroALetras', 'jquery-number/jquery.number.min', 'cdprequests/edit']));
$this->append('script', '<script type="text/javascript">   
    var base_url = "' . $this->Url->build("/cdprequests/", true) . '";
    var itemsTotal = 0;
    var itemsdata = ' . $itemsdata . ';
</script>');
?>