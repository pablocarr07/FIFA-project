<ul class="timeline">
<?php foreach($timeline as $t){ ?>
    <!-- timeline time label -->
    <li class="time-label">
        <span class="bg-red">
           <?= $t['created']?>
        </span>
    </li>
    <!-- /.timeline-label -->

    <!-- timeline item -->
    <li>
        <!-- timeline icon -->
        <i class="fa fa-check bg-blue"></i>
        <div class="timeline-item">
            <span class="time"><i class="fa fa-clock-o"></i>  <?= $t['createdFull']->i18nFormat('yyyy-MM-dd HH:mm:ss')?></span>
            <h3 class="timeline-header"><a href="#"><?= $t['created_by']['name']?> Cambio el Estado dela solicitud de CDP a <?=$t['cdpsstate']['name']?> </a></h3>
            <div class="timeline-body">
                <?= $t['commentary']?>
            </div>            
        </div>
    </li>
    <!-- END timeline item -->
<?php }?>
</ul>