<div class="panel panel-default">
  <div class="panel-heading">
    <?= __('Audit Log')?>
  </div>
  <div class="panel-body">
    <dl class="dl-horizontal">
        <dt><?= __('Id'); ?></dt>
        <dd><?= h($audit->id)?></dd>

        <dt><?= __('Event type'); ?></dt>
        <dd><?= h($audit->event)?></dd>

        <dt><?= __('Model'); ?></dt>
        <dd><?= h($audit->model)?></dd>

        <dt><?= __('Model id'); ?></dt>
        <dd><?= h($audit->entity_id)?></dd>

        <dt><?= __('Description'); ?></dt>
        <dd><?= h($audit->description)?></dd>

        <dt><?= __('Source Id'); ?></dt>
        <dd><?= h($audit->source_id)?></dd>

        <dt><?= __('Source Ip'); ?></dt>
        <dd><?= h($audit->source_ip)?></dd>

        <dt><?= __('Source Url'); ?></dt>
        <dd><?= h($audit->source_url)?></dd>

        <dt><?= __('Deltas'); ?></dt>
        <dd><?=
            $this->Number->format($audit->delta_count)
        ?></dd>

        <dt><?= __('Created'); ?></dt>
        <dd><?= $audit->created?></dd>
    </dl>
  </div>
</div>

<div class="panel panel-default">
  <div class="panel-heading">
    <i class="halflings-icon list"></i><span class="break"></span><?= __('Categorize Logs'); ?>
  </div>
  <div class="panel-body">
     <?php if (!empty($audit->audit_deltas)): ?>
    <dl class="dl-horizontal">

        </tr>
        <?php foreach ($audit->audit_deltas as $auditDeltas): ?>
        <dt><?= __('Field'); ?></dt>
        <dd><?=
            h($auditDeltas->property_name)
        ?></dd>

        <dt><?= __('Diff') ?></dt>
        <dd><?= $this->AuditLog->getDiff(
                $auditDeltas->property_name,
                $auditDeltas->old_value,
                $auditDeltas->new_value
            ) ?>
        </dd>
        <?php endforeach; ?>
    </dl>
    <?php endif; ?>
  </div>
</div>
<style type="text/css">
    del {
        background-color: #f2dede;
    }

    ins {
        color: #3c763d;
        background-color: #dff0d8;
        text-decoration: none;
        border: 1px solid #d6e9c6;
    }

    table.Differences {
        width: 100%;
        font-weight: normal;
    }

    table.Differences th,
    table.Differences td,
    .table tbody tbody {
        border-top: none;
        font-weight: normal;
    }

    td.Left {
        width: 40%;
        margin-right: 0px;
    }

    td.Right {
        width: 40%;
        margin-left: 5px;
    }

    tbody.ChangeInsert {
        background-color: #dff0d8;
    }

    tbody.ChangeDelete {
        background-color: #f2dede;
    }

    tbody.ChangeReplace {
        background-color: #fcf8e3;
    }

    tbody.ChangeInsert th,
    tbody.ChangeDelete th,
    tbody.ChangeReplace th {
        width: 2%;
        background-color: #eee;
        text-align: center;
    }

    tbody.ChangeInsert td,
    tbody.ChangeDelete td,
    tbody.ChangeReplace td {
        width: 48%;
    }

    </style>