<header class="main-header">
    <nav class="navbar navbar-static-top">
      <div class="container">
        <div class="navbar-header">
          <a href="<?=$this->Url->build('/', true)?>"><?= $this->Html->image('encabezado_menu_fifa.png', ['class' => 'img-responsive center-block']); ?></a>
          <!--<a href="<?=$this->Url->build('/', true)?>" class="navbar-brand"><b>FI.</b>FA</a>-->

          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
            <i class="fa fa-bars"></i>
          </button>
        </div>


        <div class="collapse navbar-collapse pull-left input-group-btn" style="display: flex;" id="navbar-collapse-select-validity">

          <button type="button" style="padding:14px" class="btn btn-warning dropdown-toggle" data-toggle="dropdown">
            Vigencia (<?= isset($vigencia_fifa->name) ? $vigencia_fifa->name : 'Sin vigencias' ?>)
            <span class="fa fa-caret-down"></span>
          </button>
          <ul class="dropdown-menu">
            <?php foreach ($validities as $vigencia): ?>
              <li><a href="/validities/change/<?= $vigencia->id ?>/<?= $_SERVER['REQUEST_URI'] ?>"><?= $vigencia->name ?> </a></li>
              <!--javascript:alert( $vigencia->id );-->
            <?php endforeach; ?>
          </ul>

        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
          <ul class="nav navbar-nav">
			         <?= $menu; ?>
          </ul>
        </div>

        <!-- /.navbar-collapse -->
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
            <!-- Messages: style can be found in dropdown.less-->


            <!-- User Account Menu -->
            <li class="dropdown user user-menu">
              <!-- Menu Toggle Button -->
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <!-- The user image in the navbar-->
                <!-- hidden-xs hides the username on small devices so only the image appears. -->
                <!-- <span class="hidden-xs"><?= $this->request->session()->read('Auth.User.name')?></span> -->
				<span class="glyphicon glyphicon-user"></span>
              </a>
              <ul class="dropdown-menu">
                <!-- The user image in the menu -->
                <li class="user-header" style="height: 80px;">
                  <p>
                    <?= $this->request->session()->read('Auth.User.name')?>
                    <small><?= $this->request->session()->read('Auth.User.charge.name')?></small>
                    <small><?= $this->request->session()->read('Auth.User.group.name')?></small>
                  </p>
                </li>
                <!-- Menu Footer-->
                <li class="user-footer">
                  <div class="pull-left">
                    <?= $this->Html->link(__('Cambiar clave'), ['controller' => 'Home', 'action' => 'profile'],['class'=>'btn btn-default btn-flat']) ?>
                  </div>
                  <div class="pull-right">
					<?= $this->Html->link(__('Cerrar Sesión'), ['controller' => 'Home', 'action' => 'logout'],['class'=>'btn btn-default btn-flat']) ?>
                  </div>
                </li>
              </ul>
            </li>
          </ul>
        </div>
        <!-- /.navbar-custom-menu -->
      </div>
      <!-- /.container-fluid -->
    </nav>
  </header>
