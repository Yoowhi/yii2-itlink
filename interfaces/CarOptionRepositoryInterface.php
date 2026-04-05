<?php

namespace app\interfaces;

use app\entities\CarOption;

interface CarOptionRepositoryInterface
{
    public function save(CarOption $entity): CarOption;
}