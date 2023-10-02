<div class="panel panel-default">
  <div class="panel-heading">
    <?= __('Audits')?>
  </div>
  <div class="panel-body">
<table class="table table-striped" cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th><?= $this->Paginator->sort('event');?></th>
            <th><?= $this->Paginator->sort('source_id', 'By');?></th>
            <th><?= $this->Paginator->sort('model', 'Resource');?></th>
            <th>Identifier</th>
            <th><?= $this->Paginator->sort('delta_count', 'Changes');?></th>
            <th><?= $this->Paginator->sort('created');?></th>
            <th class="actions"><?= __('Actions');?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($audits as $audit): ?>
        <tr>
            <td><?=
                $this->AuditLog->getEvent($audit);
            ?></td>
            <td><?= $this->Html->link(
                $this->AuditLog->getSource($audit),
                [
                    'action' => 'index',
                    '?' => [
                        'source_id' => $audit->source_id
                    ]
                ]
            ); ?>&nbsp;</td>
            <td><?= $this->Html->link(
                __($audit->model),
                [
                    'action' => 'index',
                    '?' => [
                        'model' => $audit->model
                    ]
                ]
            ); ?></td>
            <td><?= $this->Html->link(
                $this->AuditLog->getIdentifier($audit),
                [
                    'action' => 'index',
                    '?' => [
                        'model' => $audit->model,
                        'entity_id' => $audit->entity_id
                    ]
                ]
            ); ?></td>
            <td><?=
                $this->Number->format($audit->delta_count)
            ?></td>
            <td><span title="<?= $audit->created; ?>"><?=
                $this->Time->timeAgoInWords($audit->created)
            ?></span></td>

            <td class="actions">
                <?= $this->Html->link(
                    '',
                    [
                        'action' => 'view',
                        $audit->id
                    ],
                    [
                        'title' => __('View'),
                        'class' => 'btn btn-default glyphicon glyphicon-eye-open'
                    ]
                ) ?>
            </td>
        </tr>

        <?php endforeach; ?>
    </tbody>
   </table>
    <div class="paginator">
    <?= $this->Paginator->numbers([
        'prev' => true,
        'next' => true
    ]) ?>
    <p><?= $this->Paginator->counter() ?></p>
    </div>
  </div>
</div>