<aside class="main-sidebar">
    <section class="sidebar">
        <div class="user-panel">
            <div class="pull-left image">
                <?= $this->Html->image('user2-160x160.jpg', array('class' => 'img-circle', 'alt' => 'User Image')); ?>
            </div>
            <div class="pull-left info">
                <p>Alexander Pierce</p>
                <?= $this->Html->link('<i class="fa fa-circle text-success"></i> Online', array('#'), array('escape' => false)); ?>
            </div>
        </div>

        <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
            <li class="active treeview">
                <?= $this->Html->link('<i class="fa fa-dashboard"></i> <span>Dashboard</span> <i class="fa fa-angle-left pull-right"></i>', array('#'), array('escape' => false)); ?>

                <ul class="treeview-menu">
                    <li class="active">
                        <?= $this->Html->link('<i class="fa fa-circle-o"></i> Dashboard v1', array('#'), array('escape' => false)); ?>
                    </li>
                </ul>
            </li>
            <li class="treeview">
                <?= $this->Html->link('<i class="fa fa-files-o"></i><span>Layout Options</span><span class="label label-primary pull-right">4</span>', array('#'), array('escape' => false)); ?>
            </li>
            <li>
                <?= $this->Html->link('<i class="fa fa-th"></i> <span>Widgets</span><small class="label pull-right bg-green">new</small>', array('#'), array('escape' => false)); ?>
            </li>
            <li class="treeview">
                <?= $this->Html->link('<i class="fa fa-pie-chart"></i><span>Charts</span><i class="fa fa-angle-left pull-right"></i>', array('#'), array('escape' => false)); ?>

                <ul class="treeview-menu">
                    <li>
                        <?= $this->Html->link('<i class="fa fa-circle-o"></i> ChartJS', array('#'), array('escape' => false)); ?>
                    </li>
                    <li>
                        <?= $this->Html->link('<i class="fa fa-circle-o"></i> Morris', array('#'), array('escape' => false)); ?>
                    </li>
                    <li>
                        <?= $this->Html->link('<i class="fa fa-circle-o"></i> Flot', array('#'), array('escape' => false)); ?>
                    </li>
                    <li>
                        <?= $this->Html->link('<i class="fa fa-circle-o"></i> Inline charts', array('#'), array('escape' => false)); ?>
                    </li>
                </ul>
            </li>
            <li class="treeview">
                <?= $this->Html->link('<i class="fa fa-laptop"></i><span>UI Elements</span><i class="fa fa-angle-left pull-right"></i>', array('#'), array('escape' => false)); ?>

                <ul class="treeview-menu">
                    <li>
                        <?= $this->Html->link('<i class="fa fa-circle-o"></i> General', array('#'), array('escape' => false)); ?>
                    </li>
                    <li>
                        <?= $this->Html->link('<i class="fa fa-circle-o"></i> Icons', array('#'), array('escape' => false)); ?>
                    </li>
                    <li>
                        <?= $this->Html->link('<i class="fa fa-circle-o"></i> Buttons', array('#'), array('escape' => false)); ?>
                    </li>
                    <li>
                        <?= $this->Html->link('<i class="fa fa-circle-o"></i> Sliders', array('#'), array('escape' => false)); ?>
                    </li>
                    <li>
                        <?= $this->Html->link('<i class="fa fa-circle-o"></i> Timeline', array('#'), array('escape' => false)); ?>
                    </li>
                    <li>
                        <?= $this->Html->link('<i class="fa fa-circle-o"></i> Modals', array('#'), array('escape' => false)); ?>
                    </li>
                </ul>
            </li>
            <li>
                <?= $this->Html->link('<i class="fa fa-calendar"></i> <span>Calendar</span><small class="label pull-right bg-red">3</small>', array('#'), array('escape' => false)); ?>
            </li>
            <li>
                <?= $this->Html->link('<i class="fa fa-envelope"></i> <span>Mailbox</span><small class="label pull-right bg-yellow">12</small>', array('#'), array('escape' => false)); ?>
            </li>
            <li class="treeview">
                <?= $this->Html->link('<i class="fa fa-share"></i> <span>Multilevel</span><i class="fa fa-angle-left pull-right"></i>', array('#'), array('escape' => false)); ?>

                <ul class="treeview-menu">
                    <li>
                        <?= $this->Html->link('<i class="fa fa-circle-o"></i> Level One', array('#'), array('escape' => false)); ?>
                    </li>
                    <li>
                        <a href="#">
                            <?= $this->Html->link('<i class="fa fa-circle-o"></i> Level One <i class="fa fa-angle-left pull-right"></i>', array('#'), array('escape' => false)); ?>
                        </a>
                        <ul class="treeview-menu">
                            <li>
                                <?= $this->Html->link('<i class="fa fa-circle-o"></i> Level Two', array('#'), array('escape' => false)); ?>
                            </li>
                            <li>
                                <?= $this->Html->link('<i class="fa fa-circle-o"></i> Level Two <i class="fa fa-angle-left pull-right"></i>', array('#'), array('escape' => false)); ?>
                                <ul class="treeview-menu">
                                    <li>
                                        <?= $this->Html->link('<i class="fa fa-circle-o"></i> Level Three', array('#'), array('escape' => false)); ?>
                                    </li>
                                    <li>
                                        <?= $this->Html->link('<i class="fa fa-circle-o"></i> Level Three', array('#'), array('escape' => false)); ?>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <?= $this->Html->link('<i class="fa fa-circle-o"></i> Level One', array('#'), array('escape' => false)); ?>
                    </li>
                </ul>
            </li>
            <li class="header">LABELS</li>
            <li>
                <?= $this->Html->link('<i class="fa fa-circle-o text-red"></i> <span>Important</span>', array('#'), array('escape' => false)); ?>
            </li>
            <li>
                <?= $this->Html->link('<i class="fa fa-circle-o text-yellow"></i> <span>Warning</span>', array('#'), array('escape' => false)); ?>
            </li>
            <li>
                <?= $this->Html->link('<i class="fa fa-circle-o text-aqua"></i> <span>Information</span>', array('#'), array('escape' => false)); ?>
            </li>
        </ul>
    </section>
</aside>