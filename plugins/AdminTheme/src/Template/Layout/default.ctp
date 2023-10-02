<?php

/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
?>
<?php
  $url = explode('/',$_SERVER['REQUEST_URI']);

  if (isset($url[2]) && isset($url[3])) {
    $module= __($url[2]);
    $action= __($url[3]);

    $this->Html->addCrumb('
      <li>
        <a href="#">
          <i class="fa fa-home"></i>
        </a>
      </li>
      <li>
        <a href="#">'.$module.'</a>
      </li>
      <li class="active">'.$action.'</li>
    ',
    null
    );

  }
?>

<!doctype html>
<html>
    <head>
    <?= $this->Html->charset(); ?>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>
        <?= $this->fetch('title'); ?>
        </title>
    <?= $this->Html->meta('icon'); ?>
    <?= $this->fetch('meta'); ?>
    <?= $this->Html->css('bootstrap/bootstrap.min'); ?>
    <?= $this->Html->css('bootstrap-datetimepicker/bootstrap-datetimepicker.min'); ?>
    <?= $this->Html->css('iCheck/all.css'); ?>
    <?= $this->Html->css('https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css'); ?>
    <?= $this->Html->css('skins/_all-skins.min'); ?>
    <?= $this->Html->css('select2/select2.min.css'); ?>
    <?= $this->Html->css('AdminLTE'); ?>
    <?= $this->fetch('css'); ?>
	<?= $this->Html->css('https://fonts.googleapis.com/css?family=Montserrat');?>
	<?= $this->Html->css('default');?>

    </head>
    <body class="hold-transition skin-red layout-top-nav">
        <div class="wrapper">
       <?= $this->element('top_menu'); ?>
		<?php $this->element('left_sidebar'); ?>
            <div class="content-wrapper">
                <div class="container">
                    <section class="content-header">
                        <h1>
          <!-- <? //= $module?> -->
                        </h1>

                        <ol class="breadcrumb">
         <!-- <? //= $this->Html->getCrumbs();?> -->
                        </ol>
                    </section>
                    <section class="content">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="box box-solid">
                                    <div class="box-body">
                                        <div class="form-group">
                <?= $this->Flash->render() ?>
                <?= $this->fetch('content') ?>


                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>

            <footer class="main-footer">
                <strong>FI.FA Financiera Facil Copyright &copy; <?= date('Y'); ?></strong> All rights reserved.
            </footer>
		<?= $this->Html->script('jQuery/jQuery-2.1.4.min'); ?>
    <?= $this->Html->script('bootstrap/bootstrap.min'); ?>
    <?= $this->Html->script('momentjs/moment-with-locales.min'); ?>
    <?= $this->Html->script('bootstrap-datetimepicker/bootstrap-datetimepicker.min'); ?>
    <?= $this->Html->script('icheck/icheck.min'); ?>
    <?= $this->Html->script('slimScroll/jquery.slimscroll'); ?>
    <?= $this->Html->script('AdminLTE/app'); ?>
    <?= $this->Html->script('select2/select2.full.min.js'); ?>
	<?=$this->append('script','<script type="text/javascript">
	var select2="";
	select2=$("select").select2();
      $(document).ready(function() { })</script>')?>
   <?= $this->fetch('script'); ?>
    </body>
</html>

