<?php

namespace app\interfaces;

use app\dto\CreateCarDto;
use app\dto\CreateCarOptionDto;
use app\dto\SearchCarsDto;
use app\entities\Car;
use app\entities\Page;

interface CarServiceInterface 
{
    public function createCar(CreateCarDto $carDto, ?CreateCarOptionDto $optionDto = null): Car;
    public function findOneById(int $id): Car|null;
    public function findPage(SearchCarsDto $search): Page;
}