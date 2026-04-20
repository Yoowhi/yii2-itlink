<?php

namespace app\services;

use app\dto\CreateCarDto;
use app\dto\CreateCarOptionDto;
use app\dto\SearchCarsDto;
use app\entities\Car;
use app\entities\CarOption;
use app\entities\Page;
use app\interfaces\CarOptionRepositoryInterface;
use app\interfaces\CarServiceInterface;
use app\interfaces\CarRepositoryInterface;
use app\interfaces\UnitOfWorkInterface;
use yii\base\Exception;

/**
 * @property-read CarRepositoryInterface $carRepository
 * @property-read CarOptionRepositoryInterface $carOptionRepository
 */
class CarService implements CarServiceInterface
{

    public function __construct(
        private CarRepositoryInterface $carRepository,
        private CarOptionRepositoryInterface $carOptionRepository,
        private UnitOfWorkInterface $uow
    ) {}

    public function createCar(CreateCarDto $carDto, ?CreateCarOptionDto $carOptionsDto = null): Car
    {
        $carResult = null;
        $this->uow->atomic(function() use ($carDto, $carOptionsDto, &$carResult) {
            $car = new Car();
            $car->title = $carDto->title;
            $car->description = $carDto->description;
            $car->price = $carDto->price;
            $car->photo_url = $carDto->photo_url;
            $car->contacts = $carDto->contacts;
            $car->created_at = date('Y-m-d H:i:s');
            $car = $this->carRepository->save($car);
            if ($carOptionsDto) {
                $options = new CarOption();
                $options->car_id = $car->id;
                $options->brand = $carOptionsDto->brand;
                $options->model = $carOptionsDto->model;
                $options->year = $carOptionsDto->year;
                $options->body = $carOptionsDto->body;
                $options->mileage = $carOptionsDto->mileage;
                $options = $this->carOptionRepository->save($options);
                $car->options = $options;
            }
            $carResult = $car;
        });
        if (is_null($carResult)) {
            throw new Exception('Cant save new car');
        }
        return $carResult;
    }

    public function findOneById(int $id): Car|null
    {
        return $this->carRepository->findOne($id);
    }

    public function findPage(SearchCarsDto $search): Page
    {
        return $this->carRepository->findPage(
            $search->page, 
            $search->limit
        );
    }
}