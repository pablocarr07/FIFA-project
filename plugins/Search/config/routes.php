<?php
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;

Router::plugin(
    'Search',
    ['path' => '/search'],
    function (RouteBuilder $routes) {
        $routes->fallbacks('DashedRoute');
    }
);
