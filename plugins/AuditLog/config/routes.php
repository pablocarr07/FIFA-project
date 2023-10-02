<?php
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;

Router::plugin(
    'AuditLog',
    ['path' => '/audit-log'],
    function (RouteBuilder $routes) {
        $routes->fallbacks('DashedRoute');
    }
);
