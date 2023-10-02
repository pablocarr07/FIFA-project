<!-- Ionicons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">

<div class="box-header">
  <div class="pull-right">
    <?= $this->Html->link('<span class="glyphicon glyphicon-plus-sign"></span><span class="sr-only"></span> ' . __('Nueva Solicitud de CDP'), ['controller' => 'cdprequests', 'action' => 'add'], ['escape' => false, 'class' => 'btn btn-lg btn-warning', 'id' => 'modal_add', 'title' => __('Nueva Solicitud de CDP')]); ?>
  </div>
</div>

<?php
foreach ($cdprequests as $key => $cdp) {
  if ($cdp['data']->count() > 0) {
    echo '<div class="col-lg-4">
          <!-- small box -->
          <div class="small-box bg-' . $cdp['color'] . '">
            <div class="inner">
              <h3>' . $cdp['data']->count() . '</h3>
              <p>' . $cdp['name'] . '&nbsp;</p>
            </div>
            <div class="icon">
              <i class="ion ' . $cdp['icon'] . '"></i>
            </div>
            ' . $this->Html->link(
      'ir &nbsp;&nbsp;<i class="fa fa-arrow-circle-right"></i>',
      ['controller' => $cdp['url']],
      ['class' => 'small-box-footer', 'escape' => false]
    ) . '
            </div>
        </div>';
  }
}; ?>