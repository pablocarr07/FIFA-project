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
                                        <th style="width: 20%">Rubro Agregado</th>
                                        <th style="width: 20%">Rubro Desagregado</th>
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

                        <?= $this->Html->link('<span class="glyphicon glyphicon-ok"></span><span class="sr-only">'
                            . __('Aprobar') . '</span>', ['action' => '#'], ['escape' => false, 'class' => 'btn btn-lg btn-success accion', 'id' => 'aprobar', 'title' => __('Aprobar')]) ?>

                        <?= $this->Html->link('<span class="glyphicon glyphicon-remove"></span><span class="sr-only">'
                            . __('Cancelar') . '</span>', ['action' => '#'], ['escape' => false, 'class' => 'btn btn-lg btn-danger accion', 'id' => 'cancelar', 'title' => __('Cancelar')]) ?>

                        <?= $this->Html->link('<span class="glyphicon glyphicon-pencil"></span><span class="sr-only">'
                            . __('Modificar') . '</span>', ['action' => '#'], ['escape' => false, 'class' => 'btn btn-lg btn-primary accion', 'id' => 'modificar', 'title' => __('Modificar')]) ?>
                        <?= $this->Form->end() ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>




<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><span id="accion_label"></span> Solicitud de CDP <?= h($cdprequest->id) ?></h4>
            </div>
            <?= $this->Form->create($cdprequest, array('url' => '#', 'id' => 'form', 'enctype' => 'multipart/form-data')); ?>
            <div class="modal-body">

                <div class="container-fluid bd-example-row">
                    <div class="row">
                        <div class="form-group">
                            <div class="col-sm-12">
                                <?= $this->Form->input('commentary', array('type' => 'textarea', 'label' => 'Comentario')); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <?= $this->Form->input('certificate', array('type' => 'file', 'label' => 'Cerficado')); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?= $this->Form->input('id', array('type' => 'hidden', 'value' => h($cdprequest->id))); ?>
                <div class="box-body">
                    <div class="alert alert-dismissible">

                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary">Continuar</button>
            </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>

<?php $this->append('script', $this->Html->script(['NumeroALetras', 'jquery-number/jquery.number.min', 'cdpapprovesgeneralsecretary/view'])); ?>
<?= $this->append('script', '<script type="text/javascript">
    base_url = "' . $this->Url->build('/cdpapprovesgeneralsecretary/', true) . '";
    var itemsdata = ' . $itemsdata . ';
</script>') ?>