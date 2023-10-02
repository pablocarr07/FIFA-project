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
          <h3 class="box-title"><?= __('Crear Grupo') ?> </h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="pull">


            <?= $this->Form->create($group); ?>
            <?php
            // echo $this->Form->input('dependency_id', ['options' => $dependencies,'label'=>'Dependencia']);
            // echo $this->Form->input('name',['label'=>'Grupo']);
            // echo $this->Form->input('parent_id', ['options' => $parentGroups,'empty' => '(choose dependency)','label'=>'Padre']);
            // echo $this->Form->input('budget',['label'=>'Presupuesto']);

            echo $this->Form->input('dependency_id', ['options' => $dependencies, 'default' => $dependency_id, 'label' => 'Dependencia']);
            echo $this->Form->input('name', ['label' => 'Grupo']);
            echo $this->Form->input('parent_id', ['options' => $parentGroups, 'empty' => '(choose group)', 'label' => 'Padre']);
            echo $this->Form->input('budget', ['label' => '', 'value' => 0, 'style' => 'display:none']);
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