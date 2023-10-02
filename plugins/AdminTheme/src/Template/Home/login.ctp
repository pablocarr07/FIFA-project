
<div class="login-box">
    <div class="login-logo">
	  <?= $this->Html->image('encabezado_web_fifa.png', ['class' => 'img-responsive center-block']); ?>
    </div>
    <div class="login-box-body">
		<!--
        <p class="login-box-msg">&nbsp;&nbsp;</p>
	-->
		 <p></p>
        <?= $this->Flash->render() ?>

        <?= $this->Form->create(); ?>
        <div class="form-group has-feedback">
            <?= $this->Form->input('username', ['class' => 'form-control', 'placeholder' => __('Usuario'), 'label' => false]); ?>
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
        </div>

        <div class="form-group has-feedback">
            <?= $this->Form->input('password', ['class' => 'form-control', 'placeholder' => __('Contraseña'), 'label' => false]); ?>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>

        <div class="row">
		<!--
            <div class="col-xs-8">
                <div class="form-group iCheck-input">
                    <?= $this->Form->input('remember_me', ['type' => 'checkbox', 'class' => 'form-control']); ?>
                </div>
            </div>
		-->
            <div class="col-xs-4">

  <?= $this->Form->button(__('Iniciar'), ['class' => 'btn btn-primary btn-block btn-flat']); ?>

<!--
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">Open modal for @mdo</button>
                -->
            </div>
        </div>

        <?= $this->Form->end(); ?>

        
           <!-- <?= $this->Html->link(__('Olvidé mi contraseña'), []); ?>-->
    </div>
</div>


    </div>
</div>
