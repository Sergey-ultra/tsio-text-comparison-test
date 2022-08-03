<?php


use App\Controller\ComparisonController;

return [
    [
        'uri' => "/",
        'method' => 'GET',
        'controller' => ComparisonController::class,
        'action' => 'index',
    ],
    [
        'uri' => "/compare",
        'method' => 'POST',
        'controller' => ComparisonController::class,
        'action' => 'compare'
    ],
];
