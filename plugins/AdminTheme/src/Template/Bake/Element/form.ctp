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
        return $schema->columnType($field) !== 'binary';
    });

if (isset($modelObject) && $modelObject->behaviors()->has('Tree')) {
    $fields = $fields->reject(function ($field) {
        return $field === 'lft' || $field === 'rght';
    });
}
%>
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title"><?= __('<%= Inflector::humanize($action) %> <%= $singularHumanName %>') ?></h3>

                <div class="pull-right">
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                            <?= __('Actions'); ?>&nbsp;
                            <span class="fa fa-caret-down"></span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-right">
<% if (strpos($action, 'add') === false): %>
                            <li><?= $this->Form->postLink(__('Delete'),
                                    ['action' => 'delete', $<%= $singularVar %>-><%= $primaryKey[0] %>],
                                    ['confirm' => __('Are you sure you want to delete # {0}?', $<%= $singularVar %>-><%= $primaryKey[0] %>)]); ?></li>
<% endif; %>
                            <li><?= $this->Html->link(__('List <%= $pluralHumanName %>'), ['action' => 'index']); ?></li>
<%
    $done = [];
    foreach ($associations as $type => $data) {
        foreach ($data as $alias => $details) {
            if ($details['controller'] !== $this->name && !in_array($details['controller'], $done)) {
%>
                            <li><?= $this->Html->link(__('List <%= $this->_pluralHumanName($alias) %>'), ['controller' => '<%= $details['controller'] %>', 'action' => 'index']); ?></li>
                            <li><?= $this->Html->link(__('New <%= $this->_singularHumanName($alias) %>'), ['controller' => '<%= $details['controller'] %>', 'action' => 'add']); ?></li>
<%
                $done[] = $details['controller'];
            }
        }
    }
%>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="box-body">
                <?= $this->Form->create($<%= $singularVar %>); ?>
<%
foreach ($fields as $field) {
    if (in_array($field, $primaryKey)) {
        continue;
    }

    if (isset($keyFields[$field])) {
        $fieldData = $schema->column($field);
        if (!empty($fieldData['null'])) {
%>
                <div class="form-group">
                    <?= $this->Form->input('<%= $field %>', ['options' => $<%= $keyFields[$field] %>, 'empty' => true, 'class' => 'form-control']); ?>
                </div>

<%
        } else {
%>
                <div class="form-group">
                    <?= $this->Form->input('<%= $field %>', ['options' => $<%= $keyFields[$field] %>, 'class' => 'form-control']); ?>
                </div>

<%
        }
        continue;
    }

    if (!in_array($field, ['created', 'modified', 'updated'])) {
        $fieldData = $schema->column($field);
        if (in_array($fieldData['type'], ['date', 'datetime', 'time'])) {
                if (!empty($fieldData['null'])) {
%>
                <div class="form-group">
                    <div class="input-group">
                        <?= $this->Form->input('<%= $field %>', ['empty' => true, 'type' => 'text', 'class' => 'form-control bootstrap-<%= $fieldData['type'] %>picker']); ?>
                    </div>
                </div>

<%
                } else {
%>
                <div class="form-group">
                    <div class="input-group">
                        <?= $this->Form->input('<%= $field %>', ['type' => 'text', 'class' => 'form-control bootstrap-<%= $fieldData['type'] %>picker']); ?>
                    </div>
                </div>

<%
                }


        } else if (in_array($fieldData['type'], ['boolean'])) {


            if (!empty($fieldData['null'])) {
%>
                <div class="form-group iCheck-input">
                    <?= $this->Form->input('<%= $field %>', ['empty' => true, 'class' => 'form-control']); ?>
                </div>

<%
            } else {
%>
                <div class="form-group iCheck-input">
                    <?= $this->Form->input('<%= $field %>', ['class' => 'form-control']); ?>
                </div>

<%
            }
        } else {
            if (!empty($fieldData['null'])) {
%>
                <div class="form-group">
                    <?= $this->Form->input('<%= $field %>', ['empty' => true, 'class' => 'form-control']); ?>
                </div>

<%
            } else {
%>
                <div class="form-group">
                    <?= $this->Form->input('<%= $field %>', ['class' => 'form-control']); ?>
                </div>

<%
            }

        }
    }
}

if (!empty($associations['BelongsToMany'])) {
    foreach ($associations['BelongsToMany'] as $assocName => $assocData) {
        %>
                <div class="form-group iCheck-input">
                    <?= $this->Form->input('<%= $assocData['property'] %>._ids', ['options' => $<%= $assocData['variable'] %>, 'multiple' => 'checkbox']); ?>
                </div>

<%
    }
}
%>
                <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-primary pull-right']); ?>
                <?= $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>
