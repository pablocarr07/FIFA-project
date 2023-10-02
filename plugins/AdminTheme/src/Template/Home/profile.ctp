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
              <li><?= $this->Html->link(__('Perfil'), ['action' => 'profile']) ?>
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
              <h3 class="box-title"><?= __('Perfil')?> </h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="pull">
                <?= $this->Form->create($user); ?>
                <div class="form-group">
                  <label for="inputName" class="col-sm-3 control-label"><?=__('Tipo de Identificación')?></label>
                  <div class="col-sm-9">
                    <label for="inputName" class="control-label"><?= $user->types_identification->name?></label>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputName" class="col-sm-3 control-label"><?=__('Identificación')?></label>
                  <div class="col-sm-9">
                    <label for="inputName" class="control-label"><?= $user->identification?></label>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputName" class="col-sm-3 control-label"><?=__('Nombre')?></label>
                  <div class="col-sm-9">
                    <label for="inputName" class="control-label"><?= $user->name?></label>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputName" class="col-sm-3 control-label"><?=__('Email')?></label>
                  <div class="col-sm-9">
                    <label for="inputName" class="control-label"><?= $user->email?></label>
                  </div>
                </div>
                <!-- <div class="form-group">
                  <label for="inputName" class="col-sm-3 control-label"><?=__('Grupo')?></label>
                  <div class="col-sm-9">
                    <label for="inputName" class="control-label"><?php // = $user->group->name ?></label>
                  </div>
                </div> -->
                <div class="form-group">
                  <label for="inputName" class="col-sm-3 control-label"><?=__('Tipo')?></label>
                  <div class="col-sm-9">
                    <label for="inputName" class="control-label">
                      <?= $user->has('type') ? $user->type->name : '' ?>
                    </label>
                  </div>
                </div>

                <!--
                <div class="form-group">
                <label for="inputName" class="col-sm-3 control-label"><?=__('Cargo')?></label>
                <div class="col-sm-9">
                <label for="inputName" class="control-label">
                <?= $user->charge->name?>
              </label>
            </div>
          </div>
        -->
        <div class="form-group">
          <label for="inputName" class="col-sm-3 control-label"><?=__('Contraseña Actual')?></label>
          <div class="col-sm-9">
            <label for="inputName" class="control-label">
              <?= $this->Form->input('passwordActual',['type'=>'password','label'=>false,'required'=>'required','value'=>'']); ?>
            </label>
          </div>
        </div>


        <div class="form-group">
          <label for="inputName" class="col-sm-3 control-label"><?=__('Contraseña')?></label>
          <div class="col-sm-9">
            <label for="inputName" class="control-label">
              <?= $this->Form->input('password',['label'=>false,'type'=>'password','required'=>'required','value'=>'']); ?>
            </label>
          </div>
        </div>

        <div class="form-group">
          <label for="inputName" class="col-sm-3 control-label"><?=__('Repita Contraseña')?></label>
          <div class="col-sm-9">
            <label for="inputName" class="control-label">
              <?= $this->Form->input('passwordRepeat',['type'=>'password','label'=>false,'required'=>'required','value'=>'']); ?>
            </label>
          </div>
        </div>


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
