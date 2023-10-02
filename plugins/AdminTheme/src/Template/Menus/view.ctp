<div class="row">
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title"><?= __('Menus'); ?></h3>

                <div class="pull-right">
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                            <?= __('Actions'); ?>&nbsp;
                            <span class="fa fa-caret-down"></span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li><?= $this->Html->link(__('Edit Menu'), ['action' => 'edit', $menu->id]); ?></li>
                            <li><?= $this->Form->postLink(__('Delete Menu'), ['action' => 'delete', $menu->id], ['confirm' => __('Are you sure you want to delete # {0}?', $menu->id)]); ?></li>
                            <li><?= $this->Html->link(__('List Menus'), ['action' => 'index']); ?></li>
                            <li><?= $this->Html->link(__('New Menu'), ['action' => 'add']); ?></li>
                            <li><?= $this->Html->link(__('List Parent Menus'), ['controller' => 'Menus', 'action' => 'index']); ?></li>
                            <li><?= $this->Html->link(__('New Parent Menu'), ['controller' => 'Menus', 'action' => 'add']); ?></li>
                            <li><?= $this->Html->link(__('List Roles'), ['controller' => 'Roles', 'action' => 'index']); ?></li>
                            <li><?= $this->Html->link(__('New Role'), ['controller' => 'Roles', 'action' => 'add']); ?></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="box-body">
                <table class="table table-striped table-bordered">
                    <tr>
                        <th><?= __('Id'); ?></th>
                        <td><?= $this->Number->format($menu->id); ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Lft'); ?></th>
                        <td><?= $this->Number->format($menu->lft); ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Rght'); ?></th>
                        <td><?= $this->Number->format($menu->rght); ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Name'); ?></th>
                        <td><?= h($menu->name); ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Parent Menu'); ?></th>
                        <td><?= $menu->has('parent_menu') ? $this->Html->link($menu->parent_menu->name, ['controller' => 'Menus', 'action' => 'view', $menu->parent_menu->id]) : ''; ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Link'); ?></th>
                        <td><?= h($menu->link); ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Created'); ?></th>
                        <td><?= h($menu->created); ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Modified'); ?></th>
                        <td><?= h($menu->modified); ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Visible'); ?></th>
                        <td><?= $menu->visible ? __('<i class="fa fa-check text-green"></i>') : __('<i class="fa fa-times text-red"></i>'); ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
