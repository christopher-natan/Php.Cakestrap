<?php
use Cake\Routing\Router;

Router::plugin('Cakestrap', function ($routes) {
    $routes->fallbacks('InflectedRoute');
});
