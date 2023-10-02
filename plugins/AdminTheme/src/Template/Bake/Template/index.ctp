<%
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
 * @since         0.1.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
use Cake\Utility\Inflector;

$fields = collection($fields)
    ->filter(function($field) use ($schema) {
        return !in_array($schema->columnType($field), ['binary', 'text']);
    });

if (isset($modelObject) && $modelObject->behaviors()->has('Tree')) {
    $fields = $fields->reject(function ($field) {
        return $field === 'lft' || $field === 'rght';
    });
}
%>
<div class="row">
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title"><?= __('<%= $pluralHumanName %>'); ?></h3>

                <div class="pull-right">
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                            <?= __('Actions'); ?>&nbsp;
                            <span class="fa fa-caret-down"></span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li><?= $this->Html->link(__('New <%= $singularHumanName %>'), ['action' => 'add']); ?></li>
<%
    $done = [];
    foreach ($associations as $type => $data):
        foreach ($data as $alias => $details):
            if (!empty($details['navLink']) && $details['controller'] !== $this->name && !in_array($details['controller'], $done)):
%>
                            <li><?= $this->Html->link(__('List <%= $this->_pluralHumanName($alias) %>'), ['controller' => '<%= $details['controller'] %>', 'action' => 'index']); ?></li>
                            <li><?= $this->Html->link(__('New <%= $this->_singularHumanName($alias) %>'), ['controller' => '<%= $details['controller'] %>', 'action' => 'add']); ?></li>
<%
                $done[] = $details['controller'];
            endif;
        endforeach;
    endforeach;
%>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="box-body table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                    <tr>
<% foreach ($fields as $field): %>
                        <th class="text-center"><?= $this->Paginator->sort('<%= $field %>'); ?></th>
<% endforeach; %>
                        <th class="text-center"><?= __('Actions'); ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($<%= $pluralVar %> as $<%= $singularVar %>): ?>
                        <tr>
<% foreach ($fields as $field) {
    $isKey = false;
    if (!empty($associations['BelongsTo'])) {
        foreach ($associations['BelongsTo'] as $alias => $details) {
            if ($field === $details['foreignKey']) {
                $isKey = true;
%>
                            <td class="text-center"><?= $<%= $singularVar %>->has('<%= $details['property'] %>') ? $this->Html->link($<%= $singularVar %>-><%= $details['property'] %>-><%= $details['displayField'] %>, ['controller' => '<%= $details['controller'] %>', 'action' => 'view', $<%= $singularVar %>-><%= $details['property'] %>-><%= $details['primaryKey'][0] %>]) : '' ?></td>
<%
                break;
            }
        }
    }
    if ($isKey !== true) {
        if (in_array($schema->columnType($field), ['boolean'])) {
%>
                            <td class="text-center"><?= $<%= $singularVar %>-><%= $field %> ? __('<i class="fa fa-check text-green"></i>') : __('<i class="fa fa-times text-red"></i>'); ?></td>
<%
        } elseif (!in_array($schema->columnType($field), ['integer', 'biginteger', 'decimal', 'float'])) {
%>
                            <td class="text-center"><?= h($<%= $singularVar %>-><%= $field %>) ?></td>
<%
        } else {
%>
                            <td class="text-center"><?= $this->Number->format($<%= $singularVar %>-><%= $field %>) ?></td>
<%
        }
    }
}

$pk = '$' . $singularVar . '->' . $primaryKey[0];
%>
                            <td class="text-center">
                                <?= $this->Html->link(__('<i class="glyphicon glyphicon-eye-open"></i>'), ['action' => 'view', <%= $pk %>], ['class' => 'btn btn-primary btn-xs', 'escape' => false, 'data-toggle' => 'tooltip', 'title' => 'view']); ?>
                                <?= $this->Html->link(__('<i class="glyphicon glyphicon-pencil"></i>'), ['action' => 'edit', <%= $pk %>], ['class' => 'btn btn-warning btn-xs', 'escape' => false, 'data-toggle' => 'tooltip', 'title' => 'edit']); ?>
                                <?= $this->Form->postLink(__('<i class="glyphicon glyphicon-trash"></i>'), ['action' => 'delete', <%= $pk %>], ['confirm' => __('Are you sure you want to delete # {0}?', <%= $pk %>), 'class' => 'btn btn-danger btn-xs', 'escape' => false, 'data-toggle' => 'tooltip', 'title' => 'delete']); ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-4">
                        <div class="dataTables_info pagination"><?= $this->Paginator->counter('Showing {{start}} to {{end}} of {{count}} entries'); ?></div>
                    </div>
                    <div class="col-xs-8">
                        <div class="dataTables_paginate paging_simple_numbers">
                            <ul class="pagination pull-right">
                                <li class="paginate_button previous disabled">
                                    <?= $this->Paginator->prev('← ' . __('Previous')); ?>
                                </li>
                                <?= $this->Paginator->numbers() ?>
                                <li class="paginate_button next">
                                    <?= $this->Paginator->next(__('Next') . ' →'); ?>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
