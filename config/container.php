<?php

use app\interfaces\CarOptionRepositoryInterface;
use app\interfaces\CarRepositoryInterface;
use app\services\CarService;
use app\interfaces\CarServiceInterface;
use app\repositories\CarOptionRepository;
use app\repositories\CarRepository;
use yii\db\Connection;

return [
    'definitions' => [
        CarServiceInterface::class => CarService::class,
        CarRepositoryInterface::class => CarRepository::class,
        CarOptionRepositoryInterface::class => CarOptionRepository::class,
        Connection::class => $db,
    ]
];