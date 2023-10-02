<?php
$baseDir = dirname(dirname(__FILE__));
return [
    'plugins' => [
        'AdminTheme' => $baseDir . '/plugins/AdminTheme/',
        'AuditLog' => $baseDir . '/plugins/AuditLog/',
        'Bake' => $baseDir . '/vendor/cakephp/bake/',
        'Bootstrap' => $baseDir . '/vendor/elboletaire/twbs-cake-plugin/',
        'BootstrapUI' => $baseDir . '/vendor/friendsofcake/bootstrap-ui/',
        'CsvView' => $baseDir . '/vendor/kongka/cakephp-csvview/',
        'DebugKit' => $baseDir . '/vendor/cakephp/debug_kit/',
        'Gourmet/KnpMenu' => $baseDir . '/vendor/gourmet/knp-menu/',
        'Less' => $baseDir . '/vendor/elboletaire/less-cake-plugin/',
        'Migrations' => $baseDir . '/vendor/cakephp/migrations/',
        'Search' => $baseDir . '/plugins/Search/',
        'Shim' => $baseDir . '/vendor/dereuromark/cakephp-shim/',
        'SoftDelete' => $baseDir . '/vendor/pgbi/cakephp3-soft-delete/',
        'TinyAuth' => $baseDir . '/plugins/TinyAuth/',
        'Tools' => $baseDir . '/vendor/dereuromark/cakephp-tools/',
        'Xety/Cake3Upload' => $baseDir . '/vendor/xety/cake3-upload/'
    ]
];