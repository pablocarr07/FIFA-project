<?php
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;

Router::plugin(
    'TinyAuth',
    ['path' => '/tiny-auth'],
    function (RouteBuilder $routes) {
        $routes->fallbacks('DashedRoute');
    }
);
