<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title"><?= __('Edit Menu') ?></h3>

                <div class="pull-right">
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                            <?= __('Actions'); ?>&nbsp;
                            <span class="fa fa-caret-down"></span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li><?= $this->Form->postLink(__('Delete'),
                                    ['action' => 'delete', $menu->id],
                                    ['confirm' => __('Are you sure you want to delete # {0}?', $menu->id)]); ?></li>
                            <li><?= $this->Html->link(__('List Menus'), ['action' => 'index']); ?></li>
                            <li><?= $this->Html->link(__('List Parent Menus'), ['controller' => 'Menus', 'action' => 'index']); ?></li>
                            <li><?= $this->Html->link(__('New Parent Menu'), ['controller' => 'Menus', 'action' => 'add']); ?></li>
                            <li><?= $this->Html->link(__('List Roles'), ['controller' => 'Roles', 'action' => 'index']); ?></li>
                            <li><?= $this->Html->link(__('New Role'), ['controller' => 'Roles', 'action' => 'add']); ?></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="box-body">
                <?= $this->Form->create($menus); ?>
                <div class="form-group">
                    <?= $this->Form->input('name', ['class' => 'form-control']); ?>
                </div>

                <div class="form-group">
                    <?= $this->Form->input('parent_id', ['options' => $parentMenus, 'class' => 'form-control','empty' => '(choose menu)']); ?>
                </div>

                <div class="form-group">
                    <?= $this->Form->input('link', ['class' => 'form-control']); ?>
                </div>

                <div class="form-group iCheck-input">
                    <?= $this->Form->input('visible', ['empty' => true, 'class' => 'form-control']); ?>
                </div>

                <div class="form-group iCheck-input">
                    <?= $this->Form->input('roles._ids', ['options' => $roles, 'multiple' => 'checkbox']); ?>
                </div>

                <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-primary pull-right']); ?>
                <?= $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>
