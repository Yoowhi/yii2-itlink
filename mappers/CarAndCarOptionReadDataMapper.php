<?php

namespace app\mappers;

use app\common\DataMapper;
use app\common\ReadMapperTrait;
use app\entities\Car;
use app\entities\CarOption;
use yii\db\Connection;
use yii\db\Query;

class CarAndCarOptionReadDataMapper extends DataMapper
{
    use ReadMapperTrait;

    public function __construct(
        private Connection $db
    ) {}

    protected function getConnection(): Connection
    {
        return $this->db;
    }

    protected function tableName(): string
    {
        return 'car';
    }

    protected function withRelations(Query $query)
    {
        return $query->leftJoin('car_option', 'car_option.car_id = car.id');
    }

    protected function selectColumns()
    {
        return [
            'car' => ['id', 'title', 'description', 'price', 'photo_url', 'contacts', 'created_at'],
            'car_option' => ['id', 'car_id', 'brand', 'model', 'year', 'body', 'mileage']
        ];
    }

    protected function arrayToEntity(array $array)
    {
        
        $car = $this->mapToEntity('car', $array, Car::class);
        $options = $this->mapToEntity('car_option', $array, CarOption::class);
        if ($options) {
            $car->options = $options;
        }
        return $car;
    }
}